<?php 

include 'core.php';

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
  <link href="css/ladda-themeless.min.css" rel="stylesheet">
  <script src="js/summernote.min.js"></script>
  <script src="js/spin.min.js"></script>
  <script src="js/ladda.min.js"></script>

  <script>
  
  function validate_hoax(){    
    var l = Ladda.create( document.querySelector('#form-submit') );
    l.start();
    $("#results").html("");
    $.get("api.php", 
        { u : $('input[name=url]').val() },
        function(response){
          console.log(response);
          $("#results").show();
          var html = '';
          if (response == null)
          {
            html = "It doesn't look like a hoax";
          }
          else
          {
            html = "<div>" + response.evidence + " <a  class='btn btn-default btn-sm' href='edit.php?id=" + response.id + "'><span class='glyphicon glyphicon-pencil'></span> Edit</a></div>";            
          }
          $("#results").html(html);
        }, "json")
    .always(function() { l.stop(); });      
  }

  </script>

  <style>
  /* Main marketing message and sign up button */
  .jumbotron {
    text-align: center;
    background-color: transparent;
  }
  </style>

</head>
<body>
<!-- navbar -->

<div class="container">    
  <div class="navbar navbar-default navbar-fixed-top bs-page-navbar" role="banner">

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

  <div class="jumbotron">  
      <div class="row">
        <div role="" style="text-align:center; margin-top:100px; padding-bottom:100px">
          <section>
            <h2>Validate a hoax</h2>
            <p>Set the url that points to the article. The rest is our job.</p>

            <form class="form-inline" id="postForm" action="javascript:validate_hoax()" method="POST" enctype="multipart/form-data">
              <div class="form-group">            
                <input type="text" class="form-control" style="width:500px" name="url" placeholder="Enter url" value="<?php echo $url;?>"/> 
                <a href="#" onclick="validate_hoax(); return false;" id="form-submit" class="btn btn-primary ladda-button" data-style="expand-right" data-size="l"><span class="ladda-label">Check</span></a>                                        
              </div>
            </form>
          </section>                  
        </div>        
        <div class="row" id="results" style="display:none; text-align:left; background:#eee; padding:20px"></div>    
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