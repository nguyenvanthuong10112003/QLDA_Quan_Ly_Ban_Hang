<?php 
class ValidationStringHelper {
    public static function allIsNumber(string $str): bool {
        for ($i = 0; $i < strlen($str); $i++)   
            if ($str[$i] > '9' || $str[$i] < '0')
                return false;
        return true;
    }
    public static function allIsLower(string $str): bool {
        for ($i = 0; $i < strlen($str); $i++)   
            if ($str[$i] > 'z' || $str[$i] < 'a')
                return false;
        return true;
    }
    public static function allIsUpper(string $str): bool {
        for ($i = 0; $i < strlen($str); $i++)   
            if ($str[$i] > 'Z' || $str[$i] < 'A')
                return false;
        return true;
    }
    public static function allIsAlphabet(string $str): bool {
        for ($i = 0; $i < strlen($str); $i++)   
            if (!(($str[$i] <= 'z' && $str[$i] >= 'a') || 
                ($str[$i] <= 'Z' && $str[$i] >= 'A')))
                return false;
        return true;
    }
    public static function hadNumber(string $str): bool {
        for ($i = 0; $i < strlen($str); $i++)   
            if ($str[$i] <= '9' && $str[$i] >= '0')
                return true;
        return false;
    }
    public static function hadAlphabet(string $str): bool {
        for ($i = 0; $i < strlen($str); $i++)   
            if (($str[$i] <= 'z' && $str[$i] >= 'a') || 
                ($str[$i] <= 'Z' && $str[$i] >= 'A'))
                return true;
        return false;
    }
    public static function hadLower(string $str): bool {
        for ($i = 0; $i < strlen($str); $i++)   
            if ($str[$i] <= 'z' && $str[$i] >= 'a')
                return true;
        return false;
    }
    public static function hadUpper(string $str): bool {
        for ($i = 0; $i < strlen($str); $i++)   
            if ($str[$i] <= 'Z' && $str[$i] >= 'A')
                return true;
        return false;
    }
    public static function hadKey(string $str, string $key) {
        for ($i = 0; $i < strlen($str); $i++)   
            if ($str[$i] === $key[0])
                return true;
        return false;
    }
}