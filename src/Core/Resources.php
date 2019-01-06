<?php
/**
 * Rootstrap Resources class.
 *
 * This class handles loading the Rootstrap resources
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Core;


/**
 * Resources class.
 *
 * @since  1.0.0
 * @access public
 */
class Resources {


    /**
     * Stores resources uri.
     * 
     * @since 1.0.0
     * @var array
     */ 
    private $resources = false;
  

    /**
     * Stores preview data.
     * 
     * @since 1.0.0
     * @var array
     */ 
    private $js_data = array();     


    /**
     * Call this method to get singleton.
     *
     * @return Resources
     */
    public static function instance() {

        static $instance = null;

        if( is_null( $instance ) ) 
            $instance = new self;

        return $instance;
    }


    /**
     * Private contruct.
     *
     * @since  1.0.0
     * @access public
     * @param  array   $config
     * @return void
     */
    private function __construct(){}


    /**
     * Load resources.
     * 
     * @since 1.0.0
     * @return object
     */
    public function boot( $resources, $js_data ) {
        $this->resources = $resources;
        if( !$this->resources ) return false;
        $this->js_data = $js_data;
        $this->load();    
    }  


    /**
     * Load resources.
     * 
     * @since 1.0.0
     * @return object
     */
    public function load() {
        add_action( 'customize_controls_enqueue_scripts', [ $this, 'customize_resources' ], 10 );
        add_action( 'customize_preview_init', [ $this, 'customize_preview'  ], 10 );
    }     

    
    /**
     * Enqueue scripts and styles.
     *
     *  If filters are applied defining file locations, load scripts and styles. 
     * 
     * @since 1.0.0
     */
    public function customize_resources() {
        if ( !$this->resources ) return;        
        wp_enqueue_script( 'rootstrap-customize-controls', $this->resources . '/js/customize-controls.min.js', ['customize-controls', 'jquery'], "1.2", true );
        wp_localize_script( 'rootstrap-customize-controls', 'rootstrapData', $this->js_data );   
        wp_enqueue_style( 'rootstrap-customize-controls', $this->resources . '/css/customize-controls.min.css' );    
    }   
    

    /**
     * Enqueue customize preview scripts
     *
     * If filters are applied defining file locations, load scripts.
     * 
     * @since 1.0.0
     */
    public function customize_preview() {
        if ( !$this->resources ) return;        
        wp_enqueue_script( 'rootstrap-customize-preview', $this->resources . '/js/customize-preview.min.js', array(), filemtime( get_template_directory().'/style.css' ) );
    }

} 
