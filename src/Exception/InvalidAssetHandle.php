<?php
/**
 * @package EcoTechie\Commenter
 * @author  Sergio Scabuzzo <sergio@ecotechie.io>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link    https//www.ecotechie.io/commenter
 * @since   0.1.0
 */

namespace EcoTechie\Commenter\Exception;

/**
 * Class InvalidAssetHandle.
 *
 * @since   0.1.0
 *
 * @package EcoTechie\Commenter\Exception
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class InvalidAssetHandle extends \InvalidArgumentException implements CommenterException {

	/**
	 * Create a new instance of the exception for a asset handle that is not
	 * valid.
	 *
	 * @since 0.1.0
	 *
	 * @param int $handle Asset handle that is not valid.
	 *
	 * @return static
	 */
	public static function from_handle( $handle ) {
		$message = sprintf(
			'The asset handle "%s" is not valid.',
			$handle
		);

		return new static( $message );
	}
}
