<?php
session_start(); // Iniciar a sessão

// Limpar o buffer de saída
ob_start();

try {
    //Conexão com o banco de dados
    $conn = new PDO('mysql:host=localhost:3308;dbname=faeventos;charset=utf8', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configurar para lançar exceções em caso de erros
} catch (PDOException $err) {
    throw new Exception("Erro na conexão com o banco de dados: " . $err->getMessage());
}

// Receber o arquivo do formulário
$arquivo = $_FILES['arquivo'];
$id = $_SESSION['id'];
$origem = 'P';

// Variáveis de validação
$primeira_linha = true;
$linhas_importadas = 0;
$linhas_nao_importadas = 0;
$usuarios_nao_importados = [];

// Verificar se é arquivo CSV
$extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
if (strtolower($extensao) != "csv") {
    // Erro de tipo de arquivo inválido
    $_SESSION['error_msg'] = "Necessário enviar um arquivo CSV!";
    header("Location: error_page.php");
    exit();
}

try {
    // Iniciar uma transação no banco de dados
    $conn->beginTransaction();

    // Ler os dados do arquivo
    $dados_arquivo = fopen($arquivo['tmp_name'], "r");

    // Percorrer os dados do arquivo
    while ($linha = fgetcsv($dados_arquivo, 1000, ";")) {
        // Como ignorar a primeira linha do Excel
        if ($primeira_linha) {
            $primeira_linha = false;
            continue;
        }

        // Usar array_walk_recursive para criar função recursiva com PHP
        array_walk_recursive($linha, 'converter');

        // Criar a QUERY para salvar o usuário no banco de dados
        $query_usuario = "INSERT INTO PARTICIPANTE (cpf, nome, email, telefone, evento_id, origem_cadastro) VALUES (:cpf, :nome, :email, :telefone, :evento_id, :origem)";

        // Preparar a QUERY
        $cad_usuario = $conn->prepare($query_usuario);

        // Substituir os links da QUERY pelos valores
        $cad_usuario->bindValue(':cpf', ($linha[0] ?? "NULL"));
        $cad_usuario->bindValue(':nome', ($linha[1] ?? "NULL"));
        $cad_usuario->bindValue(':email', ($linha[2] ?? "NULL"));
        $cad_usuario->bindValue(':telefone', ($linha[3] ?? "NULL"));
        $cad_usuario->bindValue(':evento_id', $id, PDO::PARAM_STR);
        $cad_usuario->bindValue(':origem', $origem, PDO::PARAM_STR);

        // Executar a QUERY
        $cad_usuario->execute();

        // Verificar se cadastrou corretamente no banco de dados
        if ($cad_usuario->rowCount()) {
            $linhas_importadas++;
        } else {
            $linhas_nao_importadas++;
            $usuarios_nao_importados[] = $linha[0] ?? "NULL";
        }
    }

    // Confirmar a transação
    $conn->commit();

    // Criar a mensagem com os CPF dos usuários não cadastrados no banco de dados
    if (!empty($usuarios_nao_importados)) {
        $usuarios_nao_importados_str = implode(", ", $usuarios_nao_importados);
        $_SESSION['msg'] = "Usuários não importados: $usuarios_nao_importados_str.";
        header("Location: Location: evento.php?id=$id");
        exit();
    }

    // Mensagem de sucesso
    $_SESSION['msg'] = "$linhas_importadas linha(s) importa(s), $linhas_nao_importadas linha(s) não importada(s).";
    header("Location: Location: evento.php?id=$id");
    exit();
} catch (Exception $e) {
    // Em caso de erro, desfazer a transação e mostrar mensagem de erro
    $conn->rollBack();
    $_SESSION['msg'] = "Erro durante a importação: " . $e->getMessage();
    header("Location: evento.php?id=$id");
    exit();
}

function converter(&$dados_arquivo)
{
    $dados_arquivo = mb_convert_encoding($dados_arquivo, "UTF-8", "ISO-8859-1");
}
