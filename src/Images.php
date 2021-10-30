<?php

namespace BouletAP;

class Images { 

    static function resizeToRatio($source, $dest, $filename, $ratio, $maxW = false, $maxH = false){

        list($width, $height) = getimagesize($source);

        if( $width > $maxW ) {
            $newWidth = $maxW;
            $newHeight = $height * ($newWidth/$width);
        }
        else if( $height > $maxH ) {
            $newWidth = $width * ($newHeight/$height);
            $newHeight = $maxH;
        }


        self::resize($source, $dest, $filename, $newWidth, $newHeight);

        return array($newWidth, $newHeight);
    }


    static function resize($source, $dest, $name, $w, $h = -1) {

        if( strpos(strtolower($name), '.png')) {            
            $image = imagecreatefrompng($source);   // For PNG
            $imgResized = imagescale($image, $w, $h);
            imagepng($imgResized, $dest."/".$name); //for png
        }
        else {
            $image = imagecreatefromjpeg($source);   
            $imgResized = imagescale($image, $w, $h);
            imagejpeg($imgResized, $dest."/".$name); 
        }
         imagedestroy($imgResized);
    }
    

    static public function convertPNGtoJPG($filePath) {
        $image = imagecreatefrompng($filePath);
        $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
        
        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
        imagealphablending($bg, TRUE);
        
        imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
        imagedestroy($image);
        
        $filename = substr($filePath, 0, strlen($filePath)-3) . "jpg";
        $quality = 50; // 0 = worst / smaller file, 100 = better / bigger file 
        imagejpeg($bg, $filename, $quality);
        imagedestroy($bg);
        return $filename;
    }
}