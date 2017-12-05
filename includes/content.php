<?php
/**
 * Content Routes
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
             * had to use the REST endpoints for this data.  It returns something that is more usable that the
             * built in get_posts and other functions from Wordpress.
             */

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

            /**
             * Sanitize All Posts
             * 
             * @since 1.0.4
             * @return Array of posts
             * 
             * This is needed because the REST Api doesn't give you all of the relevent post data, such as
             * the featured image.  It was either put this code here, or put it on the front end.  Also, it's
             * also nice to sanitize the data a bit, so that the object you get to play with on the fron end
             * doesn't have so much irrelevent crap on it.
             */

            public function sanitize_all_posts( $post_array ) {
                $new_post_array = array();

                foreach ( $post_array as $post ) {
                    $single_post = (array) $post;

                    $post_image = self::retrieve_featured_image( $single_post['featured_media'] );
                    
                    
                    $sanitized_post = array(
                        'id'                =>  $single_post['id'],
                        'date'              =>  $single_post['date'],
                        'slug'              =>  $single_post['slug'],
                        'title'             =>  $single_post['title']->rendered,
                        'content'           =>  $single_post['content']->rendered,
                        'excerpt'           =>  $single_post['excerpt']->rendered,
                        'featured_media'    =>  $post_image   
                    );

                    $single_post['featured_media'] =  $post_image;

                    $new_post_array[] = $sanitized_post;
                }

                return $new_post_array;
            }

            /**
             * retrieve featured image
             * 
             * @since 1.0.4
             * @return array with all of the information for the featured image.
             */

             public function retrieve_featured_image( $id ) {
                 $base_url = self::get_rest_url();
                 
                 $media_url = $base_url . '/media/' . $id;

                 $response =  wp_remote_get( $media_url );

                 $featured_media = json_decode( wp_remote_retrieve_body( $response ) );

                 $featured_image = (array) $featured_media;

                 $sanitized_featured_media = array(
                     'id'               =>  $featured_image['id'],
                     'date'             =>  $featured_image['date'],
                     'slug'             =>  $featured_image['slug'],
                     'title'            =>  $featured_image['title']->rendered,
                     'description'      =>  $featured_image['description']->rendered,
                     'file'             =>  $featured_image['media_details']->file,
                     'alt_text'         =>  $featured_image['alt_text'],
                     'post'             =>  $featured_image['post'],
                     'width'            =>  $featured_image['media_details']->width,
                     'height'           =>  $featured_image['media_details']->height,
                     'sizes'            =>  $featured_image['media_details']->sizes

                 );
                 
                return $sanitized_featured_media;
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
    