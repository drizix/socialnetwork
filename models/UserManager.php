<?php
include_once "PDO.php";

function GetOneUserFromId($id)
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM user WHERE id = $id");
  return $response->fetch();
}

function GetAllUsers()
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM user ORDER BY nickname ASC");
  return $response->fetchAll();
}

function GetUserIdFromUserAndPassword($username, $password)
{
  $username = "\"" . $username . "\"";
  global $PDO;
  $response = ($PDO->query("SELECT password FROM user WHERE nickname = $username"))->fetchAll();
  $result = ($response[0]['password'] == $password) ?  1 : -1;
  return $result;
}
