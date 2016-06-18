<?php
namespace web\ws\rest\test {
	use PHPUnit\Framework\TestCase;

	class RestOKTest extends \web\ws\rest\REST {
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
		public function setup() {
			$_SERVER['HTTP_ACCEPT'] = 'application/json,application/xml';
			$_SERVER['CONTENT_TYPE'] = 'application/json';
		}

		public function testGet() {
			// arrange
			$_SERVER['REQUEST_METHOD'] = 'GET';
			$rest = $this->getMockBuilder(RestOKTest::class)
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

			$rest = $this->getMockBuilder(RestOKTest::class)
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
			$rest = $this->getMockBuilder(RestOKTest::class)
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

			$rest = $this->getMockBuilder(RestOKTest::class)
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
			// TODO: mockup request body data

			// arrange
			$_SERVER['REQUEST_METHOD'] = 'POST';
			$rest = $this->getMockBuilder(RestOKTest::class)
				->setMethods(['post'])
				->getMock();

			// assert
			// $rest->expects($this->once())
			// 	->method('post')
			// 	->withConsecutive([$this->isNull(), $this->attributeEqualTo('test1', "test")]);

			// act
			$rest->processRequest();
			$this->markTestIncomplete('missing mockup to request body');
		}

		public function testPostWithParamAndData() {
			// arrange
			
			// act
			
			// assert
			$this->markTestIncomplete('not implemented');
		}

		public function testPut() {
			// arrange
			
			// act
			
			// assert
			$this->markTestIncomplete('not implemented');
		}

		public function testPutWithParam() {
			// arrange
			
			// act
			
			// assert
			$this->markTestIncomplete('not implemented');
		}

		public function testPutWithData() {
			// arrange
			
			// act
			
			// assert
			$this->markTestIncomplete('not implemented');
		}

		public function testPutWithParamAndData() {
			// arrange
			
			// act
			
			// assert
			$this->markTestIncomplete('not implemented');
		}

		public function testDelete() {
			// arrange
			
			// act
			
			// assert
			$this->markTestIncomplete('not implemented');
		}

		public function testDeleteWithParam() {
			// arrange
			
			// act
			
			// assert
			$this->markTestIncomplete('not implemented');
		}
	}
}
?>