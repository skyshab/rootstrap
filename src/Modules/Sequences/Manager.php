<?php
/**
 * Sequences manager.
 *
 * This class makes sequence functionality available in Customize Register 
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Sequences;


/**
 * Sequences manager class.
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
     * Sets up the sequence manager actions and filters.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function boot() {
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
       
        // The file that contains our custom control. 
        require_once ROOTSTRAP_DIR . '/Modules/Sequences/class-sequence-control.php';

        // The file that contains helper function for creating sequences. 
        require_once ROOTSTRAP_DIR . '/Modules/Sequences/functions-sequence.php';
    }

}
