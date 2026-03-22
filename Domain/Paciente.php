<?php 

class Paciente {

    public function __construct(private string $nome, private string $cpf, private array $telefone) {

        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->telefone = $telefone;

    }

    public function getNome(): string {
        
        return $this->nome;

    }

    public function getCpf(): string {

        return $this->cpf;

    }

    public function getTelefone(): array {
        
        return $this->telefone;
    
    }

    public function __toString(): string {

        return "Paciente: $this->nome" . PHP_EOL . "CPF: $this->cpf";

    }

}

?>