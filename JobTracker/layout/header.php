<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php if(isset($title)){ echo $title; }?></title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../JobTracker/style/main.css">




<html>
<head>
<style>
  * {
    padding: 0;
    margin: 0; 
     }
  .fit { /* set relative picture size */
    max-width: 100%;
    max-height: 100%;
  }
  .center {
    display: block;
    margin: auto;
  }
</style>



<div style="position: relative; left: 0; top: 0;">
  <img src="http://www.clavensolutions.com/layout/Powered%20by%20CS%20banner.png" style="position: absolute; top: 0; left: 0;"/>
  <img class="center fit" src="http://www.clavensolutions.com/layout/Powered%20by%20CS%20logo.png" style="position: relative; top: 0px;"/>  <!-- style="position: absolute; top: 0px;"/>  -->
</div>

<!--<img class="center fit" src="http://www.clavensolutions.com/layout/Powered%20by%20CS.png" >  left: 70px;   -->

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" language="JavaScript">
  function set_body_height() { // set body height = window height
    $('body').height($(window).height());
  }
  $(document).ready(function() {
    $(window).bind('resize', set_body_height);
    set_body_height();
  });
</script>






</head>
<body>
