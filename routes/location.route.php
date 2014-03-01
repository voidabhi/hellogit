<?php


//Creating the location pin

$app->post("/location",function()use($app){
		
	$res = $app->response();
    $res['Content-Type'] = 'application/json';
	$params =$app->request->params();

	try
	{
		if(isset($params['lat'])&&isset($params['lng']))
		{
			$uid = uniqid("uid");
			$url = __ROOT__.$uid; //Fetching url shortner (URL Service)
			if(isset($params['title']))
			$title =$params['title'];
			else
			$title = "";
	
			
			$pin = Pin::create(array(
				"id" => $uid,
				"url" => $url,
				"title" => $title,
				"type" => "location"
			));
			
			$lat = $params['lat'];
			$lng = $params['lng'];
			if(isset($params['venue']))
			$venue = $params['venue'];
			else
			$venue = LocationService::getLocationName($lat,$lng);
			
			$location = Location::create(array(
				"pin_id" => $uid ,
				"lat" => (float) $lat,
				"lng" => (float) $lng,
				"venue" =>(string) $venue
			));
			
			if(isset($location))
				$res->body('{"status":{"code":"200","message":"Location is posted"},"pin_id":"'.$uid.'"}');
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
