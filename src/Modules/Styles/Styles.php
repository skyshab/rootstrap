<?php
/**
 * Rootstrap style class.
 *
 * Utility for generating styleblocks using screens defined by our application
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Styles;

use Rootstrap\Modules\Styles\Style;
use Rootstrap\Modules\Screens\Screens;


class Styles {
    
    
    /**
     * Stores style objects.
     *
     * @since  1.0.0
     * @access protected
     * @var    array
     */
    protected $styles;

    /**
     * Stores Screens object
     *
     * @since  1.0.0
     * @access protected
     * @var    array
     */
    protected $screens;


    /**
     * Setup our Styles object
     *
     * @since 1.0.0   
     * @param object $screens - a Screens object
     */
    public function __construct( $screens = null ) {
        if( $screens === null ) {
            $screens = new Screens();
            $screens->add( 'default', [] );
        }
        $this->screens = $screens;
    }


    /**
     * Add a new style.
     *
     * @since  1.0.0
     * @access public
     * @param  array   $args
     * @return void
     */
    public function add( $args ) {
        $style = new Style( $args );
        $this->styles[$style->screen()][] = $style;
    }


    /**
     * Add a new screen.
     *
     * @since  1.0.0
     * @access public
     * @param  string    $name
     * @param  array    $args
     * @return void
     */
    public function add_screen( $name = false, $args = []) {
        if( !$name ) return;
        $this->screens->add( $name, $args );
    }


    /**
     * Build opening of media query block, when applicable
     *
     * @since 1.0.0   
     * @param string $min - the min width of our query
     * @param string $max - the max width of our query
     */
    private function open( $min = false, $max = false ) {

        $open = '';

        if( $min || $max ) {

            $open .= '@media ';

            if( $min ) {

                $open .= sprintf( '(min-width: %s)', esc_attr( $min ) );
                
                if( $max ) $open .= ' and ';
            }

            if( $max ) $open .= sprintf( '(max-width: %s)', esc_attr( $max ) );

            $open .= '{';
        }
        
        return $open;
    }


    /**
     * Print closing tag of media query block, when applicable
     *
     * @since 1.0.0   
     * @param string $min - the min width of our query
     * @param string $max - the max width of our query
     */
    private function close( $min = false, $max = false ) {
        return ( $min || $max ) ? '}' : '';
    }


    /**
     * Print the styles from all screens
     *
     * @since 1.0.0   
     * @param string $id - the id to add to the styleblock
     */
    public function get( $id = false ) {

        $block = '';

        // open styleblock
        if( $id ) $block .= sprintf( '<style id="rootstrap-%s">', esc_attr( $id ) );

        // print styles for each screen
        foreach ( $this->styles as $name => $styles ) {

            $screen = ($this->screens)->get($name);

            if( $screen && 'default' !== $screen ) {

                // set our min and max widths
                $min = $screen->min();
                $max = $screen->max();
            }
            else $min = $max = false;

            // open screen query
            $block .= $this->open( $min, $max );

            // add styles
            foreach ($styles as $style) {
                $block .= $style->get();
            }

            // close screen query
            $block .= $this->close( $min, $max );

        } // end foreach

        // close styleblock
        if( $id ) $block .= '</style>';

        // return styleblock
        return $block;
    }


    /**
     * Print the styles from all screens
     *
     * @since 1.0.0   
     * @param string $id - the id to add to the styleblock
     */
    public function print( $id = false ) {    
        echo $this->get( $id );
    }

} 
