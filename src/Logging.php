<?php

namespace BouletAP;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Logging {
    
    
    // singleton to allow global access 
    // static private $instance = false;
    // private function __construct() {}
    // static public function getInstance() {
    //     if( !static::$instance ) {
    //         static::$instance = new static();
            
    //         if (session_status() === PHP_SESSION_NONE) {
    //             session_start();
    //         }
    //         $logs = get_option('bouletap_debuglogs', -1);
    //         if( $logs == -1 ) {
    //             $logs = array();
    //             add_option('bouletap_debuglogs', json_encode($logs));
    //         }
    //         update_option('bouletap_debuglogs', $attachment_id);     
    //         delete_option('bouletap_debuglogs');
    //     }
    //     return static::$instance;
    // }
    
    static public function reset() { 
        delete_option('bouletap_debuglogs');
        $logs = array();
        add_option('bouletap_debuglogs', json_encode($logs));     
    }

    static public function add($line, $inline = false) {
        $logs = get_option('bouletap_debuglogs', -1);
        if( $logs === -1 ) {
            $logs = array();
            add_option('bouletap_debuglogs', json_encode($logs));
        }
        else {
            $logs = json_decode($logs);
        }
        if( $inline && count($logs) > 0 ) {
            $logs[ count($logs) - 1 ] = $logs[ count($logs) - 1 ] ." ". $line;
        }
        else {
            $logs []= $line;
        }
        update_option('bouletap_debuglogs', json_encode($logs));     
    }

    static public function findAll() {     
        $logs = get_option('bouletap_debuglogs', -1);
        if( $logs === -1 ) {
            $logs = array();
        }
        else {
            $logs = json_decode($logs);
        }
        return $logs;
    }

    static public function print() {
        $logs = self::findAll();
        $output = "";
        //$base_url = admin_url('admin.php?page='.GABOTEUR_MIGRATION_MODULE.'&action=export-editions&subaction=');
        foreach( $logs as $key => $line ) {
            $output .= 'Line '.($key+1).'. <span>'.$line.'</span><br>';
        }
        echo $output;
    }
}