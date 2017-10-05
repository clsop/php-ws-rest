<?php
namespace web\ws\rest\test {
	use PHPUnit\Framework\TestCase;

	class RestErrorTest extends \web\ws\rest\REST {
		public function get() {
			$test = 5 / 0; // result in warning/error
		}
	}

	class RestExceptionTest extends \web\ws\rest\REST {
		public function get() {
			throw new \ErrorException();
		}
	}

	class ErrorExceptionHandlerTest extends TestCase {
		public static function setupBeforeClass() {
			$_SERVER['REQUEST_METHOD'] = 'GET';
			$_SERVER['HTTP_ACCEPT'] = 'application/json,application/xml';
			$_SERVER['CONTENT_TYPE'] = 'application/json';
		}

		public function testOnError() {
			// arrange
			$mock = $this->getMockBuilder(RestErrorTest::class)
				->setMethods(['onError'])->getMock();

			// assert
			$mock->expects($this->once())->method('onError')->willReturn(true); // true tells error has been handled

			// act
			$mock->processRequest();
		}

		public function testOnException() {
			// arrange
			$mock = $this->getMockBuilder(RestExceptionTest::class)
				->setMethods(['onException'])->getMock();

			// assert
			// TODO: check assertion
			$this->expectException(\ErrorException::class);
			$mock->expects($this->once())->method('onException')->willReturn(true); // true tells exception has been handled

			// act
			$mock->processRequest();
		}
	}
}
?>