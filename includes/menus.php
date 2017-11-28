<?php
/**
 * Menu Routes
 * 
 * @package WP_REST_ROUTES
 * 
 * Inspiration for this part of the plugin comes from the wp-api-menus plugin
 * URI: https://github.com/nekojira/wp-api-menus
 */

if ( ! class_exists( 'Menu_Routes' ) ) :

    /**
     * Menu_Routes class
     * 
     * @package WP_REST_ROUTES
     * @since 1.0
     */
    class Menu_Routes {

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
            return 'wp-rest-routes/v1';
        }

        /** register routes for WP API v2
         * 
         * @since 1.0
         * 
         */
        public function register_routes() {

            register_rest_route( self::get_plugin_namespace(), '/menus', array(
                array(
                    'methods' => 'GET',
                    'callback' => 'get_menus'
                )
                ));

            register_rest_route( self::get_plugin_namespace(), '/menus/(?P<id>\d+)', array(
                array(
                    'methods' => 'GET',
                    'callback' => 'get_menu'
                )
                ));
        }

        /**
         * Get Menus
         * 
         * @since 1.0
         * @return array All menus
         * 
         * the original plugin sanitized the data, and made it look all pretty.  Maybe for v2
         */
        public static function get_menus() {
            $wp_menus = wp_get_nav_menus();

            return $wp_menus;
        }

        /**
         * Gets a Single Menu
         * 
         * @since 1.0
         * @return array Menu data
         * 
         * same as get menus.  Things could be prettier.
         */
        public function get_menu( $request ) {
            $id = (int) $request['id'];
            $wp_menu_items = wp_get_nav_menu_items( $id );

            return $wp_menu_items;
        }

        //future features: add support for nested menu items and menu location
    }

endif;