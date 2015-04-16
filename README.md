# php-async-soapserver

Server recieves the request payload and sending response back immediately, avoiding client to wait while request is processed in the background 

```php 
  SuperSoapClient extends SoapClient {}
``` 
Now we can override the handle() function and inject something like this 
```php
public function handle(){
  ob_start(); 
  
  parent::handle(); 
  
  header("Connection: close\r\n");
  ob_end_flush();
  ob_flush();
  flush();
} 
```
