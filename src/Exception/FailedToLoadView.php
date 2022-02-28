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
 * Class FailedToLoadView.
 *
 * @since   0.1.0
 *
 * @package EcoTechie\Commenter\Exception
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class FailedToLoadView extends \RuntimeException implements CommenterException {

	/**
	 * Create a new instance of the exception if the view file itself created
	 * an exception.
	 *
	 * @since 0.1.0
	 *
	 * @param string     $uri       URI of the file that is not accessible or
	 *                              not readable.
	 * @param \Exception $exception Exception that was thrown by the view file.
	 *
	 * @return static
	 */
	public static function view_exception( $uri, $exception ) {
		$message = sprintf(
			'Could not load the View URI "%1$s". Reason: "%2$s".',
			$uri,
			$exception->getMessage()
		);

		return new static( $message, $exception->getCode(), $exception );
	}
}
