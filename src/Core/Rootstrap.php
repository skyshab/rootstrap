<?php
/**
 * Rootstrap class.
 *
 * This class handles the Rootstrap config data and sets up
 * the individual modules that make up Rootstrap.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Core;

use Rootstrap\Contracts\Rootstrap as Contract;
use Rootstrap\Core\Resources;


/**
 * Creates a new Rootstrap object.
 *
 * @since  1.0.0
 * @access public
 */
class Rootstrap implements Contract {


    /**
     * Stores configuration data
     * 
     * @since 1.0.0
     * @var array
     */ 
    private $config;

    /**
     * Stores resources uri
     * 
     * @since 1.0.0
     * @var array
     */ 
    private $resources = false;

    /**
     * Stores Modules object
     * 
     * @since 1.0.0
     * @var array
     */ 
    private $modules; 

    /**
     * Stores module objects
     * 
     * @since 1.0.0
     * @var array
     */ 
    private $instances = array();     

    /**
     * Stores preview data
     * 
     * @since 1.0.0
     * @var array
     */ 
    private $js_data = array();     


    /**
     * Call this method to get singleton
     *
     * @return Rootstrap
     */
    public static function instance() {

        static $instance = null;

        if( is_null( $instance ) ) 
            $instance = new self;

        return $instance;
    }


    /**
     * Register a new Rootstrap object.
     *
     * @since  1.0.0
     * @access public
     * @param  array   $config
     * @return void
     */
    public function __construct() {
        $this->register_modules();
        $this->register_instances();
        $this->register_includes();
        $this->register_boots();
        $this->boot();
    }


    /**
     * Instantiate and store Modules objects
     * 
     * @since 1.0.0
     * @return void
     */
    private function register_modules() {

        // Create and store the Screens object 
        $this->modules = new Modules();

        // grab our modules config
        $config = include( ROOTSTRAP_DIR . '/Modules/rootstrap-modules.php' );

        // create modules
        foreach ( $config as $module => $components ) {
            $this->modules->add( $module, $components );
        }
    }


    /**
     * Instantiate and store module Class instances 
     * 
     * @since 1.0.0
     * @return void
     */
    private function register_instances() {

        $modules = $this->modules->all();

        foreach ( $modules as $module ) {

            if( !$module->instances() ) continue;

            $namespace = $module->namespace();

            foreach ( $module->instances() as $instance ) {
                $Class = $namespace . "\\" . $instance;
                $this->instances[ $instance ] = new $Class;         
            }
        }     
    }


    /**
     * Instantiate and store module Class instances 
     * 
     * @since 1.0.0
     * @return void
     */
    private function register_includes() {

        $modules = $this->modules->all();

        foreach ( $modules as $module ) {

            if( !$module->includes() ) continue;

            foreach ( $module->includes() as $include ) {
                $file = sprintf( '%s/Modules/%s/%s.php', ROOTSTRAP_DIR, $module, $include );
                require_once( $file );      
            }
        }     
    }


    /**
     * Boot any classes needed by our modules
     * 
     * @since 1.0.0
     * @return void
     */
    private function register_boots() {

        $modules = $this->modules->all();

        foreach ( $modules as $module ) {

            $namespace = $module->namespace();

            foreach ( $module->boot() as $class ) {
                $boot = $namespace . "\\" . $class;
                ( $boot::instance() )->boot();                 
            }
        }       
    }


    /** 
     * Add our actions
     * 
     * @since 1.0.0
     * @return void
     */
    private function boot() {
        add_action('init', [$this, 'register_resources' ], 100 );
    }


    /*
     * Initiate the class that loads our resources
     * 
     * @since 1.0.0
     * @return void
     */
    public function register_resources() {
        if( !$this->get_resources() ) return false;
        $resources = Resources::instance();
        $resources->boot( $this->get_resources(), $this->get_js_data() );
    }


    /**
     * Initialize the config. Can be passed in as a single 
     * array, or just for an individual module's data.
     * 
     * @since 1.0.0
     * @param mixed     $config
     * @param array     $data
     * @return void
     */
    public function set_config( $config, $data = false  ) {
        if( is_array( $config ) && !$data )
            $this->config = $config;
        elseif( is_array($data) )
            $this->config[$config] = $data;
    }

    
    /**
     * Get the config settings. If a specific module is not defined,
     * return entire config. Allow values to be filtered. 
     * 
     * @since 1.0.0
     * @return array
     */
    public function get_config( $data = false ) {
        $filtered = apply_filters('rootstrap/config', $this->config );
        if( $data )
            $config = ( isset( $filtered[$data] ) ) ? $filtered[$data] : [];
        else
            $config = $filtered;
        return $config;
    }


    /**
     * Set resources URI.
     * Used to load module scripts and styles.
     * 
     * @since 1.0.0
     * @return array
     */
    public function set_resources( $uri ) {
        $this->resources = $uri;
    }

    
    /**
     * Get resources URI.
     * Used to load module scripts and styles.
     * 
     * @since 1.0.0
     * @return array
     */
    public function get_resources() {
        return $this->resources;
    }    


    /**
     * Get Stored Class instance
     * 
     * @since 1.0.0
     * @return object
     */
    public function get_instance( $class ) {
        return $this->instances[$class];
    } 


    /**
     * Get Preview Data
     * 
     * @since 1.0.0
     * @return object
     */
    public function get_js_data() {
        return $this->js_data;
    } 


    /**
     * Set Preview Data
     * 
     * @since 1.0.0
     * @return void
     */
    public function add_js_data( $key = false, $data ) {
        if( $key ) $this->js_data[$key] = $data;        
    }    

} 
