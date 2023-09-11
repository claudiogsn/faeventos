<?php
// Retorna o domínio do servidor
echo $_SERVER['SERVER_NAME'] . "<br />";
// Retorna o path do arquivo onde está sendo executado
echo $_SERVER['PHP_SELF'] . "<br />";
// Retorna o path do pasta onde está sendo executado
echo $_SERVER['DOCUMENT_ROOT'] . "<br />";
// Retorna o path do arquivo onde está sendo executado o script
echo $_SERVER['SCRIPT_FILENAME'] . "<br />";
// Retorna o path e nome do arquivo que está executando
echo $_SERVER['SCRIPT_NAME'] . "<br />";

echo "<hr >";
$path = $_SERVER['SCRIPT_FILENAME'];
$path_parts = pathinfo($path);
// retorna o path absoluto do diretório no servidor
echo $path_parts['dirname'] . "<br />";
// retorna o nome do arquivo com extensão
echo $path_parts['basename'] . "<br />";
// retorna a extensão do arquivo
echo $path_parts['extension'] . "<br />";
// retorna o nome do arquivo sem extensão
echo $path_parts['filename'] . "<br />";