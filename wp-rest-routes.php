<?php
/**
 * Plugin Name: WP REST ROUTES
 * Plugin URI: https://github.com/KevinDahlberg/wp-rest-routes-plugin
 * Description: Adds additional routes to the WP REST API
 * 
 * Version: 1.0
 * Author: Kevin Dahlberg
 * Author URI: https://github.com/KevinDahlberg
 * 
 * Text Domain: wp-rest-routes
 * 
 * @package WP_REST_ROUTES
 * 
 * License: MIT
 */

 if ( ! defined( 'ABSPATH' ) ) {
     exit; //Exits if accessed directly
 }

 include_once 'includes/menus.php';

 if ( ! function_exists ( 'wp_rest_routes_init' ) ) :
    /**
     * Init WP REST ROUTES
     * 
     * @since 1.0
     */
    function wp_rest_routes_init() {
        $menu_class = new Menu_Routes();
    
        add_filter( 'rest_api_init', array( $menu_class, 'register_routes' ) );
    }

    add_action( 'init', 'wp_rest_routes_init' );


endif;
