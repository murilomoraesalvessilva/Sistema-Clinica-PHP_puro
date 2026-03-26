<?php

namespace App\Domain\Consulta;

use App\Domain\Medico\Medico;
use App\Domain\Paciente\Paciente;

class Consulta {
    public function __construct(
        private Medico $medico,
        private Paciente $paciente,
        private string $data,
        private string $horario,
        private string $status = 'agendada'
    ) {}

    public function getMedico(): Medico {
        return $this->medico;
    }

    public function getPaciente(): Paciente {
        return $this->paciente;
    }

    public function getData(): string {
        return $this->data;
    }

    public function getHorario(): string {
        return $this->horario;
    }

    public function __toString(): string {
        return "MEDICO: " . $this->medico->getNome() . PHP_EOL . " PACIENTE: " . $this->paciente->getNome() . PHP_EOL . "DATA: " . $this->getData() . PHP_EOL . "HORARIO: " . $this->getHorario() . PHP_EOL . "STATUS: $this->status" . PHP_EOL;
    }
}