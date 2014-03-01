<?php

// Fetching the pin by its id

$app->get("/pin/:id",function($id)use($app){

	$res = $app->response();
	$res['Content-Type'] = 'application/json';	
	
	try
	{
		$pin = Pin::where("id","=",$id)->get();
		$photo = Photo::where("pin_id","=",$id)->get();
		$location = Location::where("pin_id","=",$id)->get();
		
		if(isset($pin))
		{
			if(count($photo)>=1)
				$res->body('{"pin":{"details":'.$pin[0]->toJson().',"photo":'.$photo[0]->toJson().'}}');
			else if(count($location)>=1)
				$res->body('{"pin":{"details":'.$pin[0]->toJson().',"location":'.$location[0]->toJson().'}}');
		}
		else
			$res->body('{"status":{"code":"100",message:"No pin of this id found"}}');
	}
	catch (Exception $e)
	{
		$res->body('{"error":{"code":"'.$e->getCode().'","message":"'.$e->getMessage().'"}}');
	}	
});

// Deleting the pin

$app->delete("/pin/:id",function($id)use($app)
{

	$res = $app->response();
    $res['Content-Type'] = 'application/json';

	try
	{
		// Deleting pin of suitable id
		
		$row = Pin::where('id', '=', $id)->get();
		
		// Displaying appropriate message
		
		if(count($row)==0)
			$res->body('{"status":{"code":"100",message:"Pin not found"}}');
		else
		{
			if($row[0]->type==="photo")
				Photo::where("pin_id","=",$id)->delete();
			else if($row[0]->type==="location")
				Location::where("pin_id","=",$id)->delete();
				
			Pin::where('id', '=', $id)->delete();
			$res->body('{"status":{"code":"200",message:"Pin is deleted"}}');
		}
	}
	catch (Exception $e)
	{
		$res->body('{"error":{"code":"'.$e->getCode().'","message":"'.$e->getMessage().'"}}');
	}
});

