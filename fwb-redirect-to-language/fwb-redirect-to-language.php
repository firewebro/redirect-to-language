<?php
/*
Plugin Name: Redirect to language
Description: WordPress Plugin for redirecting public website traffic to specific language.
Author: FireWeb
AuthorURI: https://fireweb.ro
Version: 1.0
*/
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// redirect function, pluggable
if( !function_exists("fwb_redirect_to_language") ){
    function fwb_redirect_to_language(){
        if(!session_id()) {
            session_start();
        }
        // wpml current language
        $redirect_language = 'ro';
        $site_language = ICL_LANGUAGE_CODE;
        if($site_language != $redirect_language && is_front_page()) {
            // Check if cookie is already set
            if($_COOKIE['fwb_rtl_redirect'] != $redirect_language) {
                $redirect = true;
                if($_SESSION['fwb_rtl_redirect'] == $redirect_language) {
                    $redirect = false;
                }
                if($redirect === true){
                    setcookie('fwb_rtl_redirect',  $redirect_language, time()+60*60*24*30);
                    $_SESSION['fwb_rtl_redirect'] = $redirect_language;

                    wp_safe_redirect( '/'.$redirect_language );
                    exit;
                }
            }
        }
    }
}

// hook redirect
add_action( 'wp', 'fwb_redirect_to_language' );