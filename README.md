# Rootstrap: a WordPress Development Toolkit

Version: 2.0.0
Released: 11/03/2019

## Description

Rootstrap is a toolkit for managing WordPress Customizer related functionality when using the Hybrid Core library in a theme or plugin.

## Requirements

* WordPress 5.0+.
* Hybrid Core 5.1+
* [Composer](https://getcomposer.org/) for managing PHP dependencies.

## Features

Rootstrap provides a more nuanced set of action hooks for interacting with the WordPress Customizer. Having more specific hooks for 'customize_register' creates a standard to use when extending the Customizer's functionality through specialized modules.

This package on its own does not add any functionaliy. It only provides a foundation for other modules to add to.

### Installation

Use the following command from your command line to install the package.

```
composer require skyshab/rootstrap
```

## Documentation

Read the project wiki: https://github.com/skyshab/rootstrap/wiki

## Copyright and License

This project is licensed under the [GNU GPL](http://www.gnu.org/licenses/old-licenses/gpl-2.0.html), version 2 or later.

2014-2019 &copy; [Sky Shabatura](https://github.com/skyshab)
