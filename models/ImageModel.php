<?php

class Photo extends Illuminate\Database\Eloquent\Model
{

	protected $table = 'photo';

	public $incrementing  = false;

	public $timestamps = false;

	public $fillable = array("pin_id","url");

	public function setUrlAttribute($value)
	{
		if(preg_match(Pin::REGX_URL,$value))
			$this->attributes['url']=$value;
		else
			throw new Exception("Invalid Image URL Posted");
	}
}