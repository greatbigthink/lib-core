<?php
namespace framework;

class request
{
	public $body = [];
	public $params = [];
	public $cookie = [];
	public $files = [];

	public function __construct()
	{
		$this->body = $_POST;
		$this->params = $_GET;
		$this->cookie = $_COOKIE;
		$this->files = $_FILES;
	}

	public function url()
	{
		return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}

	public function base_url()
	{
 		return $_SERVER['REQUEST_URI'];
	}

	public function original_url()
	{
		return $_SERVER['REDIRECT_URL'];
	}

	public function body( $param = '', $not_found_value = false )
	{
		# returns only one $_GET param, if it exists, or the $not_found_value
		if( \in_array($params, $this->body) )
		{
			return $this->body[$param];
		}
		else
		{
			return $not_found_value;
		}
	}

	public function cookies( $param = '', $not_found_value = false )
	{
		# returns only one $_GET param, if it exists, or the $not_found_value
		if( \in_array($params, $this->cookies) )
		{
			return $this->cookies[$param];
		}
		else
		{
			return $not_found_value;
		}
	}

	public function hostname()
	{
		return $_SERVER['SERVER_NAME'];
	}

	#TODO
	public function subdomains(){}

	public function ip()
	{
		return $_SERVER['REMOTE_ADDR'];
	}

	public function ips()
	{
		//for now, just do this.
		return $this->ip();
	}

	public function method()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	public function params()
	{
		# return all $_GET params
		return $this->params;
	}

	public function param( $param = '', $not_found_value = false )
	{
		# returns only one $_GET param, if it exists, or the $not_found_value
		if( \in_array($params, $this->params) )
		{
			return $this->params[$param];
		}
		else
		{
			return $not_found_value;
		}
	}

	public function path()
	{
		return $_SERVER['PATH_INFO'];
	}

	public function protocol()
	{
		return $_SERVER['SERVER_PROTOCOL'];
	}

	public function query()
	{
		return $_SERVER['QUERY_STRING'];
	}

	public function secure()
	{
		return $_SERVER['HTTPS'];
	}

	public function xhr()
	{
		# return true if the request’s X-Requested-With header field is “XMLHttpRequest”
		$val = $this-headers('X-Requested-With');
		return $val == 'XMLHttpRequest';
	}

	public function accepts()
	{
		return $_SERVER['HTTP_ACCEPT'];
	}

	public function accepts_charsets()
	{
		return $_SERVER['HTTP_ACCEPT_CHARSET'];
	}

	public function accepts_encodings()
	{
		return $_SERVER['HTTP_ACCEPT_ENCODING'];
	}

	public function accepts_languages()
	{
		return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	}

	public function headers( $header = false )
	{
		#return the header array or one specific array element
		$header_array = array();
		$headers = headers_list();
		foreach ($headers as $this_header)
		{
			$this_header = explode(":", $this_header);
			$header_array[array_shift($this_header)] = trim(implode(":", $this_header));
		}

		if( !$header )
		{
			return $header_array;
		}
		else
		{
			if( \in_array( $header, $header_array ) )
			{
				return $header_array[$header];
			}
			else
			{
				return false;
			}
		}
	}

	public function is( $content_type = '' )
	{
		#returns t or f if the header content-type matches $content_type
		$content_type_header_value = $this->headers('content-type');
		return $content_type_header_value == $content_type;
	}

}
