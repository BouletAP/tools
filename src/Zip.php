<?php

namespace BouletAP;

class Zip { 

    static function extract($source, $destination, $cleanup = true){
        if( file_exists($source) ) {
            $zip = new \ZipArchive;
            $res = $zip->open($source);
            if ($res === TRUE) {
                $zip->extractTo($destination);
                $zip->close();
                if($cleanup) @unlink($source);
            } 
        }
        return true;
    }

    static function archive($files, $target){
        if( !is_array($files) ) $files = array($files);
        $zip = new \ZipArchive;
        if ($zip->open($target, \ZipArchive::CREATE) === TRUE)
        {
            foreach($files as $r) {
                $name = substr($r, strrpos($r, '/')+1);
                $zip->addFile($r, $name);
            }
            $zip->close();
        }
        return true;
    }
}