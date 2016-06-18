<?php
namespace web\ws\rest {
    /**
     * Base class for implementing a REST resource.
     *
     * php: debug with track_errors = On
     */
    abstract class REST {
        private static $statusCodes = [
    		200 => 'Ok',
    		204 => 'No Content',
    		301 => 'Permanent Moved',
    		302 => 'Found',
    		304 => 'Not Modified',
    		400 => 'Bad Request',
    		401 => 'Unauthorized',
    		403 => 'Forbidden',
    		404 => 'Not Found',
    		405 => 'Not Allowed',
    		406 => 'Not Accepted',
    		408 => 'Request Timeout',
    		409 => 'Conflict',
    		500 => 'Internal Error',
    		501 => 'Not Implemented',
    		502 => 'Bad Gateway',
    		503 => 'Service Unavailable'
        ];

        const DEFAULT_HTTP_VERSION = 1.1;
        const DEFAULT_STATUS_CODE = 500;

        const GET     = 'get';
        const POST    = 'post';
        const PUT     = 'put';
        const DELETE  = 'delete';
        // const OPTIONS = 'options';
        // const HEAD    = 'head';

        private $httpVersion;
        private $contentServer;
        private $resolver;

        /**
         * Initializes the library
         * @param string $httpVersion tells which version of http to transfer with.
         */
        public function __construct(float $httpVersion = REST::DEFAULT_HTTP_VERSION) {
            $this->contentServer = NULL;
            
            // init resolvers
            $contentResolverFactory = resolver\ContentResolverFactory::instance();
            $this->resolver = $contentResolverFactory->createResolvers();

        	// set error handling
            set_error_handler([$this, 'errorHandler']); 
            set_exception_handler([$this, 'exceptionHandler']);

    		$this->httpVersion = $httpVersion;
        }

        public function processRequest() {
            $method = strtolower($_SERVER['REQUEST_METHOD']);
            $accepts = $this->parseAccepted();
            $contentType = $_SERVER['CONTENT_TYPE'];
            $data = NULL;
            $param = NULL;

            if (array_key_exists('param', $_REQUEST)) {
                $param = $_REQUEST['param'];
            }
            
            foreach ($accepts as $accept) {
                $this->contentServer = $this->resolver->resolveType($accept);

                if ($this->contentServer !== NULL) {
                    break;
                }
            }

            if ($this->contentServer === NULL) {
                throw new exception\EndPointException(exception\ExceptionMessage::UNACCEPTED_CONTENT, 406);
            }
            
            // look for data
            if ($method !== REST::GET && $method !== REST::DELETE) {
                $data = file_get_contents("php://input");
                $data = $this->contentServer->processContent($data);
            }

            if (!is_callable([$this, $method])) {
                throw new exception\EndPointException(exception\ExceptionMessage::UNSUPPORTED_METHOD, 405);
            }
            
            if (isset($param) && isset($data)) {
                call_user_func([$this, $method], $param, $data);
            } else if (isset($param)) {
                call_user_func([$this, $method], $param);
            } else if (isset($data)) {
                call_user_func([$this, $method], NULL, $data);
            } else {
                call_user_func([$this, $method]);
            }
        }

        private function setHeaders(int $statusCode = 200) {
            header("HTTP/$this->httpVersion $statusCode " . REST::$statusCodes[$statusCode]);
            header('Content-Type:' . $this->contentServer->getContentType());
        }

        private function parseAccepted(): array {
            // TODO: parse preffered - text/html; q=0.8, text/plain; q=0.6
            return explode(',', $_SERVER['HTTP_ACCEPT']);
        }

        /**
         * Internal function that handles exceptions and send client to possible error page, or returns internal server error
         * 
         * @param $exception exception thrown that wasn't catched
         * @return void
         */
        protected function exceptionHandler($exception) {
            if (!call_user_func([$this, 'onException'], $exception)) {
                $code = $exception->getCode();

                if (get_cfg_var('track_errors') === 'On') {
                    $this->serveResponse(array_key_exists($code, REST::$statusCodes) ? $code : 500, [ 'message' => $exception->getMessage(), 'code' => $exception->getCode(), 'file' => $exception->getFile(), 'line' => $exception->getLine()]);
                } else {
                    $this->serveResponse(array_key_exists($code, REST::$statusCodes) ? $code : 500);
                }
            }
        }

        /**
         * Internal function that handles php errors and send client to possible error page, or returns internal server error
         * 
         * @param $error error that occured
         * @return void
         */
        protected function errorHandler($errno, $errstr, $errfile, $errline, $errcontext) {
            if(!call_user_func_array([$this, 'onError'], [$errno, $errstr, $errfile, $errline])) {
                if (get_cfg_var('track_errors') === 'On') {
                    $this->serveResponse(500, [ 'errno' => $errno, 'errstr' => $errstr, 'errfile' => $errfile,
                        'errline' => $errline, 'errcontext' => $errcontext]);
                } else {
                    $this->serveResponse(500);
                }
            }
        }

        /**
         * Serve response back to client from a request.
         * 
         * @param  int $statusCode the http status code to serve.
         * @param  mixed $data array or object of data to return in body.
         * @return void
         */
        protected function serveResponse(int $statusCode, $data = NULL) {
            if (!array_key_exists($statusCode, REST::$statusCodes))
                throw new exception\InternalServerException(exception\ExceptionMessage::UNKNOWN_STATUS);

        	if (is_array($data)) {
                foreach ($data as $key => $value) {
                    if (is_numeric($key) || preg_match('/^[0-9]+/', $key) === 1) {
                        throw new exception\InternalServerException(exception\ExceptionMessage::INVALID_ARRAY_STRUCTURE);
                    }
                }
            }

        	if($data !== NULL) {
                $this->setHeaders($statusCode);

        		echo($this->contentServer->serveContent($data));
        	} else {
                $this->setHeaders(204);
            }
        }
    }
}
?>