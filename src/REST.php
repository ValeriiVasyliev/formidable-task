<?php
/**
 * REST class file.
 *
 * @package formidable-task
 */

namespace FormidableTask;

use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;

/**
 * Class REST
 */
class REST {

	/**
	 * Rest namespace.
	 */
	const REST_NAMESPACE = 'formidable-task';

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
		add_action( 'rest_api_init', [ $this, 'register_rest_routes' ] );
		add_filter( 'filter_formidable_table_response_response', [ $this, 'get_formidable_table_response' ], ( PHP_INT_MAX - 10 ), 2 );
	}

	/**
	 * Register rest endpoint
	 *
	 * @return void
	 */
	public function register_rest_routes() {
		register_rest_route(
			self::REST_NAMESPACE,
			'/read',
			[
				'methods'             => WP_REST_Server::READABLE,
				'permission_callback' => '__return_true',
				'callback'            => [ $this, 'read' ],
			]
		);
	}

	/**
	 * Callback to handler rest api for form data list read request
	 *
	 * @param WP_REST_Request $request  The request instance.
	 * @return WP_REST_Response|WP_Error
	 */
	public function read( WP_REST_Request $request ) {

		if ( ! wp_verify_nonce( sanitize_text_field( $request->get_header( 'X-WP-Nonce' ) ?? '' ), 'wp_rest' ) ) {
			return new WP_Error( 'invalid_request', __( 'Invalid request.', 'formidable-task' ) );
		}

		$response = array_merge(
			[ 'html' => apply_filters( 'filter_formidable_table_response_response', false ) ],
			[ 'code' => 'ok' ],
		);

		return new WP_REST_Response( $response, 200 );
	}

	/**
	 * Get responce for data list.
	 *
	 * @param boolean $force The param for forcing data from API.
	 *
	 * @return false|string
	 */
	public function get_formidable_table_response( $force = false ) {
		ob_start();

		$items = $this->plugin->get_api()->get_items( $force );

		if ( $items ) {
			$date_format = get_option( 'date_format' );

			$time_format = get_option( 'time_format' );

			$count = count( $items['data']['rows'] );

			$headers = [];
			?>
			<div class="tablenav top">
				<div class="tablenav-pages one-page">
					<span class="displaying-num">
						<?php /* translators: %d count users */ ?>
						<?php echo esc_html( sprintf( _n( '%s user', '%s users', $count, 'formidable-task' ), $count ) ); ?>
					</span>
				</div>
				<br class="clear">
			</div>
			<table class="wp-list-table widefat fixed striped ">
				<thead>
				<tr>
					<?php foreach ( $items['data']['headers'] as $header ) : ?>
						<?php $headers[] = $header; ?>
						<th><?php echo esc_html( $header ); ?></th>
					<?php endforeach; ?>
				</tr>
				</thead>
				<tbody id="the-list">
				<?php foreach ( $items['data']['rows'] as $row ) : ?>
					<tr>
						<?php $i = 0; ?>
						<?php foreach ( $row as $r ) : ?>
							<td>
								<?php if ( 'Date' === $headers[ $i ] ) { ?>
									<?php echo esc_html( wp_date( $date_format . ' ' . $time_format, $r ) ); ?>
								<?php } else { ?>
									<?php echo esc_html( $r ); ?>
								<?php } ?>
							</td>
							<?php $i++; ?>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
				</tbody>
				<tfoot>
				<tr>
					<?php foreach ( $items['data']['headers'] as $header ) : ?>
						<th><?php echo esc_html( $header ); ?></th>
					<?php endforeach; ?>
				</tr>
				</tfoot>
			</table>
			<div class="tablenav bottom">
				<div class="tablenav-pages one-page">
					<span class="displaying-num">
						<?php /* translators: %d count users */ ?>
						<?php echo esc_html( sprintf( _n( '%d user', '%d users', $count, 'formidable-task' ), $count ) ); ?>
					</span>
				</div>
			</div>
			<?php
		} else {
			esc_html_e( 'None users', 'formidable-task' );
		}

		return ob_get_clean();
	}
}
