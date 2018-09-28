<?php
/**
 * Screen class.
 *
 * This class creates a screen object.
 *
 * @package    HybridCore
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2008 - 2017, Justin Tadlock
 * @link       https://themehybrid.com/hybrid-core
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Screens;

use Rootstrap\Modules\Screens\Screen_Contract as Contract;


/**
 * Creates a new object screen.
 *
 * @since  1.0.0
 * @access public
 */
class Device implements Contract {

	
	/**
	 * Screen name.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string
	 */
	protected $name = '';

	/**
	 * Min screen width.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string
	 */
	protected $min = false;

	/**
	 * Max screen width.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string
	 */
	protected $max = false;

	/**
	 * Device Icon
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string
	 */
	protected $icon = false;	


	/**
	 * Register a new screen object.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $name
	 * @param  array   $args
	 * @return void
	 */
	public function __construct( $name = false, array $args = [] ) {

		if( ! $name ) return false;

		$this->name = $name;
		$this->min = ( isset( $args['min'] ) && '' !== $args['min'] ) ? $args['min'] : false;
		$this->max = ( isset( $args['max'] ) && '' !== $args['max'] ) ? $args['max'] : false;
		$this->icon = ( isset( $args['icon'] ) && '' !== $args['icon'] ) ? $args['icon'] : false;
	}


	/**
	 * Returns the screen name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function name() {
		return $this->name;
	}


	/**
	 * Returns the screen min width.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function min() {
		return $this->min;
	}


	/**
	 * Returns the screen max width.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return bool
	 */
	public function max() {
		return $this->max;
	}


	/**
	 * Returns the device icon markup.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return bool
	 */
	public function icon() {
		return $this->icon;
	}	


	/**
	 * Magic method to use in case someone tries to output the object as a
	 * string. We'll just return the name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function __toString() {
		return $this->name();
	}

}
