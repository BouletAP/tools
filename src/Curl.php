<?php


namespace BouletAP;

class Curl {
    
  public $cookies = false;

  public function post_json($url, $data = array()) {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json") );

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }

  
  public function post($url, $data = array()) {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded") );

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }

  public function get($url) {

    if( !empty($data) ) {
        $querystring = http_build_query($data);

        if( strpos($url, "?") !== FALSE ) {
            $url .= "?";
        }
        
        $url .= $querystring;
    }
    
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    if( !empty($this->cookies) ) {
      $cookie_string = implode(';', $this->cookies);
      curl_setopt($ch, CURLOPT_COOKIE, $cookie_string);
    }

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }

  public function put($url, $data) {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded") );

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }

  

  public function delete($url) {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded") );

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }
}