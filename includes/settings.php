<?php

/**
 * Settings Routes
 * 
 * @package WP_REST_ROUTES
 * 
 * Inspiration for this part of the plugin comes from the wp-api-menus plugin
 * URI: https://github.com/nekojira/wp-api-menus
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Settings_Routes' ) ) :

    /**
     * Settings_Routes class
     * 
     * @package WP_REST_ROUTES
     * @since 1.0.3
     */
    class Settings_Routes {

       /**
         * namespace for the wordpress rest api
         * 
         * @since 1.0
         * @return string
         */
        public static function get_api_namespace() {
            return 'wp/v2';
        }

        /**
         * namespace for the plugin api
         * 
         * @since 1.0
         * @return string
         */

        public static function get_plugin_namespace() {
            return 'wp-rest-routes/v2';
        }

        /** register routes for WP API v2
         * 
         * @since 1.0.3
         * 
         */
        public function register_routes() {
            register_rest_route( self::get_plugin_namespace(), '/settings/all', array(
                array(
                    'methods' => 'GET',
                    'callback' => array( $this, 'get_site_settings' )
                )
                ));
        }

        /**
         * get site settings
         * 
         * @since 1.0.3
         * @return array of site settings
         */
        public function get_site_settings() {
            $site_title = get_bloginfo('name');
            $site_description = get_bloginfo('description');
            $header_image = get_header_image();

            $settings = array(
                'title'         =>  $site_title,
                'description'   =>  $site_description,
                'header_image'  =>  $header_image
            );

            return $settings;
        }

    }

endif;

//site_title

//tagline

//header media



/** 
 * Future options:
 * color scheme
 * homepage settings, either a homepage or blog
 * Theme options with section content and page layout (one column or two)
 * 
 * 