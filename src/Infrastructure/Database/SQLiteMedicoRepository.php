<?php

namespace Infrastructure\Database;

use App\Domain\Medico\Medico;
use App\Domain\Medico\MedicoRepositoryInterface;

class SQLiteMedicoRepository implements MedicoRepositoryInterface {

    public function __construct(private \PDO $pdo) {}

    public function salvar(Medico $medico): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO medicos (nome, crm, especialidade) 
            VALUES (:nome, :crm, :especialidade)
        ");

        $stmt->execute([
            ':nome'         => $medico->getNome(),
            ':crm'          => $medico->getCrm(),
            ':especialidade' => $medico->getEspecialidade()
        ]);
    }

    public function buscarPorId(int $id): ?Medico {
        $stmt = $this->pdo->prepare("
            SELECT * FROM medicos WHERE id = :id
        ");

        $stmt->execute([':id' => $id]);
        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        return new Medico(
            $dados['nome'],
            $dados['crm'],
            $dados['especialidade']
        );
    }

    public function listarTodos(): array {
        $stmt = $this->pdo->query("SELECT * FROM medicos");
        $medicos = [];

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $dados) {
            $medicos[] = new Medico(
                $dados['nome'],
                $dados['crm'],
                $dados['especialidade']
            );
        }

        return $medicos;
    }

    public function deletar(int $id): void {
        $stmt = $this->pdo->prepare("
            DELETE FROM medicos WHERE id = :id
        ");

        $stmt->execute([':id' => $id]);
    }
}