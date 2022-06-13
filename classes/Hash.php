<?php

class Hash {
    public static function make($string) {
        return hash('sha256', $string);
    }

    public static function salt($length) {
        return random_bytes($length);
    }

    public static function unique() {
        return self::make(uniqid());
    }
}