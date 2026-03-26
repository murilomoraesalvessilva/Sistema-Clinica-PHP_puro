<?php

namespace App\Infrastructure\Database;

use App\Domain\Paciente\Paciente;
use App\Domain\Paciente\PacienteRepositoryInterface;

class SQLitePacienteRepository implements PacienteRepositoryInterface {

    public function __construct(private \PDO $pdo) {}

    public function salvar(Paciente $paciente): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO pacientes (nome, cpf, telefones, data_nascimento)
            VALUES (:nome, :cpf, :telefones, :data_nascimento)
        ");

        $stmt->execute([
            ':nome'            => $paciente->getNome(),
            ':cpf'             => $paciente->getCpf(),
            ':telefones'       => json_encode($paciente->getTelefonesRaw()),
            ':data_nascimento' => $paciente->getDataNascimento()
        ]);
    }

    public function buscarPorId(int $id): ?Paciente {
        $stmt = $this->pdo->prepare("
            SELECT * FROM pacientes WHERE id = :id
        ");

        $stmt->execute([':id' => $id]);
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        return new Paciente(
            $dados['nome'],
            $dados['cpf'],
            json_decode($dados['telefones'], true),
            $dados['data_nascimento']
        );
    }

    public function listarTodos(): array {
        $stmt = $this->pdo->query("SELECT * FROM pacientes");
        $pacientes = [];

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $dados) {
            $pacientes[] = new Paciente(
                $dados['nome'],
                $dados['cpf'],
                json_decode($dados['telefones'], true),
                $dados['data_nascimento']
            );
        }

        return $pacientes;
    }

    public function deletar(int $id): void {
        $stmt = $this->pdo->prepare("
            UPDATE pacientes SET deletado_em = :data WHERE id = :id
        ");

        $stmt->execute([
            ':data' => date('Y-m-d H:i:s'),
            ':id' => $id
            ]);
    }

    public function recuperar(int $id): void {
        $stmt = $this->pdo->prepare("
        UPDATE pacientes SET deletado_em = NULL WHERE id = :id
        ");
    }
}