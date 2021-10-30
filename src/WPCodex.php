<?php

namespace BouletAP;

class WPCodex {
    
    // static public function insertAttachmentPDF($file, $post_id, $date = false) {
        
    //     if( !$date ) $date = time();
    //     $wp_upload_dir = wp_upload_dir(date('Y m', $date));

    //     $filetype = wp_check_filetype( basename( $file ), null );
            
    //     $attachment = array(
    //         'guid'           => $wp_upload_dir['url'] . '/' . basename( $file ), 
    //         'post_mime_type' => $filetype['type'],
    //         'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file ) ),
    //         'post_content'   => '',
    //         'post_status'    => 'inherit'
    //     );
        
    //     $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
    //     return $attach_id;
    // }

    static public function insertAttachmentFromFile($file, $post_id, $date = false) {
        
        if( !$date ) $date = time();
        $wp_upload_dir = wp_upload_dir(date('Y m', $date));

        $filetype = wp_check_filetype( basename( $file ), null );
            
        $attachment = array(
            'guid'           => $wp_upload_dir['url'] . '/' . basename( $file ), 
            'post_mime_type' => $filetype['type'],
            'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file ) ),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );
        
        $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );            
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        wp_update_attachment_metadata( $attach_id, $attach_data );     
        return $attach_id;
    }

}