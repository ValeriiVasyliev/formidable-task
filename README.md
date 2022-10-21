# Task

Using the GET accessible endpoint http://api.strategy11.com/wp-json/challenge/v1/1 (there are no parameters to/from required), create an AJAX endpoint in WordPress that:

- Can be used when logged out or in;

- Calls the above endpoint to get the data to return;

- Which when called always returns the data, but regardless of when/how many times it is called should not request the data from our server more than 1 time per hour.
- Create a shortcode for the frontend, that when loaded uses Javascript to contact your AJAX endpoint and display the data returned formatted into a table-like display;
- Create a WP CLI command that can be used to force the refresh of this data the next time the AJAX endpoint is called;
- Create a WordPress admin page which displays this data in the style of the admin page of the WordPress plugin Formidable Forms that includes the Formidable logo and header. Include a button to refresh the data.
- Create unit tests that check the following:
	- Is the request run multiple times an hour?
	- Is the table showing the expected results?

Ensure to properly escape, sanitize and validate data in each step as appropriate using built in PHP and WordPress functions.

The code you submit should not be built from a boilerplate.

## Table of Contents

* [Requirements](#requirements)
* [Installation](#installation)
* [Development](#development)
* [PHP Coding Standard (PHPCS)](#php-coding-standard)
* [Clean up code with PHPCBF](#clean-up-code-with-phpcbf)
* [PHP unit tests](#php-unit-tests)
* [Brief justification](#brief-justification)
* [Testing](#testing)
* [How long the test took to complete](#how-long-the-test-took-to-complete)

## Requirements

Make sure all dependencies have been installed before moving on:

| Requirement | How to Check | How to Install |
| :---------- | :----------- | :------------- |
| PHP >= 7.4 | `php -v` | [php.net](http://php.net/manual/en/install.php) |
| Composer >= 2.1.6 | `composer --version` | [getcomposer.org](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) |

## 🧞 Installation

```
composer install --no-dev
```

## 👀 Development

```
composer install
```

## PHP Coding Standard

Custom PHPCS your can find in the `.phpcs.xml`.

Your can check PHPCS using a CLI:
```
composer cs
```

## Clean up code with PHPCBF

Automatically  fix  as  many sniff violations as possible.

Your can check PHPCBF using a CLI:
```
composer cs-fix
```

## PHP unit tests

For running use a CLI command:
```
composer unit
```

- Main configuration file `.tests/php/unit.suite.yml`
- Unit tests inside `.tests/php/unit/*` folder.
- Bootstrap file `.tests/php/unit/_bootstrap.php`
- Each filename for test class must have a suffix on `*Test.php`.
- Each test class must extend a `FormidableTask\TestCase` class.
- You can also add some code to `FormidableTask\TestCase.php`
- Each test method must have prefix `test_`
- Additional files for autoloading in tests running you can add to `.codeception/_support/*` folder.
