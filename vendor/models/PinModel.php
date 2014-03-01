<?php
class Pin extends Illuminate\Database\Eloquent\Model
{
	protected $table = 'pin';

	public $incrementing = false;

	public $fillable = array("id","url","title","created_at","updated_at","type");

	const REGX_UID = "/^uid/";
	const REGX_URL = "/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%'\,\{\}\\|\\\^\[\]`]+)?$/";

	//Attribute Function

	public function setIdAttribute($value)
	{
		if(preg_match(self::REGX_UID,$value))
		$this->attributes['id']=$value;
		else
		throw new Exception("Invalid Pin ID Posted");
	}

	public function setUrlAttribute($value)
	{
		if(preg_match(self::REGX_URL,$value))
		$this->attributes['url']=$value;
		else
		throw new Exception("Invalid Pin URL Posted");
	}

}