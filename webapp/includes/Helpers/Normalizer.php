<?php

class Normalizer
{
	static function normalize_url($url)
	{
	  $normalizer = new \URL\Normalizer();
	  $normalizer->setUrl($url);
	  return $normalizer->normalize();
	}
}

?>