<?php

namespace App\Domain\Consulta;
interface ConsultaRepositoryInterface {
    public function salvar(Consulta $consulta): void;
    public function buscarPorID(int $id): ?Consulta;
    public function listarTodos(): array;
    public function deletar(int $id): void;
    public function concluir(int $id): void;
    public function cancelar(int $id): void;
}