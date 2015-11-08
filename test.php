<?php
require('src/rest.php.inc');

class Test extends ws\rest\REST {
	public function get($param = NULL) {
		$this->serveResponse(200, ['test' => 'yay, it works!', 'witharray' => ['another' => 'weeee!'], 'param' => $param]);
	}

	public function post($data = NULL) {
		$this->serveResponse(200, 'yay, you posted!');
	}

	public function put($param = NULL, $data = NULL) {
		$this->serveResponse(200, 'yay, you put! - ' . $data);
	}

	public function delete($param = NULL) {
		$this->serveResponse(200, 'yay, you deleted! - ' . $param);
	}
}

$test = new Test();
?>