<?php
/**
 * API class file.
 *
 * @package formidable-task
 */

namespace FormidableTask;

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
			$response = wp_remote_get( self::END_POINT_REMOTE );
			$items    = json_decode( $response['body'], true, 512, JSON_THROW_ON_ERROR );
			set_transient( self::TRANSIENT, $items, self::TRANSIENT_EXPIRATION );
		}

		return $items;
	}
}
