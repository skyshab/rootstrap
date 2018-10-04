<?php
/**
 * Screens functions.
 *
 * Helper functions related to screens.
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @link      https://github.com/skyshab/rootstrap
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Rootstrap\Modules\Screens;

use Rootstrap\Modules\Styles\Styles;

/**
 * Add custom screen size styles to customizer head
 * 
 * @since 1.0.0
 * @return string
 */
function print_customize_controls_styles() {

    $styles = new Styles();
    $styles->add_screen( 'mobile-devices-only', ['max' => '1024px'] );

    $overlay_selector = '';

    foreach ( get_devices() as $name => $device ) {

        // add icon :before content
        $styles->add([
            'selector' => sprintf( 'button.preview-%s:before', $name ),
            'styles' => [
                'content' => $device->icon() 
            ]
        ]);

        // build selector for overlay styles
        $overlay_selector .= sprintf('.preview-%s #customize-preview.wp-full-overlay-main,', $name );


        // set customize preview screen max width
        $styles->add([
            'selector' => sprintf( 'body .preview-%s #customize-preview iframe', $name ),
            'styles' => [
                'width' => $device->max() . '!important'
            ],
            'callback' => $device->max()
        ]);

    } // end foreach

    // remove comma from last selector
    $overlay_selector = rtrim( $overlay_selector, ',' );

    $styles->add([
        'selector' => $overlay_selector,
        'styles' => [
            'background-color' => 'rgba(0, 0, 0, 0)',
            'width' =>  '100%',
            'height' => '100%',
            'max-width' => '100%',
            'max-height' => '100%',
            'margin' => 'auto',
            'left' => 'auto',
            'text-align' => 'center',
        ],
    ]);

    $styles->add([
        'selector' => '#customize-preview iframe',
        'styles' => [
            'transition' => 'all 0.5s ease-in-out'
        ],
    ]);

    $styles->add([
        'screen' =>'mobile-devices-only',
        'selector' => '#customize-controls .wp-full-overlay-footer .devices',
        'styles' => [
            'display' => 'block'
        ]
    ]);

    $styles->add([
        'selector' => '.wp-full-overlay-footer .devices button:before',
        'styles' => [
            'padding' => '4px 6px'
        ]
    ]);

    // print styles
    $styles->print( 'customize-controls' );
}