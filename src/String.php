<?php

namespace BouletAP;

// fallback attempt if real secrets is not created.
//require_once(__DIR__.'/../configs/secrets.ex.php');

class Stringz
{

    // depth -1 return all found
    static public function getContent($delimiter_start, $delimiter_end, $subject) {

        $output = [];

        $splits = explode($delimiter_start, $subject);

        if( count($splits) > 1  ) {
            for($i=1;$i<count($splits);$i++) {
                $target = substr($splits[$i], 0, strpos($splits[$i], $delimiter_end));
                $output []= $target;
            }
        }
        
        return $output;
    }

}