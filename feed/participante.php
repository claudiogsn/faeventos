<?php
session_start();
header("Content-type: text/html; charset=utf-8");
$id = $_GET['id'];
$connect = new PDO('mysql:host=localhost:3308;dbname=faeventos', 'root', '');
$consulta = $connect->prepare('select p.nome as participante,p.email,p.cpf,p.telefone,p.data_criacao,p.impressao_cracha,p.impressao_certificado,p.origem_cadastro,ep.nome as empresa,e.nome as evento from participante p inner join empresa ep on p.empresa_id = ep.id inner join evento e on p.evento_id = e.id where p.id = :id;');
$consulta->bindParam(':id', $id, PDO::PARAM_STR);
$consulta->execute();
$result = $consulta->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $Results)
{
  $nome = $Results['participante'];
  $email = $Results['email'];
  $cpf = $Results['cpf'];
  $telefone = $Results['telefone'];
  $data_criacao = $Results['data_criacao'];
  $impressao_credencial = $Results['impressao_cracha'];
  $impressao_certificado = $Results['impressao_certificado'];
  $origem = $Results['origem_cadastro'];
  $empresa = $Results['empresa'];
  $evento = $Results['evento'];

}
if (count($result))
{
  $_SESSION["nome"] = $nome;
  $_SESSION["email"] = $email;
  $_SESSION["cpf"] = $cpf;
  $_SESSION["telefone"] = $telefone;
  $_SESSION["data_criacao"] = $data_criacao;

  if ($impressao_credencial == 'S'){
    $_SESSION["impressao_cracha"] = "Realizada";
  }elseif ($impressao_credencial == 'N'){
    $_SESSION["impressao_cracha"] = "Não Realizada";
  }else{
    $_SESSION["impressao_cracha"] = $impressao_credencial;
  }

  if ($impressao_certificado == 'S'){
    $_SESSION["impressao_certificado"] = "Realizada";
  }elseif ($impressao_certificado == 'N'){
    $_SESSION["impressao_certificado"] = "Não Realizada";
  }else{
    $_SESSION["impressao_certificado"] = $impressao_certificado;
  }

  if ($origem == 'S'){
    $_SESSION["origem_cadastro"] = "Sistema";
  }elseif ($origem == 'P'){
    $_SESSION["origem_cadastro"] = "Planilha";
  }else{
    $_SESSION["origem_cadastro"] = $origem;
  }

  $_SESSION["empresa"] = $empresa;
  $_SESSION["evento"] = $evento;
  $_SESSION["id"] = $id;


  if($_SERVER['SERVER_NAME'] == "localhost"){
    $_SESSION["editar"] = "http://".$_SERVER['SERVER_NAME']."/faeventos/index.php?class=ParticipanteForm&method=onEdit&id={$id}&key={$id}";
  }else{
    $_SESSION["editar"] = "http://".$_SERVER['SERVER_NAME']."/faeventos/index.php?class=ParticipanteForm&method=onEdit&id={$id}&key={$id}";
  }

}

?>



<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
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
            <li style="color: #010b48;" class="breadcrumb-item">
              <a href="#">Home</a>
            </li>
            <li style="color: #010b48;" class="breadcrumb-item">
              <a href="#">Participante</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Página do Participante</li>
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
            <p class="text-muted mb-4"><?php echo $_SESSION['evento']?></p>
            <div class="d-flex justify-content-center mb-2">
              <a href="http://localhost/faeventos/certificado/print.php?id=<?php echo $_SESSION['id']?>" target="_blank" ><button type="button" style="background: #010b48" class="btn btn-primary">Baixar Certificado</button></a>
              <a href="http://localhost/faeventos/credencial/print.php?id=<?php echo $_SESSION['id']?>" target="_blank" ><button type="button" style="background: #010b48" class="btn btn-primary ms-1">Imprimir Credencial</button></a>
            </div>
          </div>
        </div>
        <div class="card mb-4 mb-lg-0"></div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Nome Completo</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $_SESSION['nome']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $_SESSION['email']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">CPF</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $_SESSION['cpf']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Celular</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $_SESSION['telefone']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Data do Cadastro</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $_SESSION['data_criacao']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Emissão Credencial</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $_SESSION['impressao_cracha']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Emissão Certificado</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $_SESSION['impressao_certificado']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Origem do Cadastro</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $_SESSION['origem_cadastro']?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
</section>
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
</html>