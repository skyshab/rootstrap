<?php
/**
 * Tabs class.
 *
 * This class creates a tabs object.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Tabs;

use Tabs_Control;
use function Rootstrap\section_hider;


/**
 * Creates a new tabs object.
 *
 * @since  1.0.0
 * @access public
 */
class Tabs {


    /**
     * Tabs title.
     *
     * @since  1.0.0
     * @access protected
     * @var    string
     */
    protected $title;

    /**
     * Panel.
     *
     * @since  1.0.0
     * @access protected
     * @var    string
     */
    protected $panel;

    /**
     * Priority.
     *
     * @since  1.0.0
     * @access protected
     * @var    int
     */
    protected $priority;

    /**
     * Tabs array.
     *
     * @since  1.0.0
     * @access protected
     * @var    array 
     */
    protected $tabs;

    /**
     * Stores the wp_customize object.
     *
     * @since  1.0.0
     * @access protected
     * @var    array 
     */
    protected $customize;    


    /**
     * Register a new tabs object.
     *
     * @since  1.0.0
     * @access public
     * @param  object   $wp_customize
     * @param  array    $args
     * @return void
     */
    public function __construct( $wp_customize, $args = [] ) {

        // store the customizer object
        $this->customize = $wp_customize;

        // set the object properties
        foreach( $args as $property => $value ) {
            if( property_exists( $this, $property ) ) {
                $this->$property = $value;
            }
        }

        // if no title was set, try to use the default title
        if( !$this->title ) $this->title = $this->default_title();
        
        // add control for hiding tab sections
        section_hider( $this->customize,  $this->panel );
        
        // build the tabs
        $this->tab_loop();
    }


    /**
     * Loop through tabs
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    private function tab_loop() {

        if( !$this->tabs ) return;

        foreach( $this->tabs as $id => $args ) {
            
            // get the section
            $section = $this->customize->get_section( $id );

            if( !$section ) continue;

            // set the title
            $section->title = $this->title;
    
            // if not the default tab section, move to priority where sections aren't visible
            if( $id !== $this->default_tab() ) $section->priority = 1000;

            // create setting and control
            $this->control( $id );
        }
    }


    /**
     * Add tab control
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    private function control( $id ) {

        $setting = sprintf( '%s-tabs', $id );

        // Setting: create tabs control
        $this->customize->add_setting( $setting, [
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ]);

        // Control: create tabs control
        $this->customize->add_control( 
            new Tabs_Control( $this->customize, $setting, [
                'section' => $id,
                'tabs' => $this->tabs,
                'default' => $this->default_tab(),
                'priority' => -10,
            ]
        ));
    }


    /**
     * Get default tab
     *
     * @since  1.0.0
     * @access public
     * @return string
     */
    private function default_tab() {
        return key( $this->tabs );   
        // once we can support 7.3.0, use this
        // return array_key_first( $this->tabs );    
    }
    

    /**
     * Get default tab title
     *
     * @since  1.0.0
     * @access public
     * @return string
     */
    private function default_title() {
        $default_section = $this->customize->get_section( $this->default_tab() );
        return ( $default_section->title ) ? $default_section->title : false;
    }    

}
