<?php

class User extends Illuminate\Database\Eloquent\Model
{
    protected $table = 'user';
	
	protected $primaryKey = "phone";

	public $incrementing = false;

	protected $fillable = array('phone','email','image_url','birthday');

	const REGX_EMAIL="/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
	const REGX_PHONE="/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/";
	const REGX_URL="/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%'\,\{\}\\|\\\^\[\]`]+)?$/";
	const REGX_DATE="/^(19|20)\d\d[\-](0[1-9]|1[012])[\-](0[1-9]|[12][0-9]|3[01])$/";

	// Validating the values while posting

	public function setPhoneAttribute($value)
	{
		if(preg_match(self::REGX_PHONE,$value))
			$this->attributes['phone']=$value;
		else
		throw new Exception("Invalid Phone Number Posted");
	}

	public function setEmailAttribute($value)
	{
		if(preg_match(self::REGX_EMAIL,$value))
			$this->attributes['email']=$value;
		else
			throw new Exception("Invalid Email Posted");
	}

	public function setImageUrlAttribute($value)
	{
		if(preg_match(self::REGX_URL,$value))
			$this->attributes['image_url']=$value;
		else
			throw new Exception("Invalid URL Posted");
	}


	public function setDateAttribute($value)
	{
		if(preg_match(self::REGX_URL,$value))
			$this->attributes['birthday']=$value;
		else
			throw new Exception("Invalid Date Posted");
	}
	
	public function setTypeAttribute($value)
	{
		if($value==="photo"||$value==="location")
			$this->attributes['birthday']=$value;
		else
			throw new Exception("Invalid type Posted");
	}

}

?>