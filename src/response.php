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

	public function log( $output, $name = 'Unnamed' )
	{
		return "<table border=\"1\" cellpadding=\"5\" cellspacing=\"0\">
				<thead>
					<tr>
						<th width=\"160\">Timestamp</th>
						<th>Name</th>
						<th>Output</th>
					</tr>
				</thead>
				<tbody>
					{$this->log_output($output, $name)}
				</tbody>
			</table>";
	}

	private function log_output( $output, $name = 'Unnamed' )
	{
		$date = date('Y-m-d H:i:s');
		$date = \str_replace(' ', '&nbsp;', $date);
		$date = \str_replace('-', '&#8209;', $date);
		$return = '';
		if( \is_array($output) )
		{
			foreach( $output as $key => $value )
			{
				$return .= "<tr>
					<td>$date</td>
					<td>$key</td>
					<td>$value</td>
				</tr>";
			}
		}
		else
		{
			$return .= "<tr>
				<td>$date</td>
				<td>$name</td>
				<td>$output</td>
			</tr>";
		}

		return $return;
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

	public function status( $code )
	{
		http_response_code($code);
		return $this;
	}

	public function send_code( $code )
	{
		return $this->status($code);
	}

	public function send( $array )
	{
		header('content-type: application/json');
		echo \json_encode( $array );
		exit;
	}

	public function render( $path, $params = [] )
	{
		$params['app'] = $this->app;
		echo $this->engine->render( $path, $params );
	}

}
