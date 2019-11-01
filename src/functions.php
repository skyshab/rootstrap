<?php
/**
 * Rootstrap Functions.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2019, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap;

/**
 * Returns the path to the vendor directory.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function vendor_path() {
    return apply_filters('rootstrap/vendor', get_template_directory_uri() . '/vendor');
}
