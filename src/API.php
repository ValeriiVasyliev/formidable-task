<?php
/**
 * API class file.
 *
 * @package formidable-task
 */

namespace FormidableTask;

use Exception;

/**
 * Class Main
 */
class API {

	/**
	 * Endpoint remote.
	 */
	private const END_POINT_REMOTE = 'http://api.strategy11.com/wp-json/challenge/v1/1';

	/**
	 * Transient name.
	 */
	private const TRANSIENT = 'strategy11-api';

	/**
	 * Transient name.
	 */
	private const TRANSIENT_EXPIRATION = 3600;

	/**
	 * Get items form remote server.
	 *
	 * @param boolean $force The param for forcing data from API.
	 * @return array
	 *
	 * @throws \JsonException JsonException.
	 */
	public function get_items( $force = false ): array {

		$items = get_transient( self::TRANSIENT );

		if ( false === $items || true === $force ) {
			try {
				$response = wp_remote_get( self::END_POINT_REMOTE );
				if ( ( ! is_wp_error( $response ) ) && ( 200 === wp_remote_retrieve_response_code( $response ) ) ) {
					$items = json_decode( $response['body'], true, 512, JSON_THROW_ON_ERROR );
					if ( json_last_error() === JSON_ERROR_NONE ) {
						set_transient( self::TRANSIENT, $items, self::TRANSIENT_EXPIRATION );
					}
				} else {
					return false;
				}
				// phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch
			} catch ( Exception $ex ) {
				// Handle Exception.
			}
		}

		return $items;
	}
}
