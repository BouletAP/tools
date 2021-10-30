<?php

namespace BouletAP;

class Files { 

    static public function extractFilename($dir) {        
        return substr($dir, strrpos($dir, '/')+1);
    }

    public static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    
    static public function BackupMedias($item, $mediasConfig, $target_folder) {


        $files = array();
        foreach( $mediasConfig as $attribute => $config ) {
            if( !empty($item->$attribute) ) {

                $media_url = $item->$attribute;

                $upload_dir   = wp_upload_dir();
                $dir = substr($media_url, strpos($media_url, 'uploads/')+7);
                $source_path = $upload_dir['basedir']. $dir;
                $filename = substr($dir, strrpos($dir, '/')+1);

                \BouletAP\Logging::add("File found: <a target='_blank' href='{$media_url}'>{$filename}</a>.");
                
                $imgdata = getimagesize($source_path);
                if( $imgdata && $config['type'] == 'image' ) {     
                    
                    
                    $w = $imgdata[0];
                    $h = $imgdata[1];
                    $type = $imgdata['mime'];
                    \BouletAP\Logging::add("{$type} ({$w}x{$h}px).", true);  

                    $perfect_image = true;
                    // 1. Fix filename
                    // @todo ? maybe, maybe not


                    // 2. Scale image to best ratio & copy to destination folder
                    $max_width = !empty($config['width']) ? $config['width'] : false;
                    $max_height = !empty($config['height']) ? $config['height'] : false;

                    if( ($max_width && $w > $max_width) || ($max_height && $h > $max_height) ) {
                        list($w2, $h2) = \BouletAP\Images::resizeToRatio($source_path, $target_folder, $filename, $config['ratio'], $max_width, $max_height);  
                        \BouletAP\Logging::add("Resized to: {$w2}x{$h2}.", true);  
                        $source_path = $target_folder."/".$filename;
                        $perfect_image = false;
                    }

                    // 3. Convert PNG pictures to JPG. 
                    if( strpos($type, 'png') !== false ) {
                        \BouletAP\Logging::add('Converting PNG to JPG...', true);  
                        $newimage = \BouletAP\Images::convertPNGtoJPG($source_path);
                        \BouletAP\Logging::add('<a target="_blank" href="'.$newimage.'">YES (view JPG!)</a>', true);  
                        $perfect_image = false;
                    }

                    if( $perfect_image ) {
                        // copy to backup asis
                        copy($source_path, $target_folder."/".$filename);
                    }
                    
                }
                else {
                    
                    // 1. Fix filename

                    // 2. Simple file copy
                    copy($source_path, $target_folder."/".$filename);
                    \BouletAP\Logging::add('... Copied', true);  
                }
                

                $files []= $target_folder."/".$filename;
            }
        }
        return $files; 
    }

}