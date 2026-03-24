<?php

namespace App\Application;

use App\Domain\Consulta\Consulta;
use App\Domain\Consulta\ConsultaRepositoryInterface;
use App\Domain\Medico\MedicoRepositoryInterface;
use App\Domain\Paciente\PacienteRepositoryInterface;

class AgendarConsulta {

    public function __construct(
        private ConsultaRepositoryInterface $consultaRepository,
        private MedicoRepositoryInterface $medicoRepository,
        private PacienteRepositoryInterface $pacienteRepository
    ) {}

    public function executar(
        int $medicoId,
        int $pacienteId,
        string $data,
        string $horario
    ): void {
        $medico = $this->medicoRepository->buscarPorId($medicoId);
        $paciente = $this->pacienteRepository->buscarPorId($pacienteId);

        if (!$medico) {
            throw new \InvalidArgumentException("Médico não encontrado!");
        }

        if (!$paciente) {
            throw new \InvalidArgumentException("Paciente não encontrado!");
        }

        $consulta = new Consulta($medico, $paciente, $data, $horario);
        $this->consultaRepository->salvar($consulta);
        echo "Consulta agendada com sucesso!" . PHP_EOL;
    }
}