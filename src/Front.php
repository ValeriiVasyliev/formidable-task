<?php
/**
 * Front class file.
 *
 * @package formidable-task
 */

namespace FormidableTask;

/**
 * Class Front
 */
class Front {
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
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_shortcode( 'formidable-task', [ $this, 'get_formidable_table' ] );
	}

	/**
	 * Register the stylesheets for the plugin in the public side of the site.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_styles() {
		wp_register_style( 'formidable_task_front_style', $this->plugin->plugin_url() . '/assets/dist/css/front.css', [], $this->plugin->version_assets() );
	}

	/**
	 * Register the scripts for the plugin in the public side of the site.
	 *
	 * @since 1.0.0
	 * @return void
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
	}

	/**
	 * Displays the table if the content of the page has the shortcode [formidable-task]
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string
	 */
	public function get_formidable_table() : string {

		wp_enqueue_style( 'formidable_task_front_style' );
		wp_enqueue_script( 'formidable_task_script' );

		ob_start();
		?>
		<div class="frm_wrap">
			<div id="frm_top_bar">
				<div class="frm_top_left frm_top_wide">
					<h1>
						<span><?php esc_html_e( 'Formidable Task', 'formidable-task' ); ?></span>
					</h1>
				</div>
			</div>
			<div class="wrap">
				<div id="frmchal-list"></div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
