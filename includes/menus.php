<?php
/**
 * Menu Routes
 * 
 * @package WP_REST_ROUTES
 * 
 * Inspiration for this part of the plugin comes from the wp-api-menus plugin
 * URI: https://github.com/nekojira/wp-api-menus
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

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
            return 'wp-rest-routes/v2';
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
                    'callback' => array( $this, 'get_menus' )
                )
                ));

            register_rest_route( self::get_plugin_namespace(), '/menus/(?P<id>\d+)', array(
                array(
                    'methods' => 'GET',
                    'callback' => array( $this, 'get_menu' )
                )
                ));

            register_rest_route( self::get_plugin_namespace(), '/menus/all', array(
                array(
                    'methods' => 'GET',
                    'callback' => array( $this, 'get_all_menus' )
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
        public function get_menus() {
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

        /**
         * Get All Menus
         * 
         * @since 1.0.1
         * @return array of all menus
         * 
         */
        public function get_all_menus () {
            $list_of_menus = self::get_menus();

            $all_menus = array();
            
            foreach ($list_of_menus as $menu) {
                $single_menu = (array) $menu;

                $term_id = $single_menu['term_id'];

                $current_menu = wp_get_nav_menu_items( $term_id );

                $new_menu = (array) $current_menu;

                $sanitized_menu = array(
                    'name' => $single_menu['name'],
                    'slug' => $single_menu['slug'],
                    'items' => $new_menu
                );

                $all_menus[] = $sanitized_menu;

            }

            return $all_menus;
        }

        //future features: add support for nested menu items and menu location
    }

endif;
