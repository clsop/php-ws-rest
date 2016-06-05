<?php
namespace web\ws\rest {
    require_once('exception/internal_server_exception.inc.php');
    require_once('exception/endpoint_exception.inc.php');
    require_once('resolver/content_resolver_factory.inc.php');

    /**
     * Base class for implementing a REST resource.
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

        const DEFAULT_HTTP_VERSION = '1.1';
        const DEFAULT_STATUS_CODE = 500;

        private $httpVersion;
        private $contentServer;
        private $resolver;

        /**
         * Initializes the library
         * @param string $httpVersion tells which version of http to transfer with.
         */
        public function __construct($httpVersion = REST::DEFAULT_HTTP_VERSION) {
            $this->contentServer = NULL;
            
            // init resolvers
            $contentResolverFactory = resolver\ContentResolverFactory::instance();
            $this->resolver = $contentResolverFactory->createResolvers();

        	// set error handling
            set_error_handler([$this, 'errorHandler']); 
            set_exception_handler([$this, 'exceptionHandler']);

            // NOTICE: PHP 7.0 has type hint float
    		if (is_float($httpVersion)) {
    			$this->httpVersion = $httpVersion;
    		} else {
    			$this->httpVersion = REST::DEFAULT_HTTP_VERSION;
    		}

    		$this->processRequest();
        }

        private function processRequest() {
            $method = strtolower($_SERVER['REQUEST_METHOD']);
            $accepts = explode(',', $_SERVER['HTTP_ACCEPT']);
            $contentType = $_SERVER['CONTENT_TYPE'];
            $data = NULL;
            $param = NULL;

            if ($method !== 'post' && in_array('param', $_REQUEST)) {
                $param = $_REQUEST['param'];
            }
            
            foreach ($accepts as $accept) {
                $this->contentServer = $this->resolver->resolveType($accept);

                if ($this->contentServer !== NULL) {
                    break;
                }
            }
            
            // look for data
            if ($method !== 'get') {
                $data = file_get_contents("php://input");
                $server = $this->resolver->resolveType($contentType);

                if ($server !== NULL) {
                    $data = $server->processContent($data);
                }
            }

            if (!is_callable([$this, $method])) {
                throw new exception\EndPointException('Method not supported', 405);
            }
            
            if (isset($param) && isset($data)) {
                call_user_func([$this, $method], $param, $data);
            } else if (isset($param)) {
                call_user_func([$this, $method], $param);
            } else if (isset($data)) {
                call_user_func([$this, $method], $data);
            } else {
                call_user_func([$this, $method]);
            }
        }

        private function setHeaders($statusCode = NULL) {
            header("HTTP/$this->httpVersion $statusCode " . REST::$statusCodes[$statusCode]);

            if ($this->contentServer !== NULL) {
                header('Content-Type:' . $this->contentServer->getContentType());
            }
        }

        /**
         * Internal function that handles exceptions and send client to possible error page, or returns internal server error
         * 
         * @param $exception exception thrown that wasn't catched
         * @return void
         */
        public function exceptionHandler($exception) {
            $code = $exception->getCode();
            
            if (\lanflix\LANFlixSettings::DEBUG) {
                $this->serveResponse(array_key_exists($code, REST::$statusCodes) ? $code : 500, [ 'message' => $exception->getMessage(), 'code' => $exception->getCode(), 'file' => $exception->getFile(), 'line' => $exception->getLine()]);
            } else {
                $this->serveResponse(array_key_exists($code, REST::$statusCodes) ? $code : 500);
                // TODO: log error
            }
        }

        /**
         * Internal function that handles php errors and send client to possible error page, or returns internal server error
         * 
         * @param $error error that occured
         * @return void
         */
        public function errorHandler($errno, $errstr, $errfile, $errline, $errcontext) {
            if (\lanflix\LANFlixSettings::DEBUG) {
                $this->serveResponse(500, [ 'errno' => $errno, 'errstr' => $errstr, 'errfile' => $errfile,
                    'errline' => $errline, 'errcontext' => $errcontext]);
            } else {
                $this->serveResponse(500);
                // TODO: log error
            }
        }

        /**
         * Serve response back to client from a request.
         * 
         * @param  int $statusCode the http status code to serve.
         * @param  mixed $data array or object of data to return in body.
         * @return void
         */
        protected function serveResponse($statusCode, $data = NULL) {
        	if (!is_int($statusCode)) {
        		throw new exception\InternalServerException();
            } else if (is_array($data)) {
                foreach ($data as $key => $value) {
                    if (is_numeric($key) || preg_match('/^[0-9]+/', $key) === 1) {
                        throw new exception\InternalServerException('response data must be $key => $value pairs with keys non-numeric (also starting with numerics isn\'t allowed)');
                    }
                }
            }

        	$this->setHeaders($statusCode);
        	
        	if($data !== NULL) {
        		if ($this->contentServer === NULL) {
                    throw new exception\EndPointException("Cannot serve content!", 204);
                }

        		echo($this->contentServer->serveContent($data));
        	}
        }
    }
}
?>
