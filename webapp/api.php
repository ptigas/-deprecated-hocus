<?php
require_once 'core.php';

$url = "";
$is_hoax = false;
if (isset($_GET['u']))
{
	$url = \Hocus\Normalizer::normalize_url(stripslashes(nl2br($_GET['u'])));

	$hoax = Hoax::fetch_hoax($url);
	$is_hoax = $hoax !== null;
}

if (isset($_GET['f'])){
	switch ($_GET['f']) {
		case 'js':
			echo $twig->render('bookmarklet.js', array(
					'url' => $url,					
					'is_hoax' => $is_hoax ? 'true':'false'
				));
			break;
		case 'sidebar':
			
			echo $twig->render('sidebar.html', array(
					'url' => $url,
					'url_base64' => base64_encode($url),
					'evidence' => $hoax ? $hoax->evidence : ''
				));			

			break;
		default:
			# code...
			break;
	}	
} else {
	echo json_encode($hoax);
}
?>