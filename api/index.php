<?php
// Configurações do banco de dados


try {
    // Cria uma conexão PDO
    $pdo = new PDO("mysql:host=localhost:3308;dbname=faeventos;charset=utf8", "root", "");

    // Define o modo de erro para Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recebe o parâmetro CPF via GET ou POST
    $cpf = $_GET['cpf'];

    // Verifica se o CPF foi fornecido
    if (is_null($cpf)) {
        echo "O parâmetro CPF deve ser fornecido.";
        exit;
    }

    // Prepara a consulta SQL com base no CPF fornecido
    $sql = "SELECT * FROM participante WHERE cpf = :cpf";

    // Prepara a declaração SQL
    $stmt = $pdo->prepare($sql);

    // Associa o parâmetro ao valor
    $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);

    // Executa a consulta
    $stmt->execute();

    // Obtém os resultados como um array associativo
    $participantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna os resultados como JSON
    header('Content-Type: application/json');
    echo json_encode($participantes);
} catch (PDOException $e) {
    // Em caso de erro, exibe a mensagem de erro
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
}
?>
