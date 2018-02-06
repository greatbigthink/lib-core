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
		$this->engine = new \Twig_Environment($loader, array(
			'debug' => true,
			'auto_reload' => true,
			'strict_variables' => false
		));
		$this->engine->addExtension(new \Twig_Extension_Debug());
	}

	public function render( $path, $params = [] )
	{
		try {
			echo $this->engine->render( $path, $params );
		} catch (\Exception $e) {
			print_r($e);
			exit;
		}

	}
}
