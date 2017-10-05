<?php
namespace web\ws\rest\test {
	use PHPUnit\Framework\TestCase;

	class RestParamTest extends \web\ws\rest\REST {
		public function get($param = NULL) {
			
		}

		public function post($param = NULL, $data = NULL) {
			
		}

		public function put($param = NULL, $data = NULL) {
			
		}

		public function delete($param = NULL) {
			
		}
	}

	class HttpMethodTest extends TestCase {
		private $rest;

		public function setup() {
			$_SERVER['HTTP_ACCEPT'] = 'application/json,application/xml';
			$_SERVER['CONTENT_TYPE'] = 'application/json';
		}

		public function testGet() {
			// arrange
			$_SERVER['REQUEST_METHOD'] = 'GET';

			$rest = $this->getMockBuilder(RestParamTest::class)
				->setMethods(['get'])
				->getMock();

			// assert
			$rest->expects($this->once())
				->method('get')
				->with(NULL);

			// act
			$rest->processRequest();
		}

		public function testGetWithParam() {
			// arrange
			$param = 1;
			$_SERVER['REQUEST_METHOD'] = 'GET';
			$_REQUEST['param'] = $param;

			$rest = $this->getMockBuilder(RestParamTest::class)
				->setMethods(['get'])
				->getMock();

			// assert
			$rest->expects($this->once())
				->method('get')
				->with($this->equalTo($param));

			// act
			$rest->processRequest();
		}

		public function testPost() {
			// arrange
			$_SERVER['REQUEST_METHOD'] = 'POST';

			$rest = $this->getMockBuilder(RestParamTest::class)
				->setMethods(['post'])
				->getMock();

			// assert
			$rest->expects($this->once())
				->method('post')
				->with(NULL);

			// act
			$rest->processRequest();
		}

		public function testPostWithParam() {
			// arrange
			$param = 1;
			$_SERVER['REQUEST_METHOD'] = 'POST';
			$_REQUEST['param'] = $param;

			$rest = $this->getMockBuilder(RestParamTest::class)
				->setMethods(['post'])
				->getMock();

			// assert
			$rest->expects($this->once())
				->method('post')
				->with($this->equalTo($param));

			// act
			$rest->processRequest();
		}

		public function testPostWithData() {
			// arrange
			$_SERVER['REQUEST_METHOD'] = 'POST';

			$this->rest = $this->getMockBuilder(RestParamTest::class)
				->setMethods(['post', 'processRequest'])
				->getMock();
			$this->rest->method('processRequest')
				->will($this->returnCallback(function() {
					$server = new \web\ws\rest\serve\ServeJSON();
					$data = '{"test1": "test1", "test2": "test2", "test3": "test3"}';
					$this->rest->post(NULL, $server->processContent($data));
				}));

			// assert
			$this->rest->expects($this->once())
				->method('post')
				->withConsecutive([$this->isNull(), $this->logicalAnd(
					$this->arrayHasKey('test1'), $this->contains('test1'),
					$this->arrayHasKey('test2'), $this->contains('test2'),
					$this->arrayHasKey('test3'), $this->contains('test3')
				)]);

			// act
			$this->rest->processRequest();
		}

		public function testPut() {
			// arrange
			$_SERVER['REQUEST_METHOD'] = 'PUT';

			$rest = $this->getMockBuilder(RestParamTest::class)
				->setMethods(['put'])
				->getMock();

			// assert
			$rest->expects($this->once())
				->method('put')
				->with(NULL);

			// act
			$rest->processRequest();
		}

		public function testPutWithParam() {
			// arrange
			$param = 1;
			$_SERVER['REQUEST_METHOD'] = 'PUT';
			$_REQUEST['param'] = $param;

			$rest = $this->getMockBuilder(RestParamTest::class)
				->setMethods(['put'])
				->getMock();

			// assert
			$rest->expects($this->once())
				->method('put')
				->with($this->equalTo($param));

			// act
			$rest->processRequest();
		}

		public function testPutWithData() {
			// arrange
			$_SERVER['REQUEST_METHOD'] = 'PUT';

			$this->rest = $this->getMockBuilder(RestParamTest::class)
				->setMethods(['put', 'processRequest'])
				->getMock();
			$this->rest->method('processRequest')
				->will($this->returnCallback(function() {
					$server = new \web\ws\rest\serve\ServeJSON();
					$data = '{"test1": "test1", "test2": "test2", "test3": "test3"}';
					$this->rest->put(NULL, $server->processContent($data));
				}));

			// assert
			$this->rest->expects($this->once())
				->method('put')
				->withConsecutive([$this->isNull(), $this->logicalAnd(
					$this->arrayHasKey('test1'), $this->contains('test1'),
					$this->arrayHasKey('test2'), $this->contains('test2'),
					$this->arrayHasKey('test3'), $this->contains('test3')
				)]);

			// act
			$this->rest->processRequest();
		}

		public function testDelete() {
			// arrange
			$_SERVER['REQUEST_METHOD'] = 'DELETE';

			$rest = $this->getMockBuilder(RestParamTest::class)
				->setMethods(['delete'])
				->getMock();

			// assert
			$rest->expects($this->once())
				->method('delete')
				->with(NULL);

			// act
			$rest->processRequest();
		}

		public function testDeleteWithParam() {
			// arrange
			$param = 1;
			$_SERVER['REQUEST_METHOD'] = 'DELETE';
			$_REQUEST['param'] = $param;

			$rest = $this->getMockBuilder(RestParamTest::class)
				->setMethods(['delete'])
				->getMock();

			// assert
			$rest->expects($this->once())
				->method('delete')
				->with($this->equalTo($param));

			// act
			$rest->processRequest();
		}
	}
}
?>