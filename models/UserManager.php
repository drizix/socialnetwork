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
  // $username = "\"" . $username . "\"";
  // global $PDO;
  // $response = ($PDO->query("SELECT password FROM user WHERE nickname = $username"))->fetchAll();
  // $result = ($response[0]['password'] == $password) ?  1 : -1;
  // return $result;
  global $PDO;

  $data = [
    "username" => $username,
    "password" => $password
  ];
  $sql = "SELECT id FROM user WHERE nickname = :username AND password = MD5(:password) ";
  $response = $PDO->prepare($sql);
  $response->execute($data);

  if ($response->rowCount() == 1) {
    $row = $response->fetch();
    return $row['id'];
  } else {
    return -1;
  }
}

function IsNicknameFree($nickname)
{
  global $PDO;
  $response = $PDO->prepare("SELECT * FROM user WHERE nickname = :nickname ");
  $response->execute(
    array(
      "nickname" => $nickname
    )
  );
  return $response->rowCount() == 0;
}

function CreateNewUser($nickname, $password)
{
  // global $PDO;
  // $response = $PDO->prepare("INSERT INTO user (nickname, password) values (:nickname , :password )");
  // $response->execute(
  //   array(
  //     "nickname" => $nickname,
  //     "password" => $password
  //   )
  // );
  // return $PDO->lastInsertId();
  global $PDO;

  $data = [
    "nickname" => $nickname,
    "password" => $password
  ];
  $sql = "INSERT INTO user (nickname, password) values (:nickname , MD5(:password) )";

  $response = $PDO->prepare($sql);
  $response->execute($data);
  return $PDO->lastInsertId();
}
