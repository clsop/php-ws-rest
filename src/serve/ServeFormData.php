<?php
namespace web\ws\rest\serve {
    class ServeFormData implements IServe
    {
        public function serveContent($data): string
        {
            throw new \ErrorException('not implemented');
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
