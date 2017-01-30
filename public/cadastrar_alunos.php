<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$cursos = array();
$turnos = array();
$link = new mysqli("mysql", getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DATABASE'));

/* verifica conexão */
if (mysqli_connect_error()) {
  die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

if (!empty($_POST)) {
  // processar formulário
  if ($stmt = $link->prepare("INSERT INTO aluno SET nome_aluno=?")) {
      $stmt->bind_param("s", $_POST["nome_aluno"]);
      $stmt->execute();
      $stmt->close();
  } else {
    printf("Error: %s\n", mysqli_error($link));
    die();
  }
  if ($stmt = $link->prepare("INSERT INTO matricula SET numero_matricula=LAST_INSERT_ID(), curso_id=?, turno_id=?, semestre=?")) {
      $stmt->bind_param("iii", intval($_POST['curso']), intval($_POST['turno']), intval($_POST['periodo']));
      $stmt->execute();
      $stmt->close();
  } else {
    printf("Error: %s\n", mysqli_error($link));
    die();
  }
  header('Location: curso.php?idcurso=' . $_POST['curso']);
}

/* verifica se houve resultado com pelo menos uma linha */
if ($query = $link->query("SELECT * FROM curso ORDER BY curso_descricao")) {
  if ($query->num_rows) {
    $cursos = $query->fetch_all(MYSQLI_ASSOC);
  }
  $query->close();
} else {
  printf("Error: %s\n", mysqli_error($link));
  exit();
}

if ($query = $link->query("SELECT * FROM turno ORDER BY idturno")) {
  if ($query->num_rows) {
    $turnos = $query->fetch_all(MYSQLI_ASSOC);
  }
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
          <a class="button button-primary" href="index.php">Cursos</a>
          <a class="button button-primary" href="listar_alunos.php">Listar todos os alunos</a>
          <a class="button button-primary" href="listar_alunos.php?concluintes=true">Listar todos os concluíntes</a>
      </div>

      <div class="row">
        <div class="one-half column">

          <h5>Cadastro de Aluno:</h5>

          <!-- The above form looks like this -->
          <form method="post">
            <div class="row">
                <label for="nome_aluno">Nome</label>
                <input class="u-full-width" type="text" placeholder="Fulano da Silva" name="nome_aluno" id="nome_aluno" >
            </div>
            <!-- <div class="row">
                <label for="matricula">Matrícula</label>
                <input class="u-full-width" type="text" name="matricula" id="matricula" >
            </div> -->
            <div class="row">
              <label for="curso">Curso</label>
              <select class="u-full-width" id="curso" name="curso">
                <?php foreach ($cursos as $curso): ?>
                <option value="<?php echo $curso['idcurso']; ?>"><?php echo $curso['curso_descricao']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="row">
              <label for="turno">Turno</label>
              <select class="u-full-width" id="turno" name="turno">
                <?php foreach ($turnos as $turno): ?>
                <option value="<?php echo $turno['idturno']; ?>"><?php echo $turno['turno_descricao']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="row">
              <label for="periodo">Período</label>
              <select class="u-full-width" id="periodo" name="periodo">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </div>
            <input class="button-primary" type="submit" value="Cadastrar">
          </form>

          <!-- Always wrap checkbox and radio inputs in a label and use a <span class="label-body"> inside of it -->

          <!-- Note: The class .u-full-width is just a utility class shorthand for width: 100% -->

        </div>
      </div>

    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
