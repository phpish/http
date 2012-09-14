# phpish/http_api

A convenience wrapper around PHP's cURL library for consuming HTTP APIs.


## Requirements

* PHP 5+ with [cURL support](http://php.net/manual/en/book.curl.php).


## Download

### Via [Composer](http://getcomposer.org/) (Preferred)

Create a `composer.json` file if you don't already have one in your projects root directory and require phpish/http_api:

```
{
	"require": {
		"phpish/http_api": "dev-master"
	}
}
```

Install Composer:
```
$ curl -s http://getcomposer.org/installer | php
```

Run the install command:
```
$ php composer.phar install
```

This will download phpish/http_api into the `vendor/phpish/http_api` directory.

To learn more about Composer visit http://getcomposer.org/


## Use


### Description

string _request__( string _$method_uri_ [, mixed _$query_ [, mixed _$payload_ [, array _$request_headers_ [, array _&$response_headers_ [, array _$curl_opts_ ]]]]] )

callback __client__( string _$base_uri_ [, array _$curl_opts_ ] )


### Examples

```php
<?php

	require 'vendor/phpish/http_api/http_api.php';
	use phpish\http_api;


	// Basic GET request
	$response_body = http_api\request('GET https://api.github.com/gists/public');


	// GET request with query string parameters
	$response_body = http_api\request('GET https://api.github.com/gists/public', array('page'=>1, 'per_page'=>2));


	// Basic POST request
	// Parameters you want to skip can be passed as NULL. For example, here the query parameter is passed as NULL.
	$body = http_api\request('POST http://duckduckgo.com/', NULL, array('q'=>'42', 'format'=>'json'));


	// POST request with a custom request header (Content-Type) and an overriden cURL opt (CURLOPT_USERAGENT)
	// Also passing in a variable ($response_headers) to get back the response headers
	$response_headers = array();
	$response_body = http_api\request
	(
		'POST https://api.github.com/gists',
		NULL,
		array('description'=>'test gist', 'public'=>true, 'files'=>array('42.txt'=>array('content'=>'The Answer to the Ultimate Question of Life, the Universe, and Everything'))),
		array(), // If previous parameter was an array, auto encodes to json and sets 'Content-Type' to 'application/json; charset=utf-8'
		$response_headers,	// This variable is filled with the response headers
		array(CURLOPT_USERAGENT=>'MY_APP_NAME')
	);


	// If you find yourself making multiple API calls to the same base URI and/or passing the same $curl_opts all over the place, do this instead:
	$http_api_client = http_api\client('https://api.github.com', array(CURLOPT_USERAGENT=>'MY_APP_NAME'));
	$response_body = $http_api_client('GET /gists/public', array('page'=>1, 'per_page'=>1));

?>
```