<?php

  require_once 'Faultier/FileUpload/Autoloader.php';
  Faultier\FileUpload\Autoloader::register();	
  
	
  use Faultier\FileUpload\FileUpload;
  use Faultier\FileUpload\UploadError;

 class FileUploadService
  {
	  protected static $fileUploader;
	  public static $dir;
	  
	  public static function init($dir)
	  {
		  self::$dir=$dir;	
			
		  // Uploading the file 
		  self::$fileUploader = new FileUpload(self::$dir);
		  
		  
		  self::$fileUploader->error(function(UploadError $error) {
			# omg!
			print_r($error);
		  });		  
	}
	 
	  
	  public static function upload($_FILES,$html_name)
	  {
		  
		  
		  self::$fileUploader->save(function($file) {

			$filename = $file->getOriginalName();
			$array =explode(".", $filename);
			$ext = end($array);
			
			$file->setName(uniqid("bid").".".$ext);
			return FileUploadService::$dir;
		  });
	 		  	  
		  if(self::$fileUploader->hasFiles())
		  {
			  $file = self::$fileUploader->getFile($html_name);
			  //$path = str_replace('\\', '/', $file->getFilePath());
			  $name = $file->getName();
			  return $name; // Getting the final url of the image
		  }
		  
		  return NULL;
	  }
  
  }
 
?>