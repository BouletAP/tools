<?php

namespace BouletAP\Tools;

class Cookies {
    

    static public function add($cookie_name, $cookie_value, $timer) {        
        setcookie($cookie_name, $cookie_value, time() + $timer, "/"); 
    }

    static public function find($cookie_name, $default = false) {
        return isset($_COOKIE[$cookie_name]) ? $_COOKIE[$cookie_name] : $default;
    }
}