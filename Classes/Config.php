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
        
        dbopts = parse_url(getenv('DATABASE_URL'));
        
        self::$botConfigs["DBHost"] = $dbopts["host"];
        self::$botConfigs["DBUser"] = $dbopts["user"];
        self::$botConfigs["DBPass"] = $dbopts["pass"];
        self::$botConfigs["DBName"] = ltrim($dbopts["path"],'/');
    }
}

Config::_init();
