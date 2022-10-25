<?php
namespace FormidableTaskTests;

use FormidableTask\Plugin;
use FormidableTask\API;
use FormidableTask\REST;
use function Brain\Monkey\Functions\expect;
use function Brain\Monkey\Functions\when;
use function Brain\Monkey\Functions\stubs;

class PluginTest extends TestCase {

	/**
	 * Sets the instance.
	 */
	protected function setUp(): void {
		parent::setUp();
	}

	/**s
	 * Test if the request run multiple times an hour
	 */
	public function test_request_multiple_times() {

		$instance = \Mockery::mock( API::class )->makePartial();

		when( '\get_transient' )->justReturn( false );

		when( '\wp_remote_get' )->justReturn( [ 'body' => '{"test":"response"}' ] );

		when( '\is_wp_error' )->justReturn( false );

		when( '\wp_remote_retrieve_response_code' )->justReturn( 200 );

		expect( '\set_transient' )->once()->andReturn( true );

		expect( '\sanitize_text_field' )->atLeast()->once()->andReturnUsing(
			function( $value ) {
				return $value;
			}
		);

		$items1 = $instance->get_items();

		when( '\get_transient' )->justReturn( [ 'test' => 'response' ] );

		when( '\wp_remote_get' )->justReturn( [ 'body' => '{"test":"response123"}' ] );

		when( '\is_wp_error' )->justReturn( false );

		when( '\wp_remote_retrieve_response_code' )->justReturn( 200 );

		expect( '\set_transient' )->never()->andReturn( true );

		expect('\sanitize_text_field')->never();

		$items2 = $instance->get_items();

		$this->assertEquals( $items1, $items2, 'The second request didn\'t update the database. Used the transient cache for the second request' );
	}

	/**
	 * Test if the table is showing the expected results
	 */
	public function test_table_showing_expected_results() {

		$result = [
			"title" => "This amazing table",
			"data" => [
				"headers" => [
					"ID",
					"First Name",
					"Last Name",
					"Email",
					"Date"
				],
				"rows" => [
					[
						"id" => 66,
						"fname" => "Chris",
						"lname" => "Test",
						"email" => "chris@test.com",
						"date" => 1666629116
					],
					[
						"id" => 12,
						"fname" => "Bob",
						"lname" => "Test",
						"email" => "bob@test.com",
						"date" => 1666542716
					],
					[
						"id" => 33,
						"fname" => "Bill",
						"lname" => "Test",
						"email" => "bill@test.com",
						"date" => 1667384516
					],
					[
						"id" => 54,
						"fname" => "Jack",
						"lname" => "Test",
						"email" => "jack@test.com",
						"date" => 1667838716
					],
					[
						"id" => 92,
						"fname" => "Joe",
						"lname" => "Test",
						"email" => "joe@test.com",
						"date" => 1666974716
					]
				]
			]
		];

		$instance_api = \Mockery::mock( API::class );

		$instance_api->shouldReceive( 'get_items' )->once()->andReturn( $result );

		$instance_plugin = \Mockery::mock( Plugin::class );

		$instance_plugin->shouldReceive( 'get_api' )->once()->andReturn( $instance_api );

		$instance = \Mockery::mock(REST::class, [ $instance_plugin ]  )->makePartial();

		stubs(
			[
				'\esc_html',
				'\esc_html_e'
			]
		);

		expect( '\get_option' )
			->once()
			->with( 'date_format' )
			->andReturn('F j, Y');

		expect( '\get_option' )
			->once()
			->with( 'time_format' )
			->andReturn('g:i a');

		expect( '\_n' )
			->with( \Mockery::type( 'string' ), \Mockery::type( 'string' ), count($result),  'formidable-task' )
			->atLeast()
			->andReturn( 'translated' );

		expect( '\wp_date' )
			->andReturnUsing(
				function( $date_string, $time ) {
					return date( $date_string, $time );
				}
			);

		$instance -> get_formidable_table_response();
	}
}
