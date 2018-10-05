<?php
/**
 * Style class.
 *
 * This class creates a screen object.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Styles;

use Rootstrap\Abstracts\Style_Interface;


/**
 * Creates a new object screen.
 *
 * @since  1.0.0
 * @access public
 */
class Style implements Style_Interface {


    /**
     * Screen for these styles.
     *
     * @since  1.0.0
     * @access protected
     * @var    string
     */
    protected $screen;

    /**
     * Selector.
     *
     * @since  1.0.0
     * @access protected
     * @var    string
     */
    protected $selector;

    /**
     * Styles.
     *
     * @since  1.0.0
     * @access protected
     * @var    array
     */
    protected $styles;

    /**
     * Callback for styleblock.
     *
     * @since  1.0.0
     * @access protected
     * @var    bool 
     */
    protected $callback;


    /**
     * Register a new style object.
     *
     * @since  1.0.0
     * @access public
     * @param  array   $args
     * @return void
     */
    public function __construct( $args = [] ) {

        $this->selector = ( isset( $args['selector'] ) ) ? $args['selector'] : false;
        $this->styles = ( isset( $args['styles'] ) ) ? $args['styles'] : false;
        $this->screen = ( isset( $args['screen'] ) ) ? $args['screen'] : 'default';
        $this->callback = ( isset( $args['callback'] ) && '' !==  $args['callback'] ) ? $args['callback'] : true;

        if( !$this->selector || !$this->styles ) return false;
    }


    /**
     * Returns the screen name.
     *
     * @since  1.0.0
     * @access public
     * @return string
     */
    public function screen() {

        return $this->screen;
    }

    
    /**
     * Assemble styles and return string
     *
     * @since 1.0.0   
     * @return string
     */
    public function get() {

        $styles = '';

        if( !$this->callback ) return $styles;

        foreach ( $this->styles as $property => $value ) {

            $property = ( isset( $property ) && '' !==  $property ) ? $property : false;
            $value = ( isset( $value ) && '' !==  $value ) ? $value : false;

            if( !$property || !$value ) continue;

            $styles  .= sprintf( '%s: %s;', $property, $value);
        }

        return sprintf( '%s{%s}', $this->selector, $styles );
    }


    /**
     * Magic method to use in case someone tries to output the object as a
     * string. We'll just return the styles.
     *
     * @since  1.0.0
     * @access public
     * @return string
     */
    public function __toString() {
        return $this->get();
    }    

}
