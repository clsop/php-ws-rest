<?php
namespace ws\rest\exception;

/**
 * Throws an internal server error in php, giving back http response of same nature
 */
class EndPointException extends \ErrorException {
	const INTERNAL_ERROR_MESSAGE = 'Could not find endpoint (most likely web server rewrite rules missing)';

	public function __construct($message = EndPointException::INTERNAL_ERROR_MESSAGE, $statusCode = 500) {
		parent::__construct($message, $statusCode);
	}
}
?>