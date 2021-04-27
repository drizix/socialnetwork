<?php
include_once "PDO.php";

function GetOneCommentFromId($id)
{
  global $PDO;

  $data = [
    'id' => $id
  ];

  $sql = "SELECT * FROM comment WHERE id = :id ";
  $response = $PDO->prepare($sql);
  $response->execute($data);
  return $response->fetch();
}

function GetAllComments()
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM comment ORDER BY created_at ASC");
  return $response->fetchAll();
}

function GetAllCommentsFromUserId($userId)
{
  global $PDO;
  $response = $PDO->query(
    "SELECT comment.*, user.nickname "
      . "FROM comment LEFT JOIN user on (comment.user_id = user.id) "
      . "WHERE comment.user_id = $userId "
      . "ORDER BY comment.created_at ASC"
  );
  return $response->fetchAll();
}

function  GetAllCommentsFromPostId($postId)
{
  global $PDO;
  $response = $PDO->query(
    "SELECT comment.*, user.nickname "
      . "FROM comment LEFT JOIN user on (comment.user_id = user.id) "
      . "WHERE comment.post_id = $postId "
      . "ORDER BY comment.created_at ASC"
  );
  return $response->fetchAll();
}

function CreateNewComment($userId, $postId, $comment)
{
  global $PDO;

  $data = [
    'userId' => $userId,
    'postId' => $postId,
    'comment' => $comment
  ];

  $sql = "INSERT INTO comment(user_id, post_id, content) values (:userId, :postId, :comment)";
  $stmt = $PDO->prepare($sql);
  $stmt->execute($data);
}
