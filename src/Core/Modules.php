<?php
/**
 * Screens manager.
 *
 * This class is just a wrapper around the `Collection` class for adding 
 * a new screen. 
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Core;

use Rootstrap\Utilities\Collection;


/**
 * Module collection class.
 *
 * @since  1.0.0
 * @access public
 */
class Modules extends Collection {


    /**
     * Add a new screen.
     *
     * @since  1.0.0
     * @access public
     * @param  string  $name
     * @param  mixed   $value
     * @return void
     */
     public function add( $name, $components ) {
        parent::add( $name, new Module( $name, $components ) );
    }

    
    /**
     * Get the screen.
     *
     * @since  1.0.0
     * @access public
     * @param  string  $name
     * @return object
     */
    public function get( $name  ) {
        return parent::get( $name );
    }


    /**
     * Get all screens.
     *
     * @since  1.0.0
     * @access public
     * @return array
     */
    public function all() {
        return parent::all();
    }    

}
