<?php

/**
 * Widget Routes
 * 
 * @package WP_REST_ROUTES
 * 
 * Inspiration for this part of the plugin comes from the wp-api-menus plugin
 * URI: https://github.com/nekojira/wp-api-menus
 */

 // this is currently throwing an error when added to the routes

 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Widget_Routes' ) ) :

    /**
     * Widget_Routes class
     * 
     * @package WP_REST_ROUTES
     * @since 1.0
     */
    class Widget_Routes {

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
         * @since 1.0.4
         * 
         */
        public function register_routes() {

            register_rest_route( self::get_plugin_namespace(), '/widgets', array(
                array(
                    'methods' => 'GET',
                    'callback' => array( $this, 'get_widgets' )
                )
                ));
        }

        /**
         * get widgets
         * 
         * @since 1.0.4
         * @return array of widgets
         */
        public function get_widgets() {
            $widgets = array_keys( $GLOBALS['wp_widget_factory']->widgets);

            return $widgets;
        }
    }

endif;