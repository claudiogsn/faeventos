<?php
session_start();
$id = $_SESSION["id"];
// Configurações do banco de dados
$dsn = 'mysql:host=localhost:3308;dbname=faeventos;charset=utf8';
$username = 'root';
$password = '';

try {
  // Cria uma instância da classe PDO
  $conexao = new PDO($dsn, $username, $password);
  $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Verifica se o formulário foi submetido
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Diretório onde as imagens serão armazenadas
    $diretorio = "uploads/";

    // Nome do arquivo original
    $nomeArquivo = basename($_FILES["imagem"]["name"]);

    // Caminho completo do arquivo no servidor
    $caminhoArquivo = $diretorio . $nomeArquivo;

    // Verifica se o arquivo é uma imagem
    $tipoArquivo = pathinfo($caminhoArquivo, PATHINFO_EXTENSION);
    $permitidos = array("jpg", "jpeg", "png");

    if (in_array($tipoArquivo, $permitidos)) {
      // Move o arquivo para o diretório de uploads
      if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoArquivo)) {
        // Insere o caminho do arquivo na tabela do banco de dados
        $sql = "update evento set certificado_caminho = :caminho where id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':caminho', $caminhoArquivo);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo $caminhoArquivo;
        echo $id;

        echo "Upload realizado com sucesso!";
      } else {
        echo "Erro ao fazer o upload do arquivo.";
      }
    } else {
      echo "Formato de arquivo não suportado. Apenas JPG, JPEG, PNG e GIF são permitidos.";
    }
  }
} catch (PDOException $e) {
  echo "Erro na conexão com o banco de dados: " . $e->getMessage();
}
?>
