<?php 

include 'core.php';

$id = -1;
$url = '';
$evidence = '';
$alert = '';

if (isset($_POST['url']) && isset($_POST['evidence']))
{
  $url = base64_decode($_POST['url']);
  $evidence = $_POST['evidence'];

  $hoax = ORM::for_table('hoax', 'remote')->where('url', $url);
  if ($hoax->count() == 0)
  {
    $hoax = ORM::for_table('hoax', 'remote')->create();

    $hoax->url = $url;
    $hoax->evidence = $evidence;

    $hoax->save();

  } else {
    $hoax = $hoax->find_one();
    
    // saving new information
    $id = $hoax->id;
    $hoax->evidence = $evidence;
    $hoax->save();

    $alert = "<div class=\"alert alert-warning\">Url already exists. Updating instead.</div>";
  }
}

$normalizer = new \URL\Normalizer();
if (isset($_GET['url'])) {
  $url = base64_decode($_GET['url']);
  
  $normalizer->setUrl($url);
  $url = $normalizer->normalize();

  $hoax = ORM::for_table('hoax', 'remote')->where('url', $url)->find_one();
  if ($hoax) {
    $id = $hoax->id;
    $url = $hoax->url;  
    $evidence = $hoax->evidence;
  }  
} 
else if (isset($_GET['id']))
{  
  $hoax = ORM::for_table('hoax', 'remote')->find_one($_GET['id']);
  $id = $hoax->id;
  $url = $hoax->url;  
  $normalizer->setUrl($url);
  $url = $normalizer->normalize();
  $evidence = $hoax->evidence;
}

echo $twig->render('edit.html', array( 
  'base' => $base,
  'url' => $url,
  'evidence' => $evidence,
  'alert' => $alert,
  'id' => $id
  )
);

?>