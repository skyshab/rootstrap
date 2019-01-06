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

namespace Rootstrap\Modules\Devices;

use Rootstrap\Modules\Styles\Styles;
use function Rootstrap\rootstrap;
use function Rootstrap\add_js_data;


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

        // Add registration callback for devices.
        add_action( 'init', [ $this, 'register_devices' ], 95 );
                
        // Add registration callback for screens.
        add_action( 'init', [ $this, 'register_js_data' ], 100 );            

        // Set Customizer Devices
        add_filter( 'customize_previewable_devices', [ $this, 'customize_previewable_devices' ] );

        // Add Customizer Screen Styles
        add_action( 'customize_controls_print_styles', [ $this, 'customize_controls_print_styles' ] ); 

    }


    /**
     * Creates intial devices as defined in Rootstrap config
     * Executes the action hook for plugins or themes to register their devices.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function register_devices() {

        $devices = rootstrap()->get_config( 'devices' );

        if( count($devices) < 1  )
            $devices = get_device_defaults();

        // create our intial screens as defined in Rootstrap config
        foreach( $devices as $device => $args ) {
            $min = ( isset( $args['min'] ) ) ? $args['min'] : false;
            $max = ( isset( $args['max'] ) ) ? $args['max'] : false;
            $icon = ( isset( $args['icon'] ) ) ? $args['icon'] : false;
            $preview_width = ( isset( $args['preview_width'] ) ) ? $args['preview_width'] : false;
            $preview_height = ( isset( $args['preview_height'] ) ) ? $args['preview_height'] : false;

            add_device( $device, [ 
                'min' => $min, 
                'max'=> $max, 
                'icon' => $icon, 
                'preview_width' => $preview_width, 
                'preview_height' => $preview_height
            ]);
        }

        // action hook for plugins and child themes to add or remove devices
        do_action( 'rootstrap/devices/register', devices() );        
    }



    /**
     * Registers devices and screens in our customizer js
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function register_js_data() {        
        add_js_data( 'devices', get_devices_array() );
    }


    /**
     * Add custom devices to customizer.
     * These are output in the order they occur in the array,
     * and there is no width associated with the defaults here.
     * Unfortunately, this means this is an all or nothing thing.
     *
     * @since 1.0.0
     * @param array $devices - array of registered devices
     * @return array
     */
    public function customize_previewable_devices( $defaults ) {

        $devices = get_devices();

        // if no custom devices, use wp defaults
        if( !$devices ) return $defaults;

        $device_array = [];

        // generate a label for each device button
        foreach ($devices as $name => $device) {

            $device_array[$name]['label'] = sprintf( esc_html__('Enter %s preview mode'), $name );

            // if no max, assume this is 'desktop' or equivalent, set as default
            if( !$device->max() )
                $device_array[$name]['default'] = true;
        }

        // return our custom device array
        return $device_array;
    }


    /**
     * Add custom screen size styles to customizer head
     * 
     * @since 1.0.0
     * @return string
     */
    public function customize_controls_print_styles() {

        $styles = new Styles();
        $styles->add_screen( 'mobile-devices-only', ['max' => '1024px'] );

        foreach ( get_devices() as $name => $device ) {

            // add icon to preview button
            $styles->add([
                'selector' => sprintf( 'button.preview-%s:before', $name ),
                'styles' => [
                    'content' => $device->icon() 
                ]
            ]);

            // add icon to section title
            $styles->add([
                'selector' => sprintf( '.control-section-rootstrap-device--%s .customize-section-title h3:after', $name ),
                'styles' => [
                    'content' => $device->icon() 
                ]
            ]); 

            // set customize preview screen max width
            $styles->add([
                'selector' => sprintf( '.preview-%s #customize-preview', $name ),
                'styles' => [
                    'width' => $device->preview_width() . '!important',
                    'height' => $device->preview_height() . '!important',                    
                ],
            ]);

        } // end foreach

        $styles->add([
            'screen' =>'mobile-devices-only',
            'selector' => '#customize-controls .wp-full-overlay-footer .devices',
            'styles' => [
                'display' => 'block'
            ]
        ]);

        $styles->add([
            'selector' => '.wp-full-overlay-footer .devices button:before',
            'styles' => [
                'padding' => '4px 6px'
            ]
        ]);

        // print styles
        echo $styles->get_styleblock( 'customize-controls' );

    }
    
}
