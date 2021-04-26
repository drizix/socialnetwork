<!DOCTYPE html>
<html lang="en">

<head>
  <title>Social Network (PHP Course))</title>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="img/icon.png">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
  </script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
  </script>
  <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">
</head>

<body>
  <header class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="?">
      <img src="img/icon.png" width="30" height="30" class="d-inline-block align-top" alt="">
      Tiny Social Network
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <form class="nav-link" method="get">
            <input name="search" type="text"></input>
          </form>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?action=login" role="button">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?action=register" role="button">Sign Up</a>
        </li>
      </ul>
    </div>
  </header>

  <div class="container">
    <div class="row">
      <div class="col">
        <h1 class="display-4">KEEP CALM & LOVE FOXES</h1>
        <blockquote class="blockquote text-center">
          <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
            incididunt ut labore et dolore magna aliqua.</p>
          <footer class="blockquote-footer">Maybe someone famous from <cite>Internet</cite></footer>
        </blockquote>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <?php
        if (isset($posts)) {
          foreach ($posts as $onePost) {
        ?>
            <div class="panel panel-white post panel-shadow">
              <div class="post-heading">
                <div class="pull-left image">
                  <img src="img/avatars/default.png" class="rounded-circle img-thumbnail avatar" alt="<?= $onePost['user_id']; ?>">
                </div>
                <div class="pull-left meta">
                  <div class="title h5">
                    <a href="#"><b><?= htmlspecialchars($onePost['nickname']); ?></b></a>
                  </div>
                  <h6 class="text-muted time"><?= $onePost['created_at']; ?></h6>
                </div>
              </div>
              <div class="post-description">
                <p><?= htmlspecialchars($onePost['content']); ?></p>
              </div>
              <div class="post-footer">
                <ul class="comments-list">
                  <?php
                  $postId = $onePost['id'];
                  if (isset($comments[$postId])) {
                    foreach ($comments[$postId] as $comment) {
                  ?>
                      <li class="comment">
                        <a class="pull-left" href="#">
                          <img class="avatar" src="img/avatars/default.png">
                        </a>
                        <div class="comment-body">
                          <div class="comment-heading">
                            <h4 class="user"><?= htmlspecialchars($comment['nickname']); ?></h4>
                            <h5 class="time"><?= $comment['created_at']; ?></h5>
                          </div>
                          <p><?= htmlspecialchars($comment['content']); ?></p>
                        </div>
                      </li>
                  <?php
                    }
                  }
                  ?>
                </ul>
              </div>
            </div>
        <?php
          }
        }
        ?>
      </div>
    </div>
  </div>
</body>

</html>