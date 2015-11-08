<?php
namespace ws\rest\serve;

require_once("serve.php.inc");

class ServeFormData implements IServe
{
    public function serveContent($data)
    {
    	return $data;
    }

    public function getContentType() {
    	return 'application/x-www-form-urlencoded';
    }

    public function processContent($data) {
    	return $data;
    }
}
?>
