<?php
/**
 * Actor for acceptance tests
 *
 * @since   1.0.0
 * @link    https://valera.codes/
 * @license GPLv2 or later
 * @package
 * @author  Valerii Vasyliev
 */

use Codeception\Actor;


/**
 * Inherited Methods
 *
 * @since {VERSION}
 *
 * @method void wantToTest( $text )
 * @method void wantTo( $text )
 * @method void execute( $callable )
 * @method void expectTo( $prediction )
 * @method void expect( $prediction )
 * @method void amGoingTo( $argumentation )
 * @method void am( $role )
 * @method void lookForwardTo( $achieveValue )
 * @method void comment( $description )
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceFormidableTask extends Actor {

	use _generated\AcceptanceTesterActions;
}
