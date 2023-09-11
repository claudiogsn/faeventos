<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="js/jqbtk.js">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" href="https://rodadadenegociosfoco.com.br/wp-content/uploads/2022/02/cropped-foco-operadora-icon-192x192.png" sizes="192x192">
    <link href="https://fonts.googleapis.com/css?family=Exo:100,200,300,400,500,600,700,800,900|Exo+2:100,200,300,400,500,600,700,800,900|Exo:100,200,300,400,500,600,700,800,900" rel="stylesheet">
</head>
<style>body {font-family: Exo;} </style>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<center><img width="60%" src="imagens/logo.png" alt="logo"></center>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<center>
    <p class="alert alert-danger bemvindo" name="bemvindo" id="bemvindo"><strong>CPF NÃO ENCONTRADO! TENTE NOVAMENTE</strong></p>
</center>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<center>
    <strong>
        <h1>Digite seu CPF:</h1>
    </strong>
</center>
<center>
    <form method="get" action="print.php">
        <div class="form-group ">
            <label for="telephone-keypad-demo"></label>
            <small>Apenas números</small>
            <input autocomplete="off" name="cpf" class="form-control use-keyboard-input">
            <script src="js/Keyboard.js"></script>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <button type="submit" class="btn btn-success btn-lg imp">IMPRIMIR</button>
    </form>
</center>
<br>
<br>
<script src="dw/jquery.min.js"></script>
<script src="dw/bootstrap.min.js"></script>
<script src="js/jqbtk.js"></script>
<body class="container">
<script>
    $(function(){
        $('#telephone-keypad-demo').keyboard();
    });
</script>
<script>$("#warnalert").fadeOut(10000);</script>