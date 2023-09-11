<?php
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
    $empresa = $Results['empresa'];
    $cpf = $Results['cpf'];
}
if (count($result))
{
    session_start();
    $_SESSION['nome'] = $nome;

    echo "
    <html>
<head>
    <meta charset='UTF-8'>
    <link href='https://fonts.cdnfonts.com/css/lato' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css' rel='stylesheet' />
    <style>@import url('https://fonts.cdnfonts.com/css/lato');</style>
    <link rel='stylesheet' href='css/style.css'>
</head>
<body>
    <div style='font-family: Lato' class='css'>
        <p>$nome</p>
        <hr>
        <p>$empresa</p>
    </div>
</body>
<script>window.onload = function() {window.print();}</script>
</html>";
}
//<script>window.onload = function() {window.print();}</script>
else
{
    echo "<script>window.location.href='indexn.php';</script>";
}

?>
