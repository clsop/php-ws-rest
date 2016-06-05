<?php
namespace web\ws\rest\serve {
    require_once("serve.inc.php");

    class ServeFormData implements IServe
    {
        public function serveContent($data)
        {
            // TODO: to formdata
        	return $data;
        }

        public function getContentType() {
        	return 'application/x-www-form-urlencoded';
        }

        public function processContent($data) {
            // TODO: array as formdata
        	return $data;
        }
    }
}
?>
