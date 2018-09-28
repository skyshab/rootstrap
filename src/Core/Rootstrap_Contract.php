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

namespace Rootstrap\Core;


/**
 * Rootstrap interface.
 *
 * @since  1.0.0
 * @access public
 */
interface Rootstrap_Contract {
    

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
    public function get_config( $data = false );


    /**
     * Get Stored Class instance
     * 
     * @since 1.0.0
     * @return object
     */
    public function get_instance( $class );
  

} // end class 