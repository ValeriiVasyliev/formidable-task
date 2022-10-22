<?php
/**
 * WP_CLI class file.
 *
 * @package formidable-task
 */

namespace FormidableTask;

/**
 * Class WP_CLI
 */
class WP_CLI {

	/**
	 * Refresh the user data
	 *
	 * @param  array $args  Required arguments for the query.
	 * @param  array $assoc_args Arguments provided in when invoking the command.
	 * @return void
	 */
	public function refresh( $args, $assoc_args ) {

		$api = new API();

		$items = $api->get_items( true );

		if ( ! $items ) {
			\WP_CLI::error( 'Error refreshing' );
		} else {
			\WP_CLI::success( 'Done!' );
		}
	}
}
