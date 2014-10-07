<?php

// Main hoax class
class Hoax
{
	var $id;
	var $evidence;
	var $url;

	static function fetch_hoax( $url )
	{		
		$hoax = ORM::for_table('hoax', 'remote')->where('url', $url);		
		if ($hoax->count() > 0)
		{
			$hoax = $hoax->find_one();
			$res = new Hoax();
			$res->evidence  = $hoax->evidence;
			$res->url = $hoax->url;
			$res->id = $hoax->id;
			return $res;
		} 
		else
		{
			return null;
		}		
	}
}

?>