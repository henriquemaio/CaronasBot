<?php
class Config{
    private static $botConfigs = array();

    public static function getBotConfig($nomeConfig){
        if(array_key_exists($nomeConfig, self::$botConfigs)) return self::$botConfigs[$nomeConfig];
        else return NULL;
    }

    public static function _init(){
        self::$botConfigs["botName"] = array_key_exists("BOT_NAME", $_ENV) ? $_ENV["BOT_NAME"] : "botName";
        self::$botConfigs["ApiKeyTelegram"] = array_key_exists("API_KEY_TELEGRAM", $_ENV) ? $_ENV["API_KEY_TELEGRAM"] : NULL;
        self::$botConfigs["ApiRequestUrl"] = array_key_exists("API_KEY_TELEGRAM", $_ENV) ? 'https://api.telegram.org/bot' . $_ENV["API_KEY_TELEGRAM"] : NULL;
        self::$botConfigs["DBHost"] = array_key_exists("DB_HOST", $_ENV) ? $_ENV["DB_HOST"] : NULL;
        self::$botConfigs["DBUser"] = array_key_exists("DB_USER", $_ENV) ? $_ENV["DB_USER"] : NULL;
        self::$botConfigs["DBPass"] = array_key_exists("DB_PASS", $_ENV) ? $_ENV["DB_PASS"] : NULL;
        self::$botConfigs["DBName"] = array_key_exists("DB_NAME", $_ENV) ? $_ENV["DB_NAME"] : NULL;
    }
}

Config::_init();