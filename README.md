# phpish/curl

A convenience wrapper around PHP's cURL library


## Requirements

* PHP 5+ with [cURL support](http://php.net/manual/en/book.curl.php).


## Download

### Via [Composer](http://getcomposer.org/) (Preferred)

Create a `composer.json` file if you don't already have one in your projects root directory and require phpish/curl:

```
{
	"require": {
		"phpish/curl": "dev-master"
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

This will download phpish/curl into the `vendor/phpish/curl` directory.

To learn more about Composer visit http://getcomposer.org/


### Via an archive
Download the [latest version of phpish/curl](https://github.com/phpish/curl/archives/master):

```shell
$ curl -L http://github.com/phpish/curl/tarball/master | tar xvz
$ mv phpish-curl-* curl
```

## Use


### Description

string __http_client__( string _$method_ , string _$url_ [, mixed _$query_ [, mixed _$payload_ [, array _$request_headers_ [, array _&$response_headers_ [, array _$curl_opts_ ]]]]] )


### Examples

```php
<?php

	require 'path/to/curl/curl.php';
	use phpish\curl;


	// Basic GET request
	$response_body = curl\http_client('GET', 'https://api.github.com/gists/public');


	// GET request with query string parameters
	$response_body = curl\http_client('GET', 'https://api.github.com/gists/public', array('page'=>1, 'per_page'=>2));


	// Basic POST request
	// Parameters you want to skip can be passed as NULL. For example, here the query parameter is passed as NULL.
	$body = curl\http_client('POST', 'http://duckduckgo.com/', NULL, array('q'=>'42', 'format'=>'json'));


	// POST request with a custom request header (Content-Type) and an overriden cURL opt (CURLOPT_USERAGENT)
	// Also passing in a variable ($response_headers) to get back the response headers
	$response_headers = array();
	$response_body = curl\http_client
	(
		'POST',
		'https://api.github.com/gists',
		NULL,
		stripslashes(json_encode(array('description'=>'test gist', 'public'=>true, 'files'=>array('42.txt'=>array('content'=>'The Answer to the Ultimate Question of Life, the Universe, and Everything'))))),
		array('Content-Type: application/json; charset=utf-8'),
		$response_headers,	// This variable is filled with the response headers
		array(CURLOPT_USERAGENT=>'MY_APP_NAME')
	);


	// If you find yourself passing the same $curl_opts all over the place, do this instead:
	function client_with_custom_curl_opts($custom_curl_opts)
	{
		return function ($method, $url, $query='', $payload='', $request_headers=array(), &$response_headers=array(), $curl_opts_override=array()) use ($custom_curl_opts)
		{
			$curl_opts = $curl_opts_override + $custom_curl_opts;
			return curl\http_client($method, $url, $query, $payload, $request_headers, $response_headers, $curl_opts);
		};
	}

	$http_client = client_with_custom_curl_opts(array(CURLOPT_USERAGENT=>'MY_APP_NAME'));
	$response_body = $http_client('GET', 'https://api.github.com/gists/public');

?>
```