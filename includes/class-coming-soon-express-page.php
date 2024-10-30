<?php

class Coming_Soon_Express_Page {

    //* Define vars
    private $comingsoon_rendered = false;

    /**
     * Display the default template
     */
    public function get_default_template(){

        $file = file_get_contents( CSEXPRESS_TEMPLATE_PATH . '/index.php' );
        return $file;

    }

    /**
     * Display the coming soon page
     */
    public function csx_display_comingsoon_page() {

    	// extract(seed_csp4_get_settings());

        // if ( !isset($status)){
        //     $err =  new WP_Error('error', __("Please enter your settings.", 'coming_soon_express_domain'));
        //     echo $err->get_error_message();
        //     exit();
        // }

        if ( empty( $_GET['cs_preview'] ) ) {
            $_GET['cs_preview'] = false;
        }

        // Check if Preview
        $is_preview = false;
        if ( ( isset( $_GET['cs_preview'] ) && $_GET['cs_preview'] == 'true' ) ) {
            $is_preview = true;
        }

        // // Exit if a custom login page
        // if ( empty( $disable_default_excluded_urls ) ) {
        //     if ( preg_match( "/login|admin|dashboard|account/i", $_SERVER['REQUEST_URI'] ) > 0 && $is_preview == false ){
        //         return false;
        //     }
        // }


        // Check if user is logged in.
        if ( $is_preview === false ) {
            if ( is_user_logged_in() ) {
                // return false;
            }
        }

        // If we made it this far, show the coming soon page
        $this->comingsoon_rendered = true;


        // // set headers for Maintenance mode
        // if ( $status == '2' ) {
        //     header('HTTP/1.1 503 Service Temporarily Unavailable');
        //     header('Status: 503 Service Temporarily Unavailable');
        //     header('Retry-After: 86400'); // retry in a day
        //     // $csp4_maintenance_file = WP_CONTENT_DIR."/maintenance.php";
        //     // if ( !empty( $enable_maintenance_php ) and file_exists( $csp4_maintenance_file ) ) {
        //     //     include_once( $csp4_maintenance_file );
        //     //     exit();
        //     // }
        // }

        // Prevetn Plugins from caching
        // Disable caching plugins. This should take care of:
        //   - W3 Total Cache
        //   - WP Super Cache
        //   - ZenCache (Previously QuickCache)
        if ( !defined('DONOTCACHEPAGE')) {
          define('DONOTCACHEPAGE', true);
        }
        if ( !defined('DONOTCDN')) {
          define('DONOTCDN', true);
        }
        if ( !defined('DONOTCACHEDB')) {
          define('DONOTCACHEDB', true);
        }
        if ( !defined('DONOTMINIFY')) {
          define('DONOTMINIFY', true);
        }
        if ( !defined('DONOTCACHEOBJECT')) {
          define('DONOTCACHEOBJECT', true);
        }
        header('Cache-Control: max-age=0; private');


        // Define template via function which returns template file
        $template = $this->get_default_template();

        // Load Functions to insert page content
        require_once( CSEXPRESS_TEMPLATE_PATH . '/functions.php' );

        // Array of tags to replace
        $template_tags = array(
            '{Title}' => seed_csp4_title(),
            '{MetaDescription}' => seed_csp4_metadescription(),
            '{CustomCSS}' => seed_csp4_customcss(),
            '{Head}' => seed_csp4_head(),
            '{Footer}' => seed_csp4_footer(),
            '{Logo}' => seed_csp4_logo(),
            '{Headline}' => seed_csp4_headline(),
            '{Description}' => seed_csp4_description(),
            '{Credit}' => seed_csp4_credit(),
        );

        echo strtr( $template, $template_tags );

        exit();

    }

}
