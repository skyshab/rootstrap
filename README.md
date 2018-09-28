# Rootstrap: WordPress Theme Framework

Rootstrap is a collection of utilities for managing WordPress Customizer controls, settings, responsive breakpoints and styles. 

## Requirements

* WordPress 4.9.6+.
* PHP 5.6+ (7.0+ recommended).
* [Composer](https://getcomposer.org/) for managing PHP dependencies.

The framework is coded to work on PHP 5.6+, but only 7.0+ is officially supported.

## Features

Rootstrap allows theme or plugin developers to define certain project variables in 
a configuration file, and have them applied in the Customizer and admin. It also 
includes a collection of tools for managing customizer controls, settings,
responsive breakpoints and styles. 

* Devices

  In the WordPress customizer, there are three device buttons for the Customize Preview, 
  mobile, tablet and desktop. Rootstrap devices lets you easily register new devices to 
  the Cusomtizer Control bar, and set the minimum and maximum screen widths for each device. 

* Screens

  Screens represent the responsive breakpoints that a website uses to determine when 
  changes occur with layouts, components and other styles. Screens are generated from
  the registered devices into all possible combinations, but custom screens can also
  be defined. Screens can then have styles associated with them and output when needed. 

* Styles

  Styles for customizer settings can be created cleanly within PHP, organized by screen, 
  and stored in a variable or echoed out when needed. Each style can be associated with a Screen, 
  and all styles of each screen will be output together in a single media query. 

* Customizer defaults

  Define the default values for customizer controls in the Rootstrap config file. The initial 
  values will be set in the customizer. Styles for these values can be output automatically 
  so that the settings match the way the site displays. Use cases would be setting the default 
  theme styles, or child theme styles. 

* Post Customizer

  The Post Customizer will check the post meta for matching Customizer setting ids. If found, 
  the post values will supercede the customizer settings. This functionality can be enabled 
  on any post types, but is set to posts only by default.


### Installation

Use the following command from your preferred command line utility to install the package.

```bash
composer require skyshab/rootstrap
```

### Using Rootstrap in your theme

A preview:

* How to load the javascript
* Define Laravel Mix alias 
* Creating a Rootstrap config file
* Working with Styles and Screens
* Define supported post types for the Post Customizer

## Documentation

// what's up doc?


## Copyright and License

This project is licensed under the [GNU GPL](http://www.gnu.org/licenses/old-licenses/gpl-2.0.html), version 2 or later.

2014-2018 &copy; [Sky Shabatura](https://sky.camp).
