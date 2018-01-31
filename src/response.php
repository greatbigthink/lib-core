<?php
namespace framework;

class response
{
	private $engine = false;
	protected $app = false;

	public function __construct( $app )
	{
		$this->app = $app;
	}

	public function init( $engine )
	{
		if( in_array( $engine, ['twig','php']) )
		{
			$classname = "\\framework\\engine\\$engine";
			$this->engine = new $classname($this->app);
		}
		else
		{
			throw new Exception('App Engine selection is invalid. Please choose from "twig" or "php".');
		}
	}

	public function redirect( $location = false )
	{
		if(!$location)
		{
			return false;
		}
		header("Location: $location");
		exit;
	}

	public function back()
	{
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit;
	}

	public function log( $output, $name = '' )
	{
		echo '<table class="framework-output-log">';
		echo '<thead><tr><th>Timestamp</th>';
		if( !empty($name) )
		{
			echo '<th>Name</th>';
		}
		echo '<th>Output</th></tr></thead>';

		echo '<tbody><tr><td>'. date('Y-m-d H:i:s') .'</td>';
		if( !empty($name) )
		{
			echo '<td>'.$name.'</td>';
		}
		echo '<td><pre>', print_r($output, $as_string = true), '</pre></td></tr></tbody>',
			print_r($output, $as_string = true),
		'</table>';
	}

	public function debug( $output )
	{
		echo '<pre>',
			print_r($output, $as_string = true),
		'</pre>';
	}

	public function dump( $output )
	{
		echo '<pre>',
			var_dump($output),
		'</pre>';
	}

	public function send_code( $code )
	{
		http_response_code($code);
		return $this;
	}

	public function send( $array )
	{
		header('content-type: application/json');
		echo \json_encode( $array );
		exit;
	}

	public function render( $path, $params = [] )
	{
		echo $this->engine->render( $path, $params );
	}

}
