<?php
namespace framework;
use framework\request as request;
use framework\transformer as transformer;
use \Phroute\Phroute\RouteCollector as route_collector;
use \Phroute\Phroute\Dispatcher as dispatcher;

class app
{
	private $_setting = [];
	private $_params = [];
	private $_engine = false;

	protected $routes = [];
	public $router = false;
	public $req = false;
	public $res = false;

	public function __construct()
	{
		$this->req = new request( $this );
		$this->res = new response( $this );
		$this->router = new route_collector();
	}

	# ================================================

	public function engine( $engine )
	{
		$this->res->init( $engine );
	}

	# ================================================

	public function setting( $key, $value = false )
	{
		if( !$value )
		{
			return $this->_setting[$key];
		}
		else
		{
			$this->_setting[$key] = $value;
			return $value;
		}
	}

	# ================================================

	public function use( $path, $prefix = '' )
	{
		$app = $this;
		$req = $this->req;
		$res = $this->res;

		$path = ROOT . "/$path";

		if( !preg_match( "/.php$/", $path ) )
		{
			$path = $path . '.php';
		}

		$this->router->group(['prefix' => $prefix], function($route) use ($app, $path, $res, $req, $prefix){
			require $path;
		});
	}

	# ================================================

	public function param( $param_name, $callback )
	{
		if( is_callable($callback) )
		{
			$this->_params[$param_name] = $callback( new request() );
		}
		else
		{
			$this->_params[$param_name] = $callback;
		}
	}

	# ================================================

	public function route()
	{
		try
		{
			$dispatcher = new dispatcher( $this->router->getData() );
			$results = $dispatcher->dispatch( $this->req->method(), parse_url($this->req->base_url(), PHP_URL_PATH) );
		}
		catch( \Exception $e )
		{
			switch( get_class($e) )
			{
				case 'Phroute\Phroute\Exception\HttpRouteNotFoundException':
					http_response_code(404);
					break;
				case 'Phroute\Phroute\Exception\HttpMethodNotAllowedException':
					http_response_code(403);
					break;
				default:
					http_response_code(400);
					break;
			}
		}
	}

}
