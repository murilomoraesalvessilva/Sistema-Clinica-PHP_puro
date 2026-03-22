<?php 

require_once __DIR__ . "/infraestrutura/database.php";

$pdo->exec("CREATE TABLE IF NOT EXISTS medicos(

id INTEGER PRIMARY KEY AUTOINCREMENT,
nome TEXT NOT NULL,
crm TEXT NOT NULL,
especialidade TEXT NOT NULL

)");

$pdo->exec("CREATE TABLE IF NOT EXISTS pacientes(

id INTEGER PRIMARY KEY AUTOINCREMENT,
nome TEXT NOT NULL,
cpf TEXT NOT NULL,
telefone TEXT NOT NULL,

)");

$pdo->exec("CREATE TABLE IF NOT EXISTS consultas(

id INTEGER PRIMARY KEY AUTOINCREMENT,
idMedico INTEGER NOT NULL,
idPaciente INTEGER NOT NULL,
data TEXT NOT NULL,
horario TEXT NOT NULL

)");

?>