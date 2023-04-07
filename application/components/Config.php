<?php

namespace application\components;
class Config
{
    private const PATH = 'application/config/web.json';
    static function get() {
        return json_decode(file_get_contents(self::PATH), JSON_OBJECT_AS_ARRAY);
    }

    static function set($config) {
        file_put_contents(self::PATH, json_encode($config));
    }
}