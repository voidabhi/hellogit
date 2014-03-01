<?php

use Illuminate\Database\Capsule\Manager as Capsule;

  class DatabaseService
  {
    protected static $capsule;
	 
	public static function init($config)
	{
		try
		{
			self::$capsule = new Capsule;
			self::$capsule->addConnection($config);
			self::$capsule->bootEloquent();
			self::$capsule->setAsGlobal();
			
			return self::$capsule->connection();
		}
		catch(Exception $e)
		{
			return NULL;
		}
	}
	
  }
