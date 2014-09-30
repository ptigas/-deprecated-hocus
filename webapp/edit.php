<?php 

include 'library/idiorm/idiorm.php';
include 'library/normalizer/normalizer.php';
include 'settings.php';

// A named connection, where 'remote' is an arbitrary key name
ORM::configure('mysql:host=localhost;dbname=' . $mysql_database, null, 'remote');
ORM::configure('username', $mysql_username, 'remote');
ORM::configure('password', $mysql_password, 'remote');

$id = -1;
$url = '';
$evidence = '';
$alert = '';

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

if (isset($_GET['id']))
{
  $hoax = ORM::for_table('hoax', 'remote')->find_one($_GET['id']);
  $id = $hoax->id;
  $url = $hoax->url;
  $normalizer = new \URL\Normalizer();
  $normalizer->setUrl($url);
  $url = $normalizer->normalize();
  $evidence = $hoax->evidence;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Antihoax - A mythbusting platform.</title>
  <meta name="description" content="A mythbusting platform">  
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
  <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="//twitter.github.io/bootstrap/assets/js/html5shiv.js"></script>
  <![endif]-->

  <!-- include jquery and bootstrap and font-awesome -->
  <script src="//code.jquery.com/jquery-1.9.1.min.js"></script>
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">

  <!-- include summernote -->
  <link href="css/summernote.css" rel="stylesheet">
  <script src="js/summernote.min.js"></script>

</head>
<body>
<!-- navbar -->
<div class="navbar navbar-default navbar-fixed-top bs-page-navbar" role="banner">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="./">Antihoax</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse" role="navigation">
      <ul class="nav navbar-nav">        
        <li><a href="about.html">About</a></li>
      </ul>
    </div>
  </div>
</div>
<div style="min-height:100px"></div>
<div class="container">
  <div class="row">
    <div class="col-md-3">
      <div class="bs-page-sidebar" role="complementary" style="display:none">
        <ul class="nav">
          <li><a href="#multiple"><?php echo $id == -1 ? 'Upload' : 'Edit'; ?> hoax</a></li>                    
        </ul>
      </div>
    </div>
    <div class="col-md-9" role="main">
      <section>
        <?php echo $alert; ?>
        <h2><?php echo $id == -1 ? 'Upload' : 'Edit'; ?> hoax</h2>
        <p>Set the url to the article. Then write the evidence to support your case and hit submit.</p>

        <form class="span12" id="postForm" action="" method="POST" enctype="multipart/form-data" onsubmit="return postForm()">
          <div class="form-group">
            <label>Url</label>
            <input type="url" class="form-control" name="url" placeholder="Enter url" value="<?php echo $url;?>"/>
          </div>
          <div class="form-group">
            <label>Evidence</label>
            <textarea id="editor" name="evidence"><?php echo $evidence;?></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" id="cancel" class="btn">Cancel</button>
        </form>
      </section>
      <hr/>
    </div>
  </div>
</div>
<footer class="footer">
  <div class="container">
    <div class="col-md-3">      
    </div>
    <div class="col-md-9" role="main">
      <p><a href="https://github.com/ptigas/antihoax">Antihoax</a> is published under MIT license.</p>
    </div>
  </div>
</footer>

<script>
  $(document).ready(function() {
    $('#editor').summernote();
  });

  var postForm = function() {
    var content = $('textarea[name="content"]').html($('#editor').code());
  }

</script>

</body>
</html>