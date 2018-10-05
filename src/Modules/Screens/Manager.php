<?php
/**
 * Screens manager.
 *
 * This class is used to boot the screen manager and handle its action and
 * filter hooks.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Screens;

use function Rootstrap\rootstrap;
use function Rootstrap\add_js_data;
use function Rootstrap\Modules\Devices\get_devices;

/**
 * Screen manager class.
 *
 * @since  1.0.0
 * @access public
 */
class Manager {


    /**
     * Call this method to get singleton
     *
     * @return Manager
     */
    public static function instance() {

        static $instance = null;

        if( is_null( $instance ) ) 
            $instance = new self;

        return $instance;
    }


    /**
     * Private constructor 
     * 
     * @since  1.0.0
     * @access private
     */
    private function __construct(){}


    /**
     * Sets up the screens manager actions and filters.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function boot() {
        
        // Add registration callback for screens.
        add_action( 'init', [ $this, 'register_screens' ], 100 );    
        
        // Add registration callback for screens.
        add_action( 'init', [ $this, 'register_js_data' ], 100 );            
    }


    /**
     * Creates intial screens from registered devices.
     * Executes the action hook for plugins or themes to register their screens.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function register_screens() {

        $screens = $this->screens();

        // create our intial screens as defined in Rootstrap config
        foreach( $screens as $screen => $args ) {
            add_screen( $screen, [ 'min' => $args['min'], 'max'=> $args['max'] ] );
        }

        // action hook for plugins and child themes to add or remove screens
        do_action( 'rootstrap/screens/register', screens() );
    }


    /**
     * Registers devices and screens in our customizer js
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function register_js_data() {        
        add_js_data( 'screens', get_screens_array() );
    }


    /**
     * Expand devices into all possible screen combinations.
     * 
     * @since 1.0.0   
     * @access private
     * @return array
     */
    private function screens() {

        $devices = get_devices();
        $screens = [ 'default' => [] ];


        // 'and up' screens loop
        foreach ( $devices as $name => $device ) {

            $min = $device->min();
            $max = $device->max();

            if( $min && $max ) $id  = sprintf( '%s-and-up', $name );
            elseif( $min ) $id  = $name;
            else continue;

            $screens[$id]['min'] = $min;
        }


        // 'and under' screens loop
        foreach ( $devices as $name => $device ) {

            $min = $device->min();
            $max = $device->max();

            if( $min && $max ) $id  = sprintf( '%s-and-under', $name );
            elseif( $max ) $id  = $name;
            else continue;

            $screens[$id]['max'] = $max;
        }


        // generate all possible screen combinations that have both a min and max
        foreach ( $devices as $outer_name => $outer_device ) {

            $outer_min = ( $outer_device->min() && '' !== $outer_device->min() ) ? $outer_device->min() : false;

            if( $outer_min ) {

                foreach ( $devices as $inner_name => $inner_device ) {

                    $inner_min = $inner_device->min();
                    $inner_max = $inner_device->max();

                    if( !$inner_max ) continue;

                    $outer_min_value = filter_var( $outer_min, FILTER_SANITIZE_NUMBER_INT );
                    $inner_min_value = filter_var( $inner_min, FILTER_SANITIZE_NUMBER_INT );
                    $inner_max_value = filter_var( $inner_max, FILTER_SANITIZE_NUMBER_INT );

                    if( $outer_min_value <= $inner_min_value && $outer_min_value < $inner_max_value ) {

                        $id = ( $outer_name === $inner_name ) ? $outer_name : sprintf( '%s-%s', $outer_name, $inner_name );
                        $screens[$id]['min'] = $outer_min;
                        $screens[$id]['max'] = $inner_max;

                    } // end if max

                } // end inner loop

            } // end if min

        } // end outer loop


        // return expanded screen object
        return $screens;

    } // end expand_screens

    
}
