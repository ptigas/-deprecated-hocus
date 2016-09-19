<?php 

include 'core.php';

$id = -1;
$url = '';
$evidence = '';
$alert = '';

$recaptcha = new \ReCaptcha\ReCaptcha("6LfCIQcUAAAAANNQY46_GZ25ZU2rGxKL-utCmZXT");

if (isset($_POST['url']) && isset($_POST['evidence']))
{
  $url = $_POST['url'];
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

echo $twig->render('index.html', array( 
  'base' => $base,
  'url' => $url,
  'hoaxes' => 102
  ));

?>

