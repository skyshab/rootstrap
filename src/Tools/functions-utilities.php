<?php
/**
 * Utility Functions.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap;


/**
 * Shortcut for getting post meta value.
 * Assumes current post ID.
 *
 * @since 1.0.0
 * @return string
 */
function get_post_meta_value( $id, $default = false ) {
	return ( get_post_meta( get_the_ID(), $id, true ) ) ?: $default;
}
