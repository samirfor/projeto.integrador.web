<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

$link = mysqli_connect("mysql", getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DATABASE'));

/* check connection */
if (!$link) {
  printf("Conexão ao banco falhou: %s\n", $mysqli->connect_error);
  exit();
}

echo '<pre>';


/* Select queries return a resultset */
if ($result = mysqli_query($link, "show tables")) {
// if ($result = $mysqli->query("SELECT * FROM cursos")) {
  // printf("Select returned %d rows.\n", $result->num_rows);
  var_dump($result);

  /* free result set */
  // $result->close();
} else {
  printf("Error: %s\n", mysqli_error($link));
  exit();
}
// $mysqli->close();
mysqli_close($link);
echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Projeto Integrado Linguagem de Programação Web</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->

  <div class="section hero">
    <div class="container">
      <div class="row">
        <div class="one-half column">
          <h1 class="hero-heading">Sistema de Cadastro de Alunos</h1>
          <a class="button button-primary" href="aluno.php">Cadastrar</a>
          <a class="button button-primary" href="aluno.php">Listar todos os alunos</a>
        </div>
      </div>

      <div class="row">
        <div class="one-half column">
          <h5>Listar alunos por curso:</h5>
          <?php foreach ($cursos as $curso) : ?>
          <a class="button" href="curso.php?acao=listar&id_curso=<?php echo $curso->id_curso; ?>"><?php echo $curso->curso_descricao; ?></a>
          <?php endforeach ?>
        </div>
      </div>

    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
