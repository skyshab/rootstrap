<?php
/**
 * Devices Collection
 *
 * This class is a wrapper around the `Collection` class for adding 
 * a new device. 
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Screens;

use Rootstrap\Utilities\Collection;
use Rootstrap\Modules\Screens\Device;


/**
 * Device collection class.
 *
 * @since  1.0.0
 * @access public
 */
class Devices extends Collection {

	/**
	 * Add a new device.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $name
	 * @param  mixed   $args
	 * @return void
	 */
	 public function add( $name, $args ) {
		parent::add( $name, new Device( $name, $args ) );
	}

	
	/**
	 * Get the device.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $name
	 * @return object
	 */
	public function get( $name  ) {
		return parent::get( $name );
	}


	/**
	 * Get all devices.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function all( ) {
		return parent::all();
	}	

}
