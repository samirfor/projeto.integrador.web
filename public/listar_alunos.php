<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$alunos = array();
$link = new mysqli("mysql", getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DATABASE'));

/* verifica conexão */
if (mysqli_connect_error()) {
  die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

$sql_listar_somente_concluintes = '';
$concluintes = false;
if (isset($_GET['concluintes']) && boolval($_GET['concluintes'])) {
  $sql_listar_somente_concluintes = 'AND matricula.semestre=4';
  $concluintes = true;
}

/* verifica se houve resultado com pelo menos uma linha */
if ($query = $link->query("SELECT matricula.numero_matricula
  ,aluno.nome_aluno
  ,curso.curso_descricao
  ,turno.turno_descricao
  ,matricula.semestre
FROM aluno
INNER JOIN matricula ON matricula.numero_matricula = aluno.numero_matricula
INNER JOIN curso ON curso.idcurso = matricula.curso_id
INNER JOIN turno ON turno.idturno = matricula.turno_id
WHERE
  matricula.numero_matricula > 0
  ${sql_listar_somente_concluintes}
ORDER BY aluno.nome_aluno ASC;")
  ) {
  if ($query->num_rows) {
    $alunos = $query->fetch_all(MYSQLI_ASSOC);
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
          <a class="button button-primary" href="cadastrar_alunos.php">Cadastrar aluno</a>
          <a class="button button-primary" href="listar_alunos.php">Listar todos os alunos</a>
          <a class="button button-primary" href="listar_alunos.php?concluintes=true">Listar todos os concluíntes</a>
      </div>

      <div class="row">
          <h5>Lista de todos os alunos <?php echo ($concluintes) ? "concluíntes" : ""; ?>:</h5>

          <?php if (!$alunos) : ?>
            <p>Nenhum aluno cadastrado.</p>
          <?php else: ?>
          <table>
            <thead>
              <tr>
                <th>Número de Matrícula</th>
                <th>Nome do Aluno</th>
                <th>Curso</th>
                <th>Turno</th>
                <th>Período</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($alunos as $aluno) : ?>
              <tr>
                <td><?php echo $aluno['numero_matricula']; ?></td>
                <td><?php echo $aluno['nome_aluno']; ?></td>
                <td><?php echo $aluno['curso_descricao']; ?></td>
                <td><?php echo $aluno['turno_descricao']; ?></td>
                <td><?php echo $aluno['semestre']; ?></td>
              </tr>
              <?php endforeach ?>
            </tbody>
          </table>
          <?php endif ?>
      </div>

    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
