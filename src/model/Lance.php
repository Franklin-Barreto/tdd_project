<?php
namespace App\Model;

class Lance
{

    private $usuario;

    private $valor;

    function __construct(Usuario $usuario, $valor)
    {
        if ($valor < 1) {
            throw new \InvalidArgumentException("Valor inválido");
        }

        $this->usuario = $usuario;
        $this->valor = $valor;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }
}
?>