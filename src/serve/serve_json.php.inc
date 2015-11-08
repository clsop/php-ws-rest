<?php
namespace ws\rest\serve;

require_once("serve.php.inc");

class ServeJSON implements IServe
{
    public function serveContent($data)
    {
    	return json_encode($data);
    }

    public function getContentType() {
    	return 'application/json';
    }

    public function processContent($data) {
    	return json_decode($data, true);
    }
}
?>
