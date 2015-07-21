<?php
require_once 'core.php';

$url = "";
$is_hoax = false;
if (isset($_GET['u']))
{
	$url = Normalizer::normalize_url(stripslashes(nl2br($_GET['u'])));

	$hoax = Hoax::fetch_hoax($url);
	$is_hoax = $hoax !== null;
}

if (isset($_GET['f']) && $_GET['f'] == 'js') {
	echo $twig->render('bookmarklet.js', array(
		'url' => $url,
		'is_hoax' => $is_hoax ? 'true':'false'
		)
	);
} else {
	echo json_encode($hoax);
}
?>