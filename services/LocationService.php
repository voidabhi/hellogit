<?php
  
  class LocationService
  {
	  public static function getLocationName($lat,$lng)
	  {
		  $returnValue = NULL;
		  $ch = curl_init();
		  $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&sensor=false";
		  curl_setopt($ch, CURLOPT_URL, $url);
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		  $result = curl_exec($ch);
		  $json = json_decode($result, TRUE);
		  if(isset($json['results'][0]['formatted_address']))
			return $json['results'][0]['formatted_address']."";
		  else
			return "Unknown Location";		
	  }
  
  }

?>