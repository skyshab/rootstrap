<?php
/**
 * Customize Default class.
 *
 * This class stores a default customizer value. 
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Customize_Defaults;

use Rootstrap\Modules\Customize_Defaults\Customize_Default_Contract as Contract;


/**
 * Creates a new customizer defaulr object.
 *
 * @since  1.0.0
 * @access public
 */
class Customize_Default implements Contract {


    /**
     * Customize control id. 
     *
     * @since  1.0.0
     * @access protected
     * @var    string
     */
    protected $id = '';

    /**
     * Customize control default value. 
     *
     * @since  1.0.0
     * @access protected
     * @var    array
     */
    protected $value = false;
    

    /**
     * Register a new customize control default.
     *
     * @since  1.0.0
     * @access public
     * @param  string  $id
     * @param  mixed   $value
     * @return void
     */
    public function __construct( $id = false, $value = false ) {
        if( ! $id ) return false;
        $this->id = $id;
        $this->value = $value;
    }


    /**
     * Returns the customize control id.
     *
     * @since  1.0.0
     * @access public
     * @return string
     */
    public function id() {
        return $this->id;
    }


    /**
     * Returns customize control default value.
     *
     * @since  1.0.0
     * @access public
     * @return string
     */
    public function value() {
        return $this->value;
    }


    /**
     * Magic method to use in case someone tries to output the object as
     * a string. Just return the default value.
     *
     * @since  1.0.0
     * @access public
     * @return string
     */
    public function __toString() {
        return $this->value();
    }

}
