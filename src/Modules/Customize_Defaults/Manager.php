<?php
/**
 * Customize Defaults Manager.
 *
 * This class is used to boot the customizer default manager and handle its action and
 * filter hooks.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Customize_Defaults;


/**
 * Customize_Default manager class.
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
     * Add our actions 
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function boot() {

        // Create initial collection and add registration callback.
        add_action( 'init', [ $this, 'register' ], 110 );

        // Set defaults in customizer
        add_action( 'customize_register', [ $this, 'customize_register' ], 500 );   

        // apply customizer output filters for defaults on the front end
        add_action( 'wp_loaded', [ $this, 'customizer_default_filters' ] );          
    }


    /**
     * Create initial customize defaults that are defined in Rootstrap config. 
     * Execute the action hook for others to register their customize defaults.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function register() {

        // add defaults from Rootstrap
        foreach( get_defaults() as $id => $value ) {
            add_customize_default( $id, $value );
        }

        // action for theme or plugins to add or remove defaults
        do_action( 'rootstrap/customize_defaults/register', customize_defaults() );
    }


    /**
     * Register customizer defaults
     *
     * @param  object $wp_customize - the WordPress customizer object
     */
    public function customize_register( $wp_customize ) {

        foreach( get_customize_defaults() as $id => $value ) {

            $setting = $wp_customize->get_setting( $id );

            // if setting exists, set the control default
            if( $setting && isset( $value ) )
                $setting->default = $value->value();          
        }
    }  


    /**
     * Filter customizer defaults.
     * 
     * Adds a filter for every one of our registered defaults
     * in our custom get_theme_mod function. 
     * 
     * @since 1.0.0
     * @return void
     */
    public function customizer_default_filters() {

        foreach( get_customize_defaults() as $id => $default ) { 
            add_filter( "rootstrap/mods/{$id}/default", function( $fallback ) use ( $default ) { 
                return ( $default->value() && '' !== $default->value() ) ? $default->value() : $fallback;
            }); 
        }
    } 

}
