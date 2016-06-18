<?php
namespace web\ws\rest\test {
	use PHPUnit\Framework\TestCase;
	use \web\ws\rest\exception as ex;

	class RestRequestProcessTest extends \web\ws\rest\REST {
		
	}

	class RestUnknownStatusCodeTest extends \web\ws\rest\REST {
		public function get() {
			$this->serveResponse(109);
		}
	}

	class RestInvalidArrayStructureTest extends \web\ws\rest\REST {
		public function get() {
			$this->serveResponse(200, ['test']);
		}
	}

	class ExceptionTest extends TestCase {
		public function setup() {
			$_SERVER['REQUEST_METHOD'] = 'GET';
			$_SERVER['HTTP_ACCEPT'] = 'application/json,application/xml';
			$_SERVER['CONTENT_TYPE'] = 'application/json';
		}

		public function testCannotProvideContent() {
			// arrange
			$_SERVER['HTTP_ACCEPT'] = 'multipart/form';
			$rest = new RestRequestProcessTest();

			// assert
			$this->expectException(ex\EndPointException::class);
			$this->expectExceptionMessage(ex\ExceptionMessage::UNACCEPTED_CONTENT);

			// act
			$rest->processRequest();
		}

		public function testMethodNotSupported() {
			// arrange
			$_SERVER['REQUEST_METHOD'] = 'PUT';
			$rest = new RestRequestProcessTest();

			// assert
			$this->expectException(ex\EndPointException::class);
			$this->expectExceptionMessage(ex\ExceptionMessage::UNSUPPORTED_METHOD);

			// act
			$rest->processRequest();
		}

		public function testUnknownStatusCode() {
			// arrange
			$rest = new RestUnknownStatusCodeTest();

			// assert
			$this->expectException(ex\InternalServerException::class);
			$this->expectExceptionMessage(ex\ExceptionMessage::UNKNOWN_STATUS);

			// act
			$rest->processRequest();
		}

		public function testInvalidDataArrayStructure() {
			// arrange
			$rest = new RestInvalidArrayStructureTest();

			// assert
			$this->expectException(ex\InternalServerException::class);
			$this->expectExceptionMessage(ex\ExceptionMessage::INVALID_ARRAY_STRUCTURE);

			// act
			$rest->processRequest();
		}
	}
}
?>