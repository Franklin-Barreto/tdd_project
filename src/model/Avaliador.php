<?php
namespace App\Model;

class Avaliador
{

    private $maiorLance = - INF;

    private $menorLance = INF;

    private $valorMedio = 0;

    private $maiores;

    public function avalia(Leilao $leilao)
    {
        if (count($leilao->getLances()) <= 0) {
            throw new \InvalidArgumentException("Um leilão precisa ter pelo menos um lance");
        }

        $total = 0;
        foreach ($leilao->getLances() as $lance) {
            if ($lance->getValor() > $this->maiorLance) {
                $this->maiorLance = $lance->getValor();
            }
            if ($lance->getValor() < $this->menorLance) {
                $this->menorLance = $lance->getValor();
            }
            $total += $lance->getValor();
        }
        $this->valorMedio = ! empty($total) ? $total / count($leilao->getLances()) : 0;
        $this->pegaOsTresMaiores($leilao);
    }

    public function pegaOsTresMaiores(Leilao $leilao)
    {
        $lances = $leilao->getLances();

        usort($lances, function ($a, $b) {
            return ($a->getValor() == $b->getValor() ? true : false) ? 0 : ($a->getValor() < $b->getValor() ? true : false) ? 1 : - 1;
        });
        $this->maiores = array_slice($lances, 0, 3);
    }

    public function getMaiores()
    {
        return $this->maiores;
    }

    public function getValorMedio()
    {
        return $this->valorMedio;
    }

    public function getMaiorLance()
    {
        return $this->maiorLance;
    }

    public function getMenorLance()
    {
        return $this->menorLance;
    }
}

