<?php
namespace web\ws\rest\serve {
    class ServeFormData implements IServe
    {
        public function serveContent($data): string
        {
            // TODO: objects and arrays to strings
        	return urlencode('');
        }

        public function getContentType(): string {
        	return 'application/x-www-form-urlencoded';
        }

        public function processContent($data) {
            parse_str($data, $vars);

        	return $vars;
        }
    }
}
?>
