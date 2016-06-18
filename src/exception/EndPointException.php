<?php
namespace web\ws\rest\exception {
	/**
	 * Throws an internal server error in php, giving back http response of same nature
	 */
	class EndPointException extends \ErrorException {
		public function __construct($message = ExceptionMessage::DEFAULT_ENDPOINT_ERROR, $statusCode = 500) {
			parent::__construct($message, $statusCode);
		}
	}
}
?>