<?php
namespace framework;

class transformer
{
	protected static $library = [];

	public static function __callStatic( $name, $params )
	{
		if( array_key_exists( $name, self::$library) )
		{
			return call_user_func_array( [ self::$library[$name], $name ], $params );
		}
		else
		{
			return false;
		}
	}

	public static function _load( $app )
	{
		$dir = new directory();
		$files = $dir->rscan( $app->setting('transformer-path') );

		foreach( $files as $file )
		{
			if( $file['type'] == 'file' && $file['ext'] == 'php' )
			{
				$filename = $file['filename'];
				$classname = "\\framework\\transformer\\$filename";
				include_once $file['full_path'];
				self::$library[$filename] = new $classname();
			}
		}

	}
}
