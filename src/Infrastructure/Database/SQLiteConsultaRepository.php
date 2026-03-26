<?php

namespace App\Infrastructure\Database;

use App\Domain\Consulta\Consulta;
use App\Domain\Consulta\ConsultaRepositoryInterface;
use App\Domain\Medico\Medico;
use App\Domain\Paciente\Paciente;

class SQLiteConsultaRepository implements ConsultaRepositoryInterface {

    public function __construct(private \PDO $pdo) {}

    public function salvar(Consulta $consulta): void {
        $stmtMedico = $this->pdo->prepare("
            SELECT id FROM medicos WHERE crm = :crm
        ");
        $stmtMedico->execute([':crm' => $consulta->getMedico()->getCrm()]);
        $medico = $stmtMedico->fetch(\PDO::FETCH_ASSOC);

        $stmtPaciente = $this->pdo->prepare("
            SELECT id FROM pacientes WHERE cpf = :cpf
        ");
        $stmtPaciente->execute([':cpf' => $consulta->getPaciente()->getCpf()]);
        $paciente = $stmtPaciente->fetch(\PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare("
            INSERT INTO consultas (medico_id, paciente_id, data, horario)
            VALUES (:medico_id, :paciente_id, :data, :horario)
        ");

        $stmt->execute([
            ':medico_id'   => $medico['id'],
            ':paciente_id' => $paciente['id'],
            ':data'        => $consulta->getData(),
            ':horario'     => $consulta->getHorario()
        ]);
    }

    public function buscarPorID(int $id): ?Consulta {
        $stmt = $this->pdo->prepare("
            SELECT 
                consultas.data,
                consultas.horario,
                medicos.nome AS medico_nome,
                medicos.crm AS medico_crm,
                medicos.especialidade AS medico_especialidade,
                pacientes.nome AS paciente_nome,
                pacientes.cpf AS paciente_cpf,
                pacientes.telefones AS paciente_telefones,
                pacientes.data_nascimento AS paciente_data_nascimento
            FROM consultas
            INNER JOIN medicos ON consultas.medico_id = medicos.id
            INNER JOIN pacientes ON consultas.paciente_id = pacientes.id
            WHERE consultas.id = :id
        ");

        $stmt->execute([':id' => $id]);
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        return $this->montarConsulta($dados);
    }

    public function listarTodos(): array {
        $stmt = $this->pdo->query("
            SELECT
                consultas.id,
                consultas.data,
                consultas.horario,
                consultas.status,
                medicos.nome AS medico_nome,
                medicos.crm AS medico_crm,
                medicos.especialidade AS medico_especialidade,
                pacientes.nome AS paciente_nome,
                pacientes.cpf AS paciente_cpf,
                pacientes.telefones AS paciente_telefones,
                pacientes.data_nascimento AS paciente_data_nascimento
            FROM consultas
            INNER JOIN medicos ON consultas.medico_id = medicos.id
            INNER JOIN pacientes ON consultas.paciente_id = pacientes.id
            WHERE consultas.deletado_em IS NULL
        ");

        $consultas = [];
        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $dados) {
            $consultas[] = $this->montarConsulta($dados);
        }

        return $consultas;
    }

    public function deletar(int $id): void {
        $stmt = $this->pdo->prepare("
        UPDATE consultas SET deletado_em = :data WHERE id = :id
        ");
        $stmt->execute([
                ':data' => date('Y-m-d H:i:s'),
                ':id' => $id
            ]);
    }

    public function concluir(int $id): void {
        $stmt = $this->pdo->prepare("
            UPDATE consultas SET status = 'concluida' WHERE id = :id
        ");
        $stmt->execute([':id' => $id]);
    }

    public function cancelar(int $id): void {
        $stmt = $this->pdo->prepare("
            UPDATE consultas SET status = 'cancelada' WHERE id = :id
        ");
        $stmt->execute([':id' => $id]);
    }

    private function montarConsulta(array $dados): Consulta {
        $medico = new Medico(
            $dados['medico_nome'],
            $dados['medico_crm'],
            $dados['medico_especialidade']
        );

        $paciente = new Paciente(
            $dados['paciente_nome'],
            $dados['paciente_cpf'],
            json_decode($dados['paciente_telefones'], true),
            $dados['paciente_data_nascimento']
        );

        return new Consulta(
            $medico,
            $paciente,
            $dados['data'],
            $dados['horario'],
            $dados['status']
        );
    }
}