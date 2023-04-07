<?php
namespace application\components;
class AmoCrm
{
    private string $endpoint;
    public array $configs;

    public function __construct($configs)
    {
        $this->configs = $configs;
        $this->endpoint = $this->configs['end_point'];
    }

    private function call(string $url, array $params, string $access_token = ''): ?array
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => ['Content-Type:application/json', 'Authorization: Bearer ' . $access_token],
            CURLOPT_POSTFIELDS => json_encode($params)
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, JSON_OBJECT_AS_ARRAY);
    }

    public function addDeal(string $name, int $price, string $phone, string $email): ?array
    {
        $this->setAccessToken();
        return $this->call("$this->endpoint/api/v4/leads/complex", [[
            'name' => $name,
            'price' => $price,
            '_embedded' => [
                'contacts' => [
                    [
                        'first_name' => $name,
                        'custom_fields_values' => [
                            [
                                "field_id" => 49119,
                                "values" => [
                                    [
                                        "value" => $phone
                                    ]
                                ]
                            ],
                            [
                                "field_id" => 49121,
                                "values" => [
                                    [
                                        "value" => $email
                                    ]
                                ]
                            ],
                        ]
                    ],
                ]
            ]
        ]
        ], $this->configs['access_token']
        );
    }

    private function setAccessToken()
    {
        if ($this->configs['access_token'] == '') {
            $tokens = $this->getTokens('authorization_code');
            $this->configs['access_token'] = $tokens['access_token'] ?? '';
            $this->configs['refresh_token'] = $tokens['refresh_token'] ?? '';
            $this->configs['expires_in'] = date('Y-m-d H:i:s', strtotime('+1 days'));
            Config::set($this->configs);
        }
        if (strtotime($this->configs['expires_in']) <= strtotime(date('Y-m-d H:i:s'))) {
            $tokens = $this->getTokens('refresh_token');
            $this->configs['access_token'] = $tokens['access_token'] ?? '';
            $this->configs['expires_in'] = date('Y-m-d H:i:s', strtotime('+1 days'));
            Config::set($this->configs);

        }
    }

    private function getTokens(string $grant_type): ?array
    {
        return $this->call("$this->endpoint/oauth2/access_token",
            [
                'client_id' => $this->configs['client_id'],
                'client_secret' => $this->configs['client_secret'],
                'grant_type' => $grant_type,
                'code' => $this->configs['auth_code'],
                'redirect_uri' => $this->configs['redirect_uri']
            ]
        );
    }
}