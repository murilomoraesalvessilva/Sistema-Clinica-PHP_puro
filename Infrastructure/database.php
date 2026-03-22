<?php 

$caminho = __DIR__ . "/infraestrutura/database/banco.db";

try {
    $pdo = new PDO('sqlite' . $caminho);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexão com SQLite bem sucedida!" . PHP_EOL;
}

catch (Exception $e) {
    echo "Erro de conexão: " . $e->getMessage();
}

?>