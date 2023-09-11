<?php
header("Content-type: text/html; charset=utf-8");
$id = $_GET["id"];

try {
    $connect = new PDO("mysql:host=localhost:3308;dbname=faeventos;charset=utf8", "root", "");
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ativar modo de exceção

    $consulta = $connect->prepare(
        "select p.nome as participante,p.email,p.cpf,p.telefone,p.data_criacao,p.impressao_cracha,p.impressao_certificado,e.certificado_caminho,p.origem_cadastro,ep.nome as empresa,e.nome as evento from participante p inner join empresa ep on p.empresa_id = ep.id inner join evento e on p.evento_id = e.id where p.id = :id;"
    );
    $consulta->bindParam(":id", $id, PDO::PARAM_STR);
    $consulta->execute();
    $result = $consulta->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $Results) {
        $nome = $Results["participante"];
        $empresa = $Results["empresa"];
        $cpf = $Results["cpf"];
        $certificado = $Results["certificado_caminho"];
    }

    if (count($result)) {
        session_start();
        $_SESSION["nome"] = $nome;
        $certificadoComp = "http://".$_SERVER["SERVER_NAME"] . "/faeventos/feed/" . $certificado;
        $_SESSION["certificado_caminho"] = $certificadoComp;

        echo "<html> <head>
      <meta charset='UTF-8'>
      <link href='https://fonts.cdnfonts.com/css/lato' rel='stylesheet'>
      <style>
        @import url('https://fonts.cdnfonts.com/css/lato');
      </style>
      <link href='https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css' rel='stylesheet' />
      <style>
        @page {
          size: A4 landscape
        }
      </style>
      <style>
        .container {
          display: inline-block;
          position: relative;
        }

        .nome {
          position: absolute;
          display: flex;
          top: 50%;
          left: 33%;
          justify-content: center;
          font-size: 30px;
          text-align: center;
          font-family: 'Lato', sans-serif;
        }
      </style>
      <link rel='stylesheet' href='css/style.css'>
    </head>
    <body>
      <div class='container'>
        <img height='100%' src=".$certificadoComp." alt='certificado'>
      </div>
      <div class='nome'>
        <center>$nome</center>
      </div>
    </body>
    </html>";
    } else {
        session_start();
        var_dump($_SESSION['certificado_caminho']);
    }
} catch (PDOException $e) {
    // Trate a exceção aqui, por exemplo, exibindo uma mensagem de erro
    echo "Erro no banco de dados: " . $e->getMessage();
}
?>
