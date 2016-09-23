<?php 

include 'core.php';

$app = new \Slim\App();

// Main
$app->get('/', function ($request, $response, $args) {
    global $twig;
    global $base;    

    return $twig->render('index.html', array( 
      'base' => $base,      
      'hoaxes' => count(ORM::for_table('hoax', 'remote')->find_many())
    ));
});

// Main
$app->get('/about/', function ($request, $response, $args) {
    global $twig;
    global $base;    

    return $twig->render('about.html', array( 
      'base' => $base      
    ));
});

$app->get('/u/{url}/', function ($request, $response, $args) {
    global $twig;

    $url = $request->getAttribute('url');
    var_dump($url);
});

$app->post('/u/{url}/', function ($request, $response, $args) {
    global $twig;

    $url = $request->getAttribute('url');
    var_dump($url);
});

$app->get('/edit/i/{id}/', function ($request, $response, $args) {
    global $twig;
    global $base;

    $hoax = ORM::for_table('hoax', 'remote')->find_one($request->getAttribute('id'));
    $id = $hoax->id;
    $url = $hoax->url;    
    $evidence = $hoax->evidence;
    
    return  $twig->render('edit.html', array( 
      'base' => $base,
      'url' => $url,
      'evidence' => $evidence,
      'alert' => $alert,
      'id' => $id
    ));
});

function update($request, $response, $args) {
    global $twig;
    global $base;

    $url = $request->getParsedBody()['url'];
    $evidence = $request->getParsedBody()['evidence'];

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
    
    return  $twig->render('edit.html', array( 
      'base' => $base,
      'url' => $url,
      'evidence' => $evidence,
      'alert' => $alert,
      'id' => $id
    ));
}
$app->post('/edit/i/{id}/', update);
$app->post('/edit/u/{url}/', update);

$app->get('/edit/u/{url}/', function ($request, $response, $args) {
    global $twig;
    global $base;

    $url = base64_decode($request->getAttribute('url'));

    $hoax = ORM::for_table('hoax', 'remote')->where('url', $url)->find_one();

    $id = -1;
    $evidence = "";
    if ($hoax) {
      $id = $hoax->id;
      $url = $hoax->url;  
      $evidence = $hoax->evidence;
    }
    
    return  $twig->render('edit.html', array( 
      'base' => $base,
      'url' => $url,
      'evidence' => $evidence,
      'alert' => $alert,
      'id' => $id
    ));
});

$app->get('/api/u/{url}/{type}', function ($request, $response, $args) {
    global $twig;

    $url = \Hocus\Normalizer::normalize_url(base64_decode($request->getAttribute('url')));
    $hoax = Hoax::fetch_hoax($url);
    $is_hoax = $hoax !== null;

    $type = $request->getAttribute('type');
    switch ($type) {
    case 'js':
      return $twig->render('bookmarklet.js', array(
          'url' => $url,          
          'is_hoax' => $is_hoax ? 'true':'false'
        ));
      break;
    case 'sidebar':      
      return $twig->render('sidebar.html', array(
          'url' => $url,
          'url_base64' => base64_encode($url),
          'evidence' => $hoax ? $hoax->evidence : ''
        ));     

      break;
    case 'json':
      return json_encode($hoax);
    default:
      # code...
      break;
  } 
});

$app->run();
/*
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
*/
?>

