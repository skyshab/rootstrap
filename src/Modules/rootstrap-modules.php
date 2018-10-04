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
    'boot' => ['Manager'],
    'includes' => [
        'functions-screens',
        'functions-customize'
    ],
    'instances' => [
        'Devices',
        'Screens'
    ]
];


/* Configure Customize Defaults Module */
$rootstrap_modules['Customize_Defaults'] = [
    'boot' => ['Manager'],
    'includes' => ['functions-customize-defaults'],
    'instances' => ['Customize_Defaults'],
];


/* Configure Post Customizer Module */
$rootstrap_modules['Post_Customizer'] = [
    'boot' => ['Post_Customizer'],  
    'includes' => ['functions-post-customizer'],
    'instances' => ['Post_Customizer'] 
];


/* Configure Tabs Module */
$rootstrap_modules['Tabs'] = [
    'boot' => ['Manager']
];


/* Configure Sequences Module */
$rootstrap_modules['Sequences'] = [
    'boot' => ['Manager']
];


return $rootstrap_modules;
