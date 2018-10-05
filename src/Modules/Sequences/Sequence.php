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
use Rootstrap\Abstracts\Section_Group as Group; 


/**
 * Creates a new sequence object.
 *
 * @since  1.0.0
 * @access public
 */
class Sequence extends Group {


    /**
     * Previous label.
     *
     * @since  1.0.0
     * @access public
     * @var    string 
     */
    public $previous;
    
    /**
     * Next label.
     *
     * @since  1.0.0
     * @access public
     * @var    string 
     */
    public $next;


    /**
     * Add sequence control
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
   public function control( $id ) {

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
