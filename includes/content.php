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

if ( ! class_exists( 'Content_Routes' ) ) :
    
        /**
         * Content_Routes class
         * 
         * @package WP_REST_ROUTES
         * @since 1.0.2
         */
        class Content_Routes {
    
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
    
            /**
             * site url to access rest api parts
             * 
             * @since 1.0.2
             * @return url for the website
             * 
             */
            public static function get_rest_url() {
                $url = get_site_url(null, '/wp-json/wp/v2');

                return $url;
            }
            
            /** register routes for WP API v2
             * 
             * @since 1.0.2
             * 
             */
            public function register_routes() {
    
                register_rest_route( self::get_plugin_namespace(), '/content/all', array(
                    array(
                        'methods' => 'GET',
                        'callback' => array( $this, 'get_site_content' )
                    )
                    ));
            }

            /**
             * Get Site Content
             * 
             * @since 1.0.2
             * @return array All Post Content
             * 
             * this is set up for a small number of posts, will need to change for blogs with a ton of posts and pages
             *
             */
            public function get_site_content() {
                $posts = self::all_posts();
                $pages = self::all_pages();

                $content = array(
                    'posts' => $posts,
                    'pages' => $pages
                );

                return $content;
            } 
            
            /**
             * Get Posts
             * 
             * @since 1.0.2
             * @return array All Posts
             * 
             */
            public function all_posts() {
                $url = self::get_rest_url();

                $post_url = $url . '/posts';

                $response =  wp_remote_get( $post_url );

                $posts = json_decode( wp_remote_retrieve_body( $response ) );
                
                $sanitized_posts = self::sanitize_all_posts( $posts );

                return $sanitized_posts;
            }

            public function sanitize_all_posts( $post_array ) {
                $new_post_array = array();

                foreach ( $post_array as $post ) {
                    $single_post = (array) $post;

                    $post_image = get_the_post_thumbnail( $single_post['id'] );

                    $post_image_info = (array) $post_image;

                    $single_post = array('post image' => $post_image_info);

                    $new_post_array[] = $post_image_info;
                }

                return $new_post_array;
            }
            
            /**
             * All Pages
             * 
             * @since 1.0.2
             * @return array All Pages
             * 
             */
            public function all_pages() {
                $url = self::get_rest_url();

                $page_url = $url . '/pages';

                $response = wp_remote_get( $page_url );

                $pages = json_decode( wp_remote_retrieve_body( $response ) );

                return $pages;
            }
    
        }
    
    endif;
    