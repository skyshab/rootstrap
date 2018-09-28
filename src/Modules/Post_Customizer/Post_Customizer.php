<?php
/**
 * Post Customizer.
 *
 * This class is used to handle overiding customizer styles 
 * when the current post has post meta settings that correspond
 * to customizer settings.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Post_Customizer;

use function Rootstrap\get_post_meta_value;


/**
 * Post Customizer class.
 *
 * @since  1.0.0
 * @access public
 */
class Post_Customizer {


    /**
     * Stores post_types
     * 
     * @since 1.0.0
     * @var array
     */ 
    public $post_types = array('post');


    /**
     * Call this method to get singleton
     *
     * @return Post_Customizer
     */
    public static function instance() {

        static $instance = null;

        if( is_null( $instance ) ) 
            $instance = new self;

        return $instance;
    }


    /**
     * Public constructor 
	 * 
	 * @since  1.0.0
	 * @access public
     */
    public function __construct(){}


	/**
	 * Sets up the post customizer manager actions and filters.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {
        add_action( 'wp', [ $this, 'customizer_filters' ], 500 );   		
    }
    

	/**
	 * Add a supported post type.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function add_post_type($post_type) {
        $this->post_types[] = $post_type; 		
    }    
    

	/**
	 * Remove post type from supported types.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function remove_post_type($post_type) {
        unset( $this->post_types[$post_type] ); 		
    }    
    

	/**
	 * Get array of supported post types.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_post_types() {
        return $this->post_types; 		
    }  
    

    /**
	 * Is a supported post type.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return bool
	 */
	public function is_supported_post_type( $post_type ) {
        return ( in_array( $post_type, $this->post_types ) ) ? true : false;		
    }  


    /**
     * Filters for customizer output.
     * 
     * Override customizer output if post has meta with same id.
     *
     * @since 0.8.2
     * @return void
     */
    public function customizer_filters() {

        $supported_post_type = $this->is_supported_post_type( get_post_type() );
        $post_meta = get_post_meta( get_the_ID() );

        if( !is_singular() || !$supported_post_type || !$post_meta ) return;

        foreach( $post_meta as $id => $value ) {

            add_filter( "theme_mod_{$id}", function( $value ) use ( $id ) { 

                if( get_post_meta_value( $id ) && 
                    '' !==  get_post_meta_value( $id ) && 
                    'default' !==  get_post_meta_value( $id ) 
                ) {
                    $value = get_post_meta_value( $id );
                }   

                return $value; 
            });

        } // end foreach
    }
	
}
