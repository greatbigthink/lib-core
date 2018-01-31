<?php
namespace framework\engine;

class twig
{
	protected $app;
	protected $engine;

	public function __construct( $app )
	{
		$this->app = $app;
		$loader = new Twig_Loader_Filesystem( $app->setting('view-path') );

		$twig = new Twig_Environment($loader, array(
			'cache' => '/path/to/compilation_cache',
			'auto_reload' => true,
			'strict_variables' => false,

		));

		$this->engine = new Twig_Environment($loader);
	}

	public function render( $path, $params = [] )
	{
		echo $this->engine->render( $path, $params );
	}
}
