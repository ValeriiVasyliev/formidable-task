<?php
/**
 * Admin class file.
 *
 * @package formidable-task
 */

namespace FormidableTask;

/**
 * Class Admin
 */
class Admin {

	/**
	 * The Plugin instance.
	 *
	 * @var Plugin
	 */
	protected $plugin;

	/**
	 * Instantiates the class.
	 *
	 * @param Plugin $plugin The plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Init class.
	 */
	public function init() {
		$this->hooks();
	}

	/**
	 * Class hooks.
	 */
	protected function hooks() {

	}
}
