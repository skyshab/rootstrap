<?php
/**
 * Tabs manager.
 *
 * This class makes tabs functionality available in Customize Register 
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Tabs;


/**
 * Tabs manager class.
 *
 * @since  1.0.0
 * @access public
 */
class Manager {


    /**
     * Call this method to get singleton
     *
	 * @since  1.0.0
	 * @access public
     * @return Manager
     */
    public static function instance() {

        static $instance = null;

        if( is_null( $instance ) ) 
            $instance = new self;

        return $instance;
    }


    /**
     * Private constructor 
	 * 
	 * @since  1.0.0
	 * @access private
     * @return void
     */
    private function __construct(){}


	/**
	 * Sets up the tabs manager actions and filters.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {

		// Add registration callback for devices.
        add_action( 'customize_register', [ $this, 'load' ] );
	}


    /**
     * Load classes and functions in customizer
     *
     * @since 1.0.0
	 * @access public
     * @param object $wp_customize - the WordPress customizer object
     */
    public function load( $wp_customize ) {
       
        // The file that contains our customizer control. 
        require_once ROOTSTRAP_DIR . '/Modules/Tabs/class-tabs-control.php';

        // The file that contains helper function for creating tabs. 
        require_once ROOTSTRAP_DIR . '/Modules/Tabs/functions-tabs.php';
    }

}
