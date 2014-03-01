<?php


//Creating the image pin

$app->post("/photo",function()use($app){	


	$res = $app->response();
    $res['Content-Type'] = 'application/json';
	$params =$app->request->params();

	try
	{
		if(isset($_FILES))
		{
			//Fetching Image URL
			$img_url = FileUploadService::upload($_FILES,"photo");
		
			// Initializing new pin
			
			$uid = uniqid("uid");
			$url = __ROOT__.$uid; //Fetching url shortner
			if(isset($params['title']))
			$title =$params['title'];
			else
			$title = "";
			
			$pin = Pin::create(array(
				"id" => $uid,
				"url" => $url,
				"title" => $title,
				"type" => "photo"
			));
			
			// Augmenting Photo data
			
			$photo = Photo::create(array(
				"pin_id" => $uid ,
				"url" => $img_url
			));
			
			// Replying with appropriate message
			
			if(isset($photo))
				$res->body('{"status":{"code":"200","message":"Photo pin created"},"pin_id":"'.$uid.'"}');
			else
				$res->body('{"status":{"code":"100","message":"Some error occured while posting photo"}}');
			
		}
		else
		{
			$res->body('{"status":{"code":"100","message":"Check the posted entries"}}');
		}
	}
	catch(Exception $e)
	{
		$res->body('{"error":{"code":"'.$e->getCode().'","message":"'.$e->getMessage().'"}}');
	}	
});
