<?php
/**
 * Device class.
 *
 * This class creates a device object.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Devices;

use Rootstrap\Modules\Screens\Screen;


/**
 * Creates a new object device.
 *
 * @since  1.0.0
 * @access public
 */
class Device extends Screen {

    
    /**
     * Device Icon
     *
     * @since  1.0.0
     * @access protected
     * @var    string
     */
    public $icon = false;    


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

}
