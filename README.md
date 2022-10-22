## Table of Contents

* [Task](#task)
* [Usage](#usage)
* [Requirements](#requirements)
* [Installation](#installation)
* [Development](#development)
* [Frontend](#frontend)
* [PHP Coding Standard (PHPCS)](#php-coding-standard)
* [Clean up code with PHPCBF](#clean-up-code-with-phpcbf)
* [PHP unit tests](#php-unit-tests)

## Task

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

## Usage 

In order to display the data in the frontend is necessary to add the shortcode `[formidable-task]` in the desired page content.

Use WP CLI command that can be used to force the refresh of this data the next time the AJAX endpoint is called. The command is:
```
  wp formidable-task refresh
```

## Requirements

Make sure all dependencies have been installed before moving on:

| Requirement | How to Check | How to Install |
| :---------- | :----------- | :------------- |
| PHP >= 7.4 | `php -v` | [php.net](http://php.net/manual/en/install.php) |
| [WordPress >= 5.9]() | `Admin Footer` | [wordpress.org](https://codex.wordpress.org/Installing_WordPress) |
| Composer >= 2.1.6 | `composer --version` | [getcomposer.org](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) |
| Node >= 14.x | `node -v` | [nodejs.org](https://nodejs.org/) |
| NPM >= 6.x | `npm -v` | [npm.js](https://www.npmjs.com/) |
| WP CLI >= 2.4.0 | `wp --info` | [githubusercontent.com](https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar) |

## 🧞 Installation

```
composer install --no-dev
npm install && npm run build:production
```

## 👀 Development

```
composer install
npm install && npm run build
```

## Frontend

All assets are located in `assets/src/*`.

All builds are located in `assets/build/*`.

We use [Laravel Mix](https://laravel-mix.com/) for the assets build. You can modify it in `.webpack.mix.js` file.

For run Laravel mix you can use the next commands depend on situation:
```
npm run build
npm run build:production
npm run start
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
