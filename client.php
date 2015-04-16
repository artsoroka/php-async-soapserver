<?php 

ini_set("soap.wsdl_cache_enabled","0");

$log = function($message = null){
	$time = Date('Y-m-d H:i:s');
	file_put_contents('log.txt', $time . ' ' . $message . "\n" , FILE_APPEND);
}; 

$options = array(
	'location' => 'http://localhost/server.php',
	'uri' => 'http://localhost/'
);
 
$api = new SoapClient(NULL, $options);

$log('CLIENT makes a call'); 

echo $api->hello('hello');

$log('CLIENT recieved a response from server'); 