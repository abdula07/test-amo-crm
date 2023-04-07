<?php
namespace application\models\forms;

class DealCreateForm
{
    public array $errors = [];
    public string $name;
    public string $email;
    public string $phone;
    public int $price;

    public function load($data)
    {
        if (!isset($data['token'])) {
            $this->errors['token'] = "Токен не установлен";
        }
        if (!isset($data['name'])) {
            $this->errors['name'] = "Имя не заполнено";
        }
        if (!isset($data['email'])) {
            $this->errors['email'] = "email не заполнен";
        }
        if (!isset($data['phone'])) {
            $this->errors['phone'] = "Телефон не заполнен";
        }
        if (!isset($data['price'])) {
            $this->errors['price'] = "Цена не заполнено";
        }
        if (!empty($this->errors)) {
            return false;
        }
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];
        $this->price = $data['price'];
        if (isset($_SESSION['token']) && $data['token'] != $_SESSION['token']) {
            $this->errors['token'] = "Неверный токен";
        }
        if (!$this->name) {
            $this->errors['name'] = "Не корректное имя";
        }
        if (!$this->phone) {
            $this->errors['phone'] = "Не корректный телефон";
        }
        if (!$this->price) {
            $this->errors['price'] = "Не корректная цена";
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Не корректная почта";
        }
        if (!empty($this->errors)) {
            return false;
        }
        return true;
    }
}