<?php
namespace framework\engine;

class twig
{
	protected $app;
	protected $engine;

	public function __construct( $app )
	{
		$this->app = $app;
		$loader = new \Twig_Loader_Filesystem( $this->app->setting('view-path') );

		$twig = new \Twig_Environment($loader, array(
			'auto_reload' => true,
			'strict_variables' => false,
			'debug' => true
		));

		$twig->addExtension(new \Twig_Extension_Debug());

		$this->engine = $twig;
	}

	public function render( $path, $params = [] )
	{
		echo $this->engine->render( $path, $params );
	}
}
