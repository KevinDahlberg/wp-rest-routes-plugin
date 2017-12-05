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
 include_once 'includes/content.php';
 include_once 'includes/settings.php';

 if ( ! function_exists ( 'wp_rest_routes_init' ) ) :
    /**
     * Init WP REST ROUTES
     * 
     * @since 1.0
     */
    function wp_menu_rest_routes_init() {
        $menu_class = new Menu_Routes();
    
        add_filter( 'rest_api_init', array( $menu_class, 'register_routes' ) );
    }

    add_action( 'init', 'wp_menu_rest_routes_init' );

    function wp_content_rest_routes_init() {
        $content_class = new  Content_Routes();

        add_filter( 'rest_api_init', array( $content_class, 'register_routes' ) );
    }

    add_action( 'init', 'wp_content_rest_routes_init' );

    function wp_settings_rest_routes_init() {
        $settings_class = new Settings_Routes();

        add_filter( 'rest_api_init', array( $settings_class, 'register_routes' ) );
    }

    add_action( 'init', 'wp_settings_rest_routes_init' );


endif;
