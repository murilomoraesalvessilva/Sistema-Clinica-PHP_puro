<?php 

class Medico {

    public function __construct(private string $nome, private string $crm, private string $especialidade) {

        $this->nome = $nome;
        $this->crm = $crm;
        $this->especialidade = $especialidade;

    }

    public function getNome(): string {

        return $this->nome;

    }

    public function getCrm(): string {

        return $this->crm;

    }

    public function getEspecialidade(): string {

        return $this->especialidade;

    }

    public function __toString(): string {

        return "Medico: $this->nome" . PHP_EOL . "CRM: $this->crm" . PHP_EOL . "Especialidade: $this->especialidade" . PHP_EOL;

    }

}

?>