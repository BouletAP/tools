<?php

namespace BouletAP;

class Dates {
    
    

    static function initTimestampFR($date) {
        $fr = self::months();
        $en = self::months(true);
        $date = str_replace($fr, $en, $date);
        return strtotime($date);
    }


    static function months($en = false) {
        $output = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        $outputen = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
        return $en ? $outputen : $output;
    }

}