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

use Rootstrap\Core\Rootstrap_Contract as Contract;


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

            $namespace = $module->namespace();

            foreach ( $module->instances() as $instance ) {
                
                $Class = $namespace . "\\" . $instance;
        
                $this->instances[ $instance ] = new $Class;         
            }
        }     
    }


    /**
     * Boot any classes needed by our modules
     * 
     * @since 1.0.0
     * @return void
     */
    private function boot() {

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
     * Initialize the config.
     * Allow config to be filtered.
     * 
     * @since 1.0.0
     * @return array
     */
    public function set_config( array $config ) {
        $this->config = apply_filters( 'rootstrap/config', $config );
    }

    
    /**
     * Get the config settings
     * 
     * @since 1.0.0
     * @return array
     */
    public function get_config( $data = false ) {

        if( $data ) {
            if( !isset( $this->config[$data] ) ) return [];
            return $this->config[$data];
        }

        return $this->config;
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

} 
