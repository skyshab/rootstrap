<?php
/**
 * Rootstrap Functions.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap;


/**
 * Returns a Roostrap object.
 *
 * @since  1.0.0
 * @access public
 * @return Rootstrap
 */
function rootstrap() {
    return Rootstrap::instance();
}


/**
 * Get object instance
 *
 * @since  1.0.0
 * @access public
 * @param string    $class
 * @return object
 */
function get_instance( $class ) {
    return rootstrap()->get_instance( $class );
}


/**
 * Replacement for the "get_theme_mod" function. 
 * Adds separate filters for value, default, and whether to render.  
 *
 * @since   1.0.0
 * @param   string $id - the theme mod id
 * @param   mixed  $fallback - the fallback value to use
 * @param   bool   $render - should we render the value when it matches the default
 * @return  string - outputs the value for the mod
 */
function get_theme_mod( $id, $fallback = false, $render = false ) {

    // here's a chance to force the output, no matter what else is going on
    $mod_override = apply_filters( "rootstrap/mods/{$id}/value", false, $id );

    // if an override was set, return the value
    if( $mod_override ) 
        return $mod_override;

    // If a single argument is passed in, and it's a boolean,
    // treat the value as the render conditional.
    if( is_bool( $fallback ) && !$render ) {
        $render = $fallback;
    }

    // allow a default value to be set
    $default = apply_filters( "rootstrap/mods/{$id}/default", $fallback, $id );

    // allow the render conditional to be overridden
    $render = apply_filters( "rootstrap/mods/{$id}/default/render", $render, $id );

    // get the stored theme mods
    $mods = get_theme_mods();

    // if there's a value set, check if it's the default and whether we should return it.
    if ( isset( $mods[$id] ) && $mods[$id] ) {

        // if the value and default match 
        // and we're not supposed to render, bail
        if( !$render && $default === $mods[$id] )
            return false;

        // otherwise, return the value
        return $mods[$id];
    }
    // no value is set, so see if there's a default to return.
    elseif( $render && $default ) {
        return $default;
    }
    // If a fallback was passed in, output that. 
    elseif( $fallback && is_string( $fallback ) ) {
        return $fallback;
    }

    // we're in a universe where logic doesn't apply.
    return false;
}


/**
 * Register theme stylesheet 
 * 
 * Registers stylesheet and adds mechanism for storing styles
 * rendered from theme mods for caching   
 *
 * @since   1.0.0
 * @param   string  $handle - the stylesheet handle
 * @param   string  $src - location of the stylesheet
 * @param   array   $deps - does this depend on other styles?
 * @param   string  $ver - stylesheet version
 * @return  void
 */
function rootstrap_register_styles( $handle, $src = '', $deps = [], $ver = false  ) {

    // enqueue the stylesheet
    wp_enqueue_style( $handle, $src, $deps, $ver );

    // When customize preview
    if ( is_customize_preview() ) {

        // Filter to pass in style object 
        $styles = apply_filters( 'rootstrap/styles/public', null );

        // if a style object passed in, get preview styles
        $output = ( $styles ) ? $styles->get_customize_preview() : null;

        add_action( 'wp_head', function() use( $output ) {
            echo $output;
        }); 
    } 
    else {        
        
        // Get the theme_mod from the database
        $output = get_theme_mod( 'rootstrap-theme-mods', false );

        // If styles not cached yet, save them
        if ( !$output ) {

            // Filter to pass in style object 
            $styles = apply_filters( 'rootstrap/styles/public', null );

            // if a style object passed in, get public styles
            $output = ( $styles ) ? $styles->get_styles() : null; 

            // Store cached styles in theme mod
            set_theme_mod( 'rootstrap-theme-mods',  $output );
        }

        // Add the mods
        wp_add_inline_style( $handle, $output );           
    }


        // // Add the mods
        // wp_add_inline_style( $handle, $output );        
    
}




/**
 * Is stylesheet cached?  
 * 
 * Checks if the front end styles are cached. 
 * Used to determine whether to load resources.  
 *
 * @since   1.0.0
 * @return  bool
 */
function is_cached() {
    return( get_theme_mod( 'rootstrap-theme-mods', false ) ) ? true : false;
}
