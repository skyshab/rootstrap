<?php
/**
 * This file returns an array of rootstrap modules.
 *
 * @package rootstrap/modules
 * @since 1.0.0
 */


/* define rootstrap modules array */
$rootstrap_modules = [];


/* Configure Screens Module */
$rootstrap_modules['Screens'] = [
    'includes' => [
        'functions-screens',
        'functions-customize'
    ],
    'boot' => ['Manager'],
    'instances' => [
        'Devices',
        'Screens'
    ]
];


/* Configure Customize Defaults Module */
$rootstrap_modules['Customize_Defaults'] = [
    'includes' => ['functions-customize-defaults'],
    'boot' => ['Manager'],
    'instances' => ['Customize_Defaults'],
];


/* Configure Post Customizer Module */
$rootstrap_modules['Post_Customizer'] = [
    'includes' => ['functions-post-customizer'],
    'boot' => ['Post_Customizer'],  
    'instances' => ['Post_Customizer'] 
];


return $rootstrap_modules;
