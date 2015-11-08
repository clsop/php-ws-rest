<?php
namespace ws\rest\exception;

/**
 * Throws an internal server error in php, giving back http response of same nature
 */
class InternalServerException extends \ErrorException {
	const INTERNAL_ERROR_MESSAGE = 'An internal server error has occured.';

	public function __construct($message = InternalServerException::INTERNAL_ERROR_MESSAGE) {
		parent::__construct($message, 500);
	}
}
?>