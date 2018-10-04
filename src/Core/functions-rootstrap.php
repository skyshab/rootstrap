<?php
/**
 * Functions for accessing the Rootstrap object and config data.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap;

use Rootstrap\Core\Rootstrap;


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
 * Get complete rootstrap config
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function get_config( $data = false ) {
	return rootstrap()->get_config( $data );
}


/**
 * Set the rootstrap config
 *
 * @since  1.0.0
 * @access public
 * @param  string            $config
 * @return void
 */
function set_config( $config ) {
	rootstrap()->set_config( $config );
}


/**
 * Get object instance 
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
function get_instance( $class ) {
	return rootstrap()->get_instance( $class );
}

/**
 * Set the resources URI.
 * Used to load scripts and styles.
 *
 * @since  1.0.0
 * @access public
 * @param  string            $uri
 * @return void
 */
function set_resources_uri( $uri ) {
	rootstrap()->set_resources( $uri );
}


/**
 * Get the resources URI.
 * Used to load scripts and styles.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function get_resources_uri() {
	return rootstrap()->get_resources();
}


/**
 * Get the JS data.
 * Used to make data available in js
 * when performing actions in the customizer.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function get_js_data() {
	return rootstrap()->get_js_data();
}


/**
 * Set the JS data.
 * Used by modules to add js data.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function add_js_data( $key, $data ) {
	rootstrap()->add_js_data( $key, $data );
}
