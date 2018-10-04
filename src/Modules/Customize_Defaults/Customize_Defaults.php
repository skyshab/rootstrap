<?php
/**
 * Customize_Defaults.
 *
 * This class is just a wrapper around the `Collection` class for adding a
 * default customizer value. 
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Customize_Defaults;

use Rootstrap\Modules\Customize_Defaults\Customize_Default;
use Rootstrap\Utilities\Collection;


/**
 * Customize_Default collection class.
 *
 * @since  1.0.0
 * @access public
 */
class Customize_Defaults extends Collection {


	/**
	 * Add a new customize_default.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $id
	 * @param  mixed   $value
	 * @return void
	 */
	 public function add( $id, $value ) {
		parent::add( $id, new Customize_Default( $id, $value ) );
	}


	/**
	 * Get the customize_default.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $id
	 * @return object
	 */
	public function get( $id  ) {
		return parent::get( $id );
	}

	
	/**
	 * Get all customize_defaults.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_all( ) {
		return parent::all();
	}	

}
