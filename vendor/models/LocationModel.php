<?php

class Location extends Illuminate\Database\Eloquent\Model
{

	protected $table = 'location';

	public $incrementing  = false;

	public $timestamps = false;

	public $fillable = array("pin_id","lat","lng","venue");

	const REGX_LATITUDE = "/^(?:90|[0-8][0-9]):[0-5][0-9]:[0-5][0-9]$/";

	const REGX_LONGITUDE = "/^(?:180|1[0-7][0-9]|[0-9][0-9]):[0-5][0-9]:[0-5][0-9]$/";

	public function setLatAttribute($value)
	{
		if(is_float($value))
			$this->attributes['lat']=$value;
		else
			throw new Exception("Invalid Latitude Value Posted");
	}

	public function setLngAttribute($value)
	{
		if(is_float($value))
			$this->attributes['lng']=$value;
		else
			throw new Exception("Invalid Longitude Value Posted");
	}
}