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
 * @param string    $data
 * @return array
 */
// function get_config( $data = false ) {
//     return rootstrap()->get_config( $data );
// }


/**
 * Set the rootstrap config
 *
 * @since  1.0.0
 * @access public
 * @param  string   $config
 * @param  array    $data
 * @return void
 */
// function set_config( $config, $data = false ) {
//     rootstrap()->set_config( $config, $data );
// }


/**
 * Get object instance ? why tf
 *
 * @since  1.0.0
 * @access public
 * @param string    $class
 * @return object
 */
function get_instance( $class ) {
    return rootstrap()->get_instance( $class );
}