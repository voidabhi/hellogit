<?php

class UserController extends BaseController {

	public function getIndex()
	{
		$users=User::all();

		return View::make("users")->with("users",$users);
	}

}

?>