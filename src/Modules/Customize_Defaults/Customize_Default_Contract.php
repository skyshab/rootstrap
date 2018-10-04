<?php
/**
 * Customize Default interface.
 *
 * Defines the interface that Customize Default classes must use.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Customize_Defaults;


/**
 * Customizer Default interface.
 *
 * @since  1.0.0
 * @access public
 */
interface Customize_Default_Contract {


    /**
     * Returns the customizer default id.
     *
     * @since  1.0.0
     * @access public
     * @return string
     */
    public function id();


    /**
     * Returns the customizer default value.
     *
     * @since  1.0.0
     * @access public
     * @return string
     */
    public function value();

}
