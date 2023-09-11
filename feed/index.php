<?php
session_start(); // Iniciar a sessão
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Celke - Importar Excel csv e salvar no BD</title>
</head>
<body>

    <h1>Importar Excel .csv</h1>

    <?php
    // Apresentar a mensagem de erro ou sucesso
    if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>

    <!-- Formulario para enviar arquivo .csv -->
    <form method="POST" action="processa.php" enctype="multipart/form-data">
        <label>Arquivo: </label>
        <input type="file" name="arquivo" id="arquivo" accept="text/csv"><br><br>

        <input type="submit" value="Enviar">
    </form>
    
</body>
</html>