<?php
/**
 * Rootstrap interface.
 *
 * Defines the interface that the Rootstrap class must use.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Abstracts;


/**
 * Rootstrap interface.
 *
 * @since  1.0.0
 * @access public
 */
interface Rootstrap_Interface {
    

    /**
     * Initialize the config
     * 
     * @since 1.0.0
     * @return array
     */
    public function set_config( array $config );


    /**
     * Get the config settings
     * 
     * @since 1.0.0
     * @return array
     */
    public function get_config( $data );


    /**
     * Get Stored Class instance
     * 
     * @since 1.0.0
     * @return object
     */
    public function get_instance( $class );
  

    /**
     * Set resources URI.
     * Used to load module scripts and styles.
     * 
     * @since 1.0.0
     * @return array
     */
    public function set_resources( $uri );


    /**
     * Get resources URI.
     * Used to load module scripts and styles.
     * 
     * @since 1.0.0
     * @return array
     */
    public function get_resources();


    /*
     * Initiate the class that loads our resources
     * 
     * @since 1.0.0
     * @return void
     */
    public function register_resources();


    /**
     * Get Preview Data
     * 
     * @since 1.0.0
     * @return object
     */
    public function get_js_data();


    /**
     * Set Preview Data
     * 
     * @since 1.0.0
     * @return void
     */
    public function add_js_data( $key, $data );

} 
