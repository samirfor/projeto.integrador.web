<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$cursos = array();
$link = new mysqli("mysql", getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DATABASE'));

/* check connection */
if (mysqli_connect_error()) {
  die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

/* Select queries return a resultset */
if ($query = $link->query("SELECT * FROM curso ORDER BY curso_descricao")) {
  if ($query->num_rows) {
    $cursos = $query->fetch_all(MYSQLI_ASSOC);
  } else {
    $cursos = array(
      "idcurso" => "-1",
      "curso_descricao" => "Nenhum curso cadastrado.",
    );
  }
  /* free result set */
  $query->close();
} else {
  printf("Error: %s\n", mysqli_error($link));
  exit();
}
$link->close();

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
        <h1 class="hero-heading">Sistema de Cadastro de Alunos</h1>
        <a class="button button-primary" href="cadastrar_alunos.php">Cadastrar aluno</a>
        <a class="button button-primary" href="listar_alunos.php">Listar todos os alunos</a>
      </div>

      <div class="row">
        <h5>Listar alunos por curso:</h5>
        <?php foreach ($cursos as $curso) : ?>
        <a class="button" href="curso.php?idcurso=<?php echo $curso['idcurso']; ?>"><?php echo $curso['curso_descricao']; ?></a>
        <?php endforeach ?>
      </div>

    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
