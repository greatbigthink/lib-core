<?php
namespace framework\engine;

class php
{
	public function render( $path, $params )
	{
		ob_start();
		extract($params);
		include $path;
		return ob_get_clean();
	}
}
