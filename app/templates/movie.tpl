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
  <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button">Movies</a>
  <a href="#comments" onclick="w3_close()" class="w3-bar-item w3-button">Comments</a>
  <a href="#about" onclick="w3_close()" class="w3-bar-item w3-button">About</a>
</nav>

<div>
  <div class="w3-xlarge" style="max-width:1200px;margin:auto">
    <div class="w3-button w3-padding-16 w3-left" onclick="w3_open()">☰</div>
    <div class="w3-center w3-padding-16">IMDB</div>
  </div>
</div>

<div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">

  <div class="w3-row-padding w3-padding-16" id="movies">
    <div class="w3-half w3-center">
      <img src="<?php echo $movie['poster'] ?>" alt="..." style="width:100%;">
      <h3><?php echo $movie['name'] ?></h3>
      <p>Director: <?php echo $movie['director'] ?></p>
    </div>
    <div class="w3-half">
      <form enctype="multipart/form-data" action="post_comment.php?<?php echo 'id=' . $movie['id'] ?>" method="post" class="w3-cell-top">
        <label for="username">Username</label><br />
        <input class="w3-round-large w3-input" id="username" name="username" /><br />

        <label for="comment">Comment (You can either type your comment or send your voice)</label><br />
        <input class="w3-round-large w3-input" id="comment" name="comment" /><br />

        <input type="file" id="file" name="file" accept="audio/*">
        <button class="w3-button w3-border w3-hover-white w3-black w3-round-large" type="submit">Post Comment</button>
      </form>
      <hr>

      <div class="w3-cell-bottom">
        <div class="w3-row">
          <a href="movie.php?<?php echo 'id=' . $movie['id'] . '&show_comments=' . (!$show_comments ? 'true' : 'false') . '&lang=' . $language ?>"
             class="w3-button w3-border w3-hover-white w3-black w3-half w3-round-large">
            <?php echo $show_comments  ? 'Hide Comments' : 'Show Comments' ?>
          </a>
          <select class="w3-button w3-border w3-hover-white w3-black w3-half w3-round-large" name="option" onchange="location = this.value;">
            <option value="" disabled selected><?php echo $language ?></option>
            <option value="movie.php?<?php echo 'id=' . $movie['id'] . '&show_comments=' . ($show_comments ? 'true' : 'false') . '&lang=English'?>">English</option>
            <option value="movie.php?<?php echo 'id=' . $movie['id'] . '&show_comments=' . ($show_comments ? 'true' : 'false') . '&lang=German'?>">German</option>
            <option value="movie.php?<?php echo 'id=' . $movie['id'] . '&show_comments=' . ($show_comments ? 'true' : 'false') . '&lang=Spanish'?>">Spanish</option>
          </select>
        </div>
        <hr>

        <div id="comments">
          <p class="w3-wide w3-center">Comments(<?php echo $number_of_comments; ?>)</p>
          <?php foreach($comments as $comment){ ?>
          <div class="w3-round w3-light-grey w3-padding-small w3-section ">
            <p><?php echo $comment['username'] ?>: <i class="w3-monospace"><?php echo $comment['text'] ?></i></p>
          </div>
          <?php } ?>
        </div>
      </div>

    </div>
  </div>

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
