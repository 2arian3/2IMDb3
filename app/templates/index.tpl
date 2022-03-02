<!DOCTYPE html>
<html>
<head>
  <title>2IMDB3</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
  <style>
    body,h1,h2,h3,h4,h5,h6 {font-family: "Karma", sans-serif};
    .w3-bar-block .w3-bar-item {padding:20px}
  </style>
</head>
<body class="w3-black">

<nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left w3-white" style="display:none;z-index:2;width:40%;min-width:300px" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()"
     class="w3-bar-item w3-button">Close Menu</a>
  <a href="#movies" onclick="w3_close()" class="w3-bar-item w3-button">Movies</a>
  <a href="#about" onclick="w3_close()" class="w3-bar-item w3-button">About</a>
</nav>

<div>
  <div class="w3-xlarge" style="max-width:1200px;margin:auto">
    <div class="w3-button w3-padding-16 w3-left" onclick="w3_open()">☰</div>
    <div class="w3-center w3-padding-16">IMDB</div>
  </div>
</div>

<div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">

  <div class="w3-row-padding w3-padding-16 w3-center" id="movies">
    <?php foreach($movies as $movie){ ?>
    <a class="w3-quarter" href="movie.php?id=<?php echo $movie['id']; ?>">
      <img src="<?php echo $movie['poster'] ?>" alt="..." style="width:100%;">
      <h3><?php echo $movie['name'] ?></h3>
      <p>Director: <?php echo $movie['director'] ?></p>
    </a>
    <?php } ?>
  </div>

  <p class="w3-wide w3-center">Movies(<?php echo count($movies); ?>)</p>

  <hr id="about">
  <footer class="w3-row-padding w3-padding-32">
    <div class="w3-third">
      <h3>About</h3>
      <p>This website is developed by <a href="http://2arian3.github.io/" target="_blank">Arian</a></p>
    </div>
  </footer>
</div>

<script>
  function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
  }

  function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
  }
</script>

</body>
</html>
