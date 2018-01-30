<?php
namespace framework;

class autoload
{
	public static function init( $app )
	{
		spl_autoload_register( function( $class ){
			$classname = str_replace('_', '/', $class);
			@include $app.setting('model-path') . "/$classname.php";
		}, $throw_exceptions = false);
	}
}
