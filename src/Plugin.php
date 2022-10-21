<?php
/**
 * Plugin class file.
 *
 * @package formidable-task
 */

namespace FormidableTask;

/**
 * Class Plugin
 */
class Plugin {

	/**
	 * URL for the plugin directory
	 *
	 * @var string
	 */
	protected $plugin_url;

	/**
	 * Absolute path to the root directory of this plugin.
	 *
	 * @var string
	 */
	protected $dir;

	/**
	 * API instance.
	 *
	 * @var API
	 */
	private $api;

	/**
	 * Sets up the plugin.
	 *
	 * @param API    $api API instance.
	 * @param string $plugin_file_path Absolute path to the main plugin file.
	 */
	public function __construct( $api, $plugin_file_path ) {

		$this->api        = $api;
		$this->plugin_url = untrailingslashit( plugin_dir_url( $plugin_file_path ) );
		$this->dir        = dirname( $plugin_file_path );
	}

	/**
	 * Init class.
	 */
	public function init() {

		$this->hooks();

		( new Admin( $this ) )->init();
		( new WP_CLI( $this ) )->init();
		( new Shortcode( $this ) )->init();
	}

	/**
	 * Class hooks.
	 */
	protected function hooks() {

		add_action( 'plugins_loaded', [ $this, 'load_plugin_textdomain' ] );
	}

	/**
	 * Load plugin text domain.
	 */
	public function load_plugin_textdomain() {
		global $l10n;

		$domain = 'formidable-task';

		if ( isset( $l10n[ $domain ] ) ) {
			return;
		}

		load_plugin_textdomain(
			$domain,
			false,
			$this->dir . '/languages/'
		);
	}

	/**
	 * Gets the absolute path to the plugin directory.
	 *
	 * @return string This plugin's directory.
	 */
	public function plugin_url() {
		return $this->plugin_url;
	}

	/**
	 * Gets the version for assets
	 */
	public function version_assets() {

		$prefix = '';
		if ( file_exists( $this->dir . '/assets/version.php' ) ) {
			$prefix = include $this->dir . '/assets/version.php';
		}
		return $prefix;
	}
}
