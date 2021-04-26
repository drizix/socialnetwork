<?php

$action = $_GET["action"] ?? "display";

switch ($action) {

  case 'register':
    // code...
    break;

  case 'logout':
    // code...
    break;

  case 'login':
    // code...
    break;

  case 'newMsg':
    // code...
    break;

  case 'newComment':
    // code...
    break;

  case 'display':
  default:
    include "../models/PostManager.php";
    $posts = GetAllPosts();

    // var_dump($posts);
    include "../models/CommentManager.php";
    $comments = array();

    for ($i = 0; $i < sizeof($posts); $i++) {
      $comments[$i] =  GetAllCommentsFromPostId($posts[$i]['id']);
    }
    // ===================HARDCODED PART===========================
    // format idPost => array of comments
    // $comments[1] = array(
    //   array("nickname" => "FakeUser1", "created_at" => "1970-01-01 00:00:00", "content" => "Fake comment 01."),
    //   array("nickname" => "FakeUser2", "created_at" => "1970-01-02 00:00:00", "content" => "Fake comment 02."),
    //   array("nickname" => "FakeUser1", "created_at" => "1970-01-03 00:00:00", "content" => "Fake comment 03.")
    // );
    // $comments[3] = array(
    //   array("nickname" => "FakeUser1", "created_at" => "1970-01-01 00:00:00", "content" => "Fake comment 04."),
    // );
    // =============================================================

    include "../views/DisplayPosts.php";
    break;
}
