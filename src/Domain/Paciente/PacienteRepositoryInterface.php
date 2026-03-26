<?php

namespace App\Domain\Paciente;

interface PacienteRepositoryInterface {

public function salvar(Paciente $paciente): void;
public function buscarPorID(int $id): ?Paciente;
public function listarTodos(): array;
public function deletar(int $id): void;
public function recuperar(int $id): void;
}

?>
