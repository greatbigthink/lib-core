<?php
namespace framework\engine;

class php
{
	protected $app;

	public function __construct( $app )
	{
		$this->app = $app;
	}

	public function render( $path, $params )
	{
		ob_start();
		extract($params);
		include $path;
		return ob_get_clean();
	}
}
