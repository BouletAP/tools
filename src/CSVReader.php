<?php

namespace BouletAP\Tools;

class CSVReader {
    
    

    static function read($filepath, $has_headers = true) {

      $row = 1;
      $output = false;
      if (($handle = fopen($filepath, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          $num = count($data);
          if( $has_headers && $row === 1) {
            // $output = [];
            // for ($c=0; $c < $num; $c++) {
            //   echo $output[$row] = $data[$c];
            // }
          }
          else{
            $output[$row] = [];
            for ($c=0; $c < $num; $c++) {
              $output[$row] []= $data[$c];
            }
          }       
          $row++;   
        }
        fclose($handle);
      }
      return $output;
    }

    static function push($filepath, $data, $targetRow = false) {

      $row = 1;
      $output = false;
      
      if( file_exists($filepath) ) {
        @unlink($filepath);
      }

      $file = fopen($filepath,'a');  // 'a' for append to file - created if doesn't exit
      foreach ($data as $line) {
        fputcsv($file, $line);
        $output = true;
      }
      fclose($file); 
      
      return $output;
    }


  //   static function read($filepath) {
  //     $row = 1;
  //     if (($handle = fopen($filepath, "r")) !== FALSE) {
  //       while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
  //         $num = count($data);
  //         echo "<p> $num fields in line $row: <br /></p>\n";
  //         $row++;
  //         for ($c=0; $c < $num; $c++) {
  //             echo $data[$c] . "<br />\n";
  //         }
  //       }
  //       fclose($handle);
  //     }
  // }
}