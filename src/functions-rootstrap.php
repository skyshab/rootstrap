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
}
