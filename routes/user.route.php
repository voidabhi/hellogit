<?php

// Fetching user details of given phone number

$app->get("/user/:phone",function($phone)use($app){

	$res = $app->response();
	$res['Content-Type'] = 'application/json';

	// Getting the user object if present else blank
	try
	{
		$user = User::where("phone","=",$phone)->get()?User::where("phone","=",$phone)->get():"{}";

		if(isset($user[0]))
			$res->body('{"user":'.$user[0]->toJson().'}');
		else
			$res->body('{"status":{"code":"100",message:"No user of this entry found"}}');
	}
	catch (Exception $e)
	{
		$res->body('{"error":{"code":"'.$e->getCode().'","message":"'.$e->getMessage().'"}}');
	}
});


//Signing up the user


$app->post('/user', function () use ($app) {

	$res = $app->response();
    $res['Content-Type'] = 'application/json';
	$params =$app->request->params();
	$img_url = NULL;

	try
	{
		
		//Check if the image is sent
		
		if(isset($_FILES))
		{
			$img_url = FileUploadService::upload($_FILES,"pic");
		}
		
		if(isset($params['phone']))
		{
			$user = User::where("phone","=",$params['phone'])->get();

			if(count($user)>=1)
			{
				$res->body('{"status":{"code":"100","message":"User already exist with this entry"}}');
			}
			else
			{
				$user = User::create($params)->get();
				// Saving image url if set
				if(isset($img_url))
				{
					$user[0]->image_url = $img_url;
					$user[0]->save();
				}
				$res->body('{"status":{"code":"200","message":"User created"}}');
			}
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


// Updating the details of the user with given phone number

$app->put("/user/:phone",function($phone)use($app){

	// Returning the json status - if the details are updated or not with try/catch

	$res = $app->response();
    $res['Content-Type'] = 'application/json';
    $img_url = NULL;
	
	try
	{
	
		//Check if the image is sent
		
		if(isset($_FILES))
		{
			$img_url = FileUploadService::upload($_FILES,"pic");
		}
		
		$affectedRows = User::where("phone","=",$phone)->update($app->request->params());

		if($affectedRows==0)
			$res->body('{"status":{"code":"100",message:"No user of this entry found"}}');
		else
		{
			// Saving image url if set
			if(isset($img_url))
			{
				$user[0]->image_url = $img_url;
				$user[0]->save();
			}
			$res->body('{"status":{"code":"200",message:"User of this entry is updated"}}');
		}
	}
	catch (Exception $e)
	{
		$res->body('{"error":{"code":"'.$e->getCode().'","message":"'.$e->getMessage().'"}}');
	}

});

// Deleting the details of the user with given phone number

$app->delete("/user/:phone",function($phone)use($app){

	//	Returning the json status - if the details are deleted or not with try/catch

	$res = $app->response();
    $res['Content-Type'] = 'application/json';

	try
	{
		$affectedRows = User::where('phone', '=', $phone)->delete();

		if($affectedRows==0)
			$res->body('{"status":{"code":"100",message:"No user of this entry found"}}');
		else
			$res->body('{"status":{"code":"200",message:"User of this entry is deleted"}}');
	}
	catch (Exception $e)
	{
		$res->body('{"error":{"code":"'.$e->getCode().'","message":"'.$e->getMessage().'"}}');
	}

});
