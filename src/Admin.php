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
		add_action( 'admin_menu', [ $this, 'add_menu' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Adds a settings page link to a menu
	 */
	public function add_menu() {
		add_menu_page(
			__( 'Formidable Task', 'formidable-task' ),
			__( 'Formidable Task', 'formidable-task' ),
			'manage_options',
			'formidable-task',
			[ $this, 'page_options' ],
			'dashicons-smiley',
			1
		);
	}


	/**
	 * Register the stylesheets for the plugin in the admin side of the site.
	 */
	public function enqueue_styles() {
		wp_register_style( 'formidable_task_style', $this->plugin->plugin_url() . '/assets/dist/css/admin.css', [], $this->plugin->version_assets() );
		wp_enqueue_style( 'formidable_task_style' );
	}

	/**
	 * Register the scripts for the plugin in the admin side of the site.
	 */
	public function enqueue_scripts() {
		wp_register_script( 'formidable_task_script', $this->plugin->plugin_url() . '/assets/dist/js/admin.js', [ 'jquery', 'wp-i18n' ], $this->plugin->version_assets(), true );
		wp_localize_script(
			'formidable_task_script',
			'templateSettings',
			[
				'apiSettings' => [
					'root'  => esc_url_raw( untrailingslashit( rest_url() ) ),
					'nonce' => wp_create_nonce( 'wp_rest' ),
				],
			]
		);
		wp_enqueue_script( 'formidable_task_script' );
	}

	/**
	 * Creates the admin page settings that displays the table
	 */
	public function page_options() {
		?>
		<div class="frm_wrap">
			<div id="frm_top_bar">
				<div id="frm-publishing"></div>
				<a href="#" class="frm-header-logo">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 599.68 601.37" width="35" height="35">
						<path fill="#f05a24" d="M289.6 384h140v76h-140z"></path>
						<path fill="#4d4d4d" d="M400.2 147h-200c-17 0-30.6 12.2-30.6 29.3V218h260v-71zM397.9 264H169.6v196h75V340H398a32.2 32.2 0 0 0 30.1-21.4 24.3 24.3 0 0 0 1.7-8.7V264zM299.8 601.4A300.3 300.3 0 0 1 0 300.7a299.8 299.8 0 1 1 511.9 212.6 297.4 297.4 0 0 1-212 88zm0-563A262 262 0 0 0 38.3 300.7a261.6 261.6 0 1 0 446.5-185.5 259.5 259.5 0 0 0-185-76.8z"></path>
					</svg>
				</a>
				<div class="frm_top_left frm_top_wide">
					<h1>
						<span><?php esc_html_e( 'Formidable Task', 'formidable-task' ); ?></span>
						<a id="refresh" ref="#" class="button button-primary frm-button-primary"><?php esc_html_e( 'Refresh', 'formidable-task' ); ?></a>
					</h1>
				</div>
			</div>
			<div class="wrap">
				<div id="frmchal-list"></div>
			</div>
		</div>
		<?php
	}
}
