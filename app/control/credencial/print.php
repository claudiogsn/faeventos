<?php
header("Content-type: text/html; charset=utf-8");
$id = $_GET['id'];
$connect = new PDO('mysql:host=localhost:3308;dbname=faeventos', 'root', '');
$consulta = $connect->prepare('SELECT * FROM participante WHERE :id');
$consulta->bindParam(':id', $id, PDO::PARAM_STR);
$consulta->execute();
$result = $consulta->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $Results)
{
    $nome = $Results['nome'];
    $empresa = $Results['empresa'];
    $cpf = $Results['cpf'];
    $impresso = $Results['impresso'];
}
if (count($result))
{
    session_start();
    $_SESSION['nome'] = $nome;
    $con = new PDO('mysql:host=localhost;dbname=eventofoco', 'root', '');
    $update = $con->prepare('update userfoco set impresso = "T" where cpf = $cpf');
    $update->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $update->execute();

    echo "
    <html>
<head>
    <meta charset='UTF-8'>
    <link rel='stylesheet' href='css/style.css'>
</head>
<body>
    <div class='css'>
        <p>$nome</p>
        <hr>
        <p>$empresa</p>
    </div>
</body>
<script>window.onload = function() {window.print();}</script>
</html>";
}
else
{
    echo "<script>window.location.href='indexn.php';</script>";
}

?>
