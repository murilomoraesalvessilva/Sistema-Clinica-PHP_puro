<?php

try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/database/banco.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erro de conexão: " . $e->getMessage());
}

$pdo->exec("CREATE TABLE IF NOT EXISTS medicos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    crm TEXT NOT NULL,
    especialidade TEXT NOT NULL,
    deletado_em TEXT DEFAULT NULL
)");
echo "Tabela médicos criada!" . PHP_EOL;

$pdo->exec("CREATE TABLE IF NOT EXISTS pacientes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    cpf TEXT NOT NULL,
    telefones TEXT NOT NULL,
    data_nascimento TEXT NOT NULL,
    deletado_em TEXT DEFAULT NULL
)");
echo "Tabela pacientes criada!" . PHP_EOL;

$pdo->exec("CREATE TABLE IF NOT EXISTS consultas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    medico_id INTEGER NOT NULL,
    paciente_id INTEGER NOT NULL,
    data TEXT NOT NULL,
    horario TEXT NOT NULL,
    deletado_em TEXT DEFAULT NULL,
    status TEXT DEFAULT 'agendada'
)");
echo "Tabela consultas criada!" . PHP_EOL;