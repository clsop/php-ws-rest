<?php
namespace web\ws\rest\serve {
	class ServeJSON implements IServe
	{
	    public function serveContent($data): string {
	    	return json_encode($data);
	    }

	    public function getContentType(): string {
	    	return 'application/json';
	    }

	    public function processContent($data) {
	    	return json_decode($data, true);
	    }
	}
}
?>
