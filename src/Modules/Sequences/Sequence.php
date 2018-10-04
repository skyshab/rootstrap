<?php
/**
 * Sequence class.
 *
 * This class creates a sequence object.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Sequences;

use Sequence_Control;

use function Rootstrap\section_hider;


/**
 * Creates a new sequence object.
 *
 * @since  1.0.0
 * @access public
 */
class Sequence {


	/**
	 * Stores the wp_customize object.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    array 
	 */
	protected $customize;   

	/**
	 * Sections array.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    array 
	 */
	protected $sections;
	
	/**
	 * Sections array.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    bool 
	 */
	protected $reverse;
	
	/**
	 * Sections array.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string 
	 */
	protected $previous;
	
	/**
	 * Sections array.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    string 
	 */
    protected $next;
   

	/**
	 * Register a new sequence object.
	 *
	 * @since  1.0.0
	 * @access public
     * @param  object   $wp_customize
	 * @param  array    $sections
	 * @return void
	 */
	public function __construct( $wp_customize, $args = [] ) {

		// store the customizer object
		$this->customize = $wp_customize;

		// store the reverse order flag
		$this->reverse = ( isset( $args['reverse'] ) ) ? $args['reverse'] : false;

		// store the previous label
		$this->previous = ( isset( $args['previous'] ) ) ? $args['previous'] : false;

		// store the next label
		$this->next = ( isset( $args['next'] ) ) ? $args['next'] : false;

		// store the sections
		$this->sections = ( isset( $args['sections'] ) ) ? $args['sections'] : [];

		// if reverse order is specified, flip the sections
		if( $this->reverse ) $this->sections = array_reverse( $this->sections );
		
		// add control for hiding sequence sections
		section_hider( $this->customize,  $this->get_panel() );
		
		// build the sequence
        $this->sequence_loop();
	}


	/**
	 * Loop through sequence
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	private function sequence_loop() {

		// if there's no sections, take off eh.
		if( !$this->sections ) return;

        foreach( $this->sections as $id => $args ) {
			
			// if hide flag enabled, set priority 
			if( isset( $args['hide'] ) && $args['hide'] ) {
				$section = $this->customize->get_section( $id );
				$section->priority = 1000;
			}

			// if device is set, add custom section type
			$device = ( isset( $args['device'] ) ) ? $args['device'] : false;

			if( $device ) {
				$section = $this->customize->get_section( $id );
				$section->type = sprintf( 'rootstrap-device--%s', $device );
			}
    
            // create setting and control
            $this->control( $id, $device );
        }
    }


	/**
	 * Add sequence control
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	private function control( $id, $device ) {

        $setting = sprintf( 'sequence-nav-%s', $id );

		// Setting: Taproot Branding Screen Nav
		$this->customize->add_setting( $setting, [
			'sanitize_callback' => 'sanitize_text_field',
		]);

		$this->customize->add_control( 
			new Sequence_Control( $this->customize, $setting, [
				'section' => $id,
				'prev' => [
					'section' => $this->previous_section( $id ),
					'label' => $this->previous,
					'device' => $this->sections[$this->previous_section( $id )]['device']
				],
				'next' => [
					'section' => $this->next_section( $id ),
					'label' => $this->next,
					'device' => $this->sections[$this->next_section( $id )]['device']
				],				
				'priority' => -20,
			]
		));
    }


    /**
	 * Get panel
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	private function get_panel() {		
		$section = $this->customize->get_section( key( $this->sections ) );
		return $section->panel;
	}
	

	/**
	 * Get Sections List
	 *
	 * @since  1.0.0
	 * @access private
	 * @return array
	 */
	private function get_sections_list() {
		return array_keys( $this->sections );
	}


	/**
	 * Get the section immediately before specified section
	 *
	 * @since 1.0.0
	 * @param string             $current
	 * @return string
	 */
	private function previous_section( $current ) {
		$sections = $this->get_sections_list();
		$index = array_search( $current, $sections );
		return ( isset( $sections[$index - 1] ) ) ? $sections[$index - 1] : false;
	}


	/**
	 * Get the section immediately after specified section
	 *
	 * @since 1.0.0
	 * @param string             $current
	 * @return string
	 */
	private function next_section( $current ) {
		$sections = $this->get_sections_list();
		$index = array_search( $current, $sections );
		return ( isset( $sections[$index + 1] ) ) ? $sections[$index + 1] : false;
	}

}
