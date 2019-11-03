<?php
/**
 * Rootstrap class.
 *
 * This class creats action hooks to be used when adding Customizer related modules.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2019, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap;

use Hybrid\Contracts\Bootable;

/**
 * Creates a new Rootstrap object.
 *
 * @since  1.0.0
 * @access public
 */
class Rootstrap implements Bootable {

    /**
     * Stores Vendor Path.
     *
     * @since 1.0.0
     * @var array
     */
    private $vendor_path;

    /**
     * Load resources.
     *
     * @since 1.0.0
     * @return object
     */
    public function boot() {

        // Set the default vendor path
        add_filter( 'rootstrap/vendor',   [$this, 'getVendorPath'] );

        // Load any classes and functions that will be needed in and out of the customizer.
        add_action( 'after_setup_theme',  [$this, 'setup'], PHP_INT_MAX );

        // Load any classes or functions needed only in the customize register hook
        add_action( 'customize_register', [$this, 'customize_register'] );

        // Modify registered components
        add_action( 'customize_register', [$this, 'after'], PHP_INT_MAX );
    }

    /**
     * Load any classes and functions that will be needed in and out of the customizer.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function setup() {
        do_action( 'rootstrap/setup' );
    }

    /**
     * Load any classes or functions needed only in the customize register hook.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function customize_register($manager) {

        // Customize register actions
        array_map(function($hook) use ($manager) {
            do_action( "rootstrap/{$hook}", $manager);
        }, [
            'customize-register',
            'customize-register/panels',
            'customize-register/sections',
            'customize-register/settings',
            'customize-register/controls',
            'customize-register/partials',
        ]);
    }

    /**
     * Modify registered components.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function after($manager) {
        do_action('rootstrap/customize-register/after', $manager);
    }

    /**
     * Set the path to the vendor directory.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function setVendorPath($path) {
        if ($path) {
            $this->vendor_path = $path;
        }
    }

    /**
     * Get the path to the vendor directory.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function getVendorPath($path) {
        return ($this->vendor_path) ? $this->vendor_path : $path;
    }
}
