<?php

namespace App\Application;

use App\Domain\Paciente\Paciente;
use App\Domain\Paciente\PacienteRepositoryInterface;

class CadastrarPaciente {

    public function __construct(
        private PacienteRepositoryInterface $pacienteRepository
    ) {}

    public function executar(
        string $nome,
        string $cpf,
        array $telefones,
        string $dataNascimento
    ): void {
        $paciente = new Paciente($nome, $cpf, $telefones, $dataNascimento);
        $this->pacienteRepository->salvar($paciente);
        echo "Paciente $nome cadastrado com sucesso!" . PHP_EOL;
    }
}