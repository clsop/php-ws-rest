<?php
namespace web\ws\rest\serve {
    /**
    * Help to generate/resolve content for a request/response
    * 
    * @author Claus Petersen
    */
    interface IServe
    {
        /**
        * Generate content to serve
        *
        * @param $data the data passed from client.
        * @returns data formatted in the serving instance
        */
        public function serveContent($data);

        /**
         * Gets the content type for this content
         * 
         * @return string mimetype
         */
        public function getContentType();

        /**
         * Process the content delivered from client
         * 
         * @param  mixed $data the request content
         * @return mixed parsed or processed content
         */
        public function processContent($data);
    }
}
?>
