<?php
namespace App\Model;

class Leilao
{

    private $descricao;

    private $lances;

    function __construct($descricao)
    {
        $this->descricao = $descricao;
        $this->lances = array();
    }

    public function propoe(Lance $lance)
    {
        if ($this->isLancesEmpty() or $this->isMesmoUsuario($lance->getUsuario()) && $this->qtdLancesUsuario() < 5) {
            $this->lances[] = $lance;
        }
    }

    public function dobraLance(Usuario $usuario)
    {
        $ultimoLance = $this->ultimoLanceUsuario($usuario);
        if ($ultimoLance != null) {
            $this->propoe(new Lance($usuario, $ultimoLance->getValor() * 2));
        }
    }

    /**
     *
     * @param
     *            Usuario usuario
     * @param
     */
    private function ultimoLanceUsuario(Usuario $usuario)
    {
        $ultimoLance = null;
        foreach ($this->lances as $lance) {
            if ($lance->getUsuario()->getNome() === $usuario->getNome()) {
                $ultimoLance = $lance;
            }
        }
        return $ultimoLance;
    }

    private function ultimoLanceDado()
    {
        return $this->lances[count($this->lances) - 1];
    }

    private function isMesmoUsuario(Usuario $usuario)
    {
        return $usuario->getNome() != $this->ultimoLanceDado()
            ->getUsuario()
            ->getNome();
    }

    public function qtdLancesUsuario()
    {
        $total = 0;
        foreach ($this->lances as $lance) {
            if ($this->isMesmoUsuario($lance->getUsuario())) {
                $total ++;
            }
        }
        return $total;
    }

    public function isLancesEmpty()
    {
        if (empty($this->lances)) {
            return true;
        }
        return false;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function getLances()
    {
        return $this->lances;
    }
}
?>