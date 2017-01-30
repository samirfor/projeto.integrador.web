<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$link = new mysqli("mysql", getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DATABASE'));

/* verifica conexão */
if (mysqli_connect_error()) {
  die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

if (!empty($_GET) && !empty($_GET['numero_matricula'])) {
  // processar formulário
  if ($stmt = $link->prepare("DELETE FROM aluno WHERE numero_matricula=?;")) {
      $stmt->bind_param('i', $_GET['numero_matricula']);
      $stmt->execute();
      $stmt->close();
  } else {
    printf("Error: %s\n", mysqli_error($link));
    die();
  }
  if ($stmt = $link->prepare("DELETE FROM matricula WHERE numero_matricula=?;")) {
      $stmt->bind_param('i', $_GET['numero_matricula']);
      $stmt->execute();
      $stmt->close();
  } else {
    printf("Error: %s\n", mysqli_error($link));
    die();
  }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
