<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Infrastructure\Database\SQLiteMedicoRepository;
use App\Infrastructure\Database\SQLitePacienteRepository;
use App\Infrastructure\Database\SQLiteConsultaRepository;
use App\Application\CadastrarMedico;
use App\Application\CadastrarPaciente;
use App\Application\AgendarConsulta;

$pdo = new PDO('sqlite:' . __DIR__ . '/database/banco.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$medicoRepository   = new SQLiteMedicoRepository($pdo);
$pacienteRepository = new SQLitePacienteRepository($pdo);
$consultaRepository = new SQLiteConsultaRepository($pdo);

echo "════════════════════════════════" . PHP_EOL;
echo "       TESTANDO STATUS          " . PHP_EOL;
echo "════════════════════════════════" . PHP_EOL;

$consultaRepository->concluir(1);
echo "Consulta 1 concluída!" . PHP_EOL;

$consultaRepository->cancelar(2);
echo "Consulta 2 cancelada!" . PHP_EOL;

echo PHP_EOL . "════════════════════════════════" . PHP_EOL;
echo "          CONSULTAS             " . PHP_EOL;
echo "════════════════════════════════" . PHP_EOL;

foreach ($consultaRepository->listarTodos() as $consulta) {
    echo $consulta . PHP_EOL;
    echo "────────────────────────────────" . PHP_EOL;
}