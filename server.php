<?php 

function logger($message = null){
	$time = Date('Y-m-d H:i:s');
	file_put_contents('log.txt', $time . ' ' . $message . "\n" , FILE_APPEND);
}

class SoapHandler {

	public function hello($request){
		logger('SERVER Handler is started'); 
		$GLOBALS['soapRequest'] = $request; 
		return 'recieved ' . $request;  
	}
}

class SuperSoapServer extends SoapServer {

	public $debug = true; 
	public $async = true; 

	public function handle($request = null){
		if( $this->debug ){
			$this->_logRequest($request);
		} 
		
		logger('SERVER resives a soap message'); 
		
		if( $this->async ) ob_start();
		
		parent::handle(); 
		
		logger('SERVER finished handling the request');
	    
	    if($this->async) {
	    	header("Connection: close\r\n");
		    ob_end_flush();
	        ob_flush();
	        flush();   
	    }
 		
	}

	public function _logRequest($request = false){
		if( ! $request ) {
			$request = $GLOBALS['HTTP_RAW_POST_DATA']; 
		}

		$time = Date('Y-m-d H:i:s') . ' '; 
		file_put_contents('server_log.txt', $time . $request, FILE_APPEND); 
	}

}

$handler = new SoapHandler(); 

$options = ['uri' => 'https://localhost/pdb/soap']; 

$srv = new SuperSoapServer(NULL, $options);
$srv->setObject($handler); 

          
$srv->handle();

sleep(5); 
logger('SERVER do background task: ' . $GLOBALS['soapRequest']);
