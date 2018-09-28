<?php
/**
 * Post Customizer functions.
 *
 * Helper functions related to the Post Customizer.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Post_Customizer;

use function Rootstrap\rootstrap;


/**
 * Returns a Screens object.
 *
 * @since  1.0.0
 * @access public
 * @return Post_Customizer
 */
function post_customizer() {
	return rootstrap()->get_instance( 'Post_Customizer');
}


/**
 * Add a screen
 *
 * @since  1.0.0
 * @access public
 * @param  string            $post_type
 * @return void
 */
function add_post_type_support( $post_type ) {
	post_customizer()->add_post_type( $post_type );
}


/**
 * Get all Screens
 *
 * @since  1.0.0
 * @access public
 * @param  string            $post_type
 * @return void
 */
function remove_post_type_support( $post_type ) {
	post_customizer()->remove_post_type( $post_type );
}
