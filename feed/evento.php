<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('default_charset','UTF-8');
session_start();
header("Content-type: text/html; charset=utf-8");
$id = $_GET['id'];
$connect = new PDO('mysql:host=localhost:3308;dbname=faeventos;charset=utf8', 'root', '');
$consulta = $connect->prepare('select ev.nome as nome,ev.dt_inicio as dt_inicio,ev.dt_fim as dt_fim,ev.data_criacao as dt_criado,ev.local as local,e.nome as empresa,ativo from evento ev inner join empresa e on ev.empresa_id = e.id where ev.id = :id;');
$consulta->bindParam(':id', $id, PDO::PARAM_STR);
$consulta->execute();
$result = $consulta->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $Results)
{
  $nome = $Results['nome'];
  $dt_inico = $Results['dt_inicio'];
  $dt_fim = $Results['dt_fim'];
  $local = $Results['local'];
  $data_criacao = $Results['dt_criado'];
  $empresa = $Results['empresa'];
  $ativo = $Results['ativo'];

}
if (count($result))
{
  $_SESSION["empresa"] = $empresa;
  $_SESSION["nome"] = $nome;
  $_SESSION["dt_inico"] = $dt_inico;
  $_SESSION["dt_fim"] = $dt_fim;
  $_SESSION["local"] = $local;
  $_SESSION["data_criacao"] = $data_criacao;


  if ($ativo == 'S'){
    $_SESSION["ativo"] = "Ativo";
  }elseif ($ativo == 'N'){
    $_SESSION["ativo"] = "Desativado";
  }else{
    $_SESSION["ativo"] = $ativo;
  }

$_SESSION['id'] = $id;


}

?>



<!DOCTYPE html>
<html lang="pt">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css" rel="stylesheet" />
</head>
<body>
<section style="background-color: #eee;color: #010b48;">
  <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li style="color: #010b48;s" class="breadcrumb-item">
              <a href="#">Home</a>
            </li>
            <li style="color: #010b48;" class="breadcrumb-item">
              <a href="#">Evento</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Página do Evento</li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <h5 class="my-3"><?php echo $_SESSION['nome']?></h5>
            <p class="text-muted mb-1"><?php echo $_SESSION['empresa']?></p>
            <p class="text-muted mb-4"><?php echo $_SESSION['local']?></p>
            <br>
            <div class="d-flex justify-content-center mb-2">
              <button style="background: #010b48" type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#exampleModal">Upload Certificado</button>
              <button style="background: #010b48" type="button" class="btn btn-primary ms-1" data-mdb-toggle="modal" data-mdb-target="#ModalParticipante">Upload Partipantes</button>
              <button type="button" style="background: #010b48" class="btn btn-primary ms-1">Lista Presença</button>
            </div>
            <?php
            if(isset($_SESSION['msg'])){
              echo $_SESSION['msg'];
              unset($_SESSION['msg']);
            }
            ?>
            <br>

          </div>
        </div>
        <div class="card mb-4 mb-lg-0"></div>
      </div>
      <div class="col-lg-8">
        <div class="col-lg-12">
          <div class="card mb-4">
            <div class="card-body text-center">
              <h5 class="my-3"><?php echo $_SESSION['nome']?></h5>
              <p class="text-muted mb-1"><?php echo $_SESSION['empresa']?></p>
              <p class="text-muted mb-4"><?php echo $_SESSION['local']?></p>
              <p class="text-muted mb-4">Periodo: <?php echo $_SESSION['dt_inico']?> à <?php echo $_SESSION['dt_fim']?> </p>
              <div class="d-flex justify-content-center mb-2">
                <button type="button"  class="btn btn-lg btn-primary">15 <br> Participantes Inscritos</button>
                <button type="button"  class="btn btn-lg btn-success ms-1">10 <br> Credenciais Emitidas</button>
                <button type="button"  class="btn btn-lg btn-warning ms-1">5 <br> Certificados Emitidos</button>
              </div>


            </div>
          </div>
          <div class="card mb-4 mb-lg-0"></div>
        </div>

        </div>
      </div>

    <table class="table align-middle mb-0 bg-white">
      <thead class="bg-light">
      <tr>
        <th>Nome</th>
        <th>Email</th>
        <th>Status</th>
        <th>CPF</th>
        <th>Telefone</th>
      </tr>
      </thead>
      <tbody>
      <?php
      $id = $_GET['id'];
      $conn = new PDO('mysql:host=localhost:3308;dbname=faeventos;charset=utf8', 'root', '');
      $cons = $conn->prepare('select * from participante where evento_id = :id;');
      $cons->bindParam(':id', $id, PDO::PARAM_STR);
      $cons->execute();
      //$res = $cons->fetchAll(PDO::FETCH_ASSOC);

      while ($row = $cons->fetch(PDO::FETCH_ASSOC))
      {
        $nome = $row['nome'];
        $cpf = $row['cpf'];
        $telefone = $row['telefone'];
        $email = $row['email'];
        $presenca = $row['presenca'];

        echo "<td><div class='d-flex align-items-center'><div class='ms-3'><p class='fw-bold mb-1'>$nome</p></div></div></td>";
        echo "<td><p class='fw-normal mb-1'>$email</p></td>";
        echo " <td><span class='badge badge-success rounded-pill d-inline'>$presenca</span></td>";
        echo "<td>$cpf</td>";
        echo "<td>$telefone</td>";
        echo "<tr>";

      }

?>

      </tbody>
    </table>
    </div>
  <br>
</section>

<!-- Modal Certificado -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Selecione uma imagem:</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="upload.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" placeholder="<?php echo $_SESSION['id']?>" >
          <input type="file" class="form-control" name="imagem" id="imagem">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-mdb-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Enviar</button></form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Participante -->
<div class="modal fade" id="ModalParticipante" tabindex="-1" aria-labelledby="ModalParticipanteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalParticipanteLabel">Selecione o Arquivo CSV:</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="processa.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" placeholder="<?php echo $_SESSION['id']?>" >
          <input type="file" accept="text/csv" class="form-control" name="arquivo" id="arquivo">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-mdb-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Enviar</button>
      </div>
    </div>
  </div>
</div>

</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
</html>