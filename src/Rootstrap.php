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
        add_action( 'after_setup_theme',  [$this, 'setup'],                 PHP_INT_MAX );

        // Setup is complete. Configure any modules before implementation
        add_action( 'after_setup_theme',  [$this, 'config'],                PHP_INT_MAX );

        // Implement Rootstrap modules
        add_action( 'after_setup_theme',  [$this, 'loaded'],                PHP_INT_MAX );

        // Load any classes or functions needed only in the customize register hook
        add_action( 'customize_register', [$this, 'customize_register'],    10 );

        // Register custom controls, sections, panels
        add_action( 'customize_register', [$this, 'custom'],                20 );

        // Register Panels
        add_action( 'customize_register', [$this, 'panels'],                30 );

        // Register Sections
        add_action( 'customize_register', [$this, 'sections'],              40 );

        // Register Settings
        add_action( 'customize_register', [$this, 'settings'],              50 );

        // Register Controls
        add_action( 'customize_register', [$this, 'controls'],              60 );

        // Register Controls
        add_action( 'customize_register', [$this, 'partials'],              70 );

        // Modify registered components
        add_action( 'customize_register', [$this, 'after'],                 PHP_INT_MAX );
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
     * Configure any Rootstrap modules prior to implementation.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function config() {
        do_action( 'rootstrap/config' );
    }

    /**
     * Implement modules.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function loaded() {
        do_action( 'rootstrap/loaded' );
    }

    /**
     * Load any classes or functions needed only in the customize register hook.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function customize_register($manager) {
        do_action('rootstrap/customize-register', $manager);
    }

    /**
     * Register custom controls, sections, panels.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function custom($manager) {
        do_action('rootstrap/customize-register/custom', $manager);
    }

    /**
     * Register panels.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function panels($manager) {
        do_action('rootstrap/customize-register/panels', $manager);
    }

    /**
     * Register sections.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function sections($manager) {
        do_action('rootstrap/customize-register/sections', $manager);
    }

    /**
     * Register settings.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function settings($manager) {
        do_action('rootstrap/customize-register/settings', $manager);
    }

    /**
     * Register controls.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function controls($manager) {
        do_action('rootstrap/customize-register/controls', $manager);
    }

    /**
     * Register partials.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function partials($manager) {
        do_action('rootstrap/customize-register/partials', $manager);
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
        if($path) {
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
