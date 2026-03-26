<?php

namespace App\Domain\Medico;

interface MedicoRepositoryInterface {
    public function salvar(Medico $medico): void;
    public function buscarPorID(int $id): ?Medico;
    public function listarTodos(): array;
    public function deletar(int $id): void;
    public function recuperar(int $id): void;
}