<?php
use App\Model\Avaliador;
use App\Model\Leilao;
use App\Model\Lance;
use App\Model\Usuario;

require_once 'vendor\autoload.php';

$avaliador = new Avaliador();
$leilao = new Leilao("Meu saco");

$leilao->propoe(new Lance(new Usuario("Franklin"), 500.0));
$leilao->propoe(new Lance(new Usuario("João"), 600.0));
$leilao->propoe(new Lance(new Usuario("Franklin"), 800.0));
$leilao->propoe(new Lance(new Usuario("Pedro"), 700.0));
$avaliador->avalia($leilao);
$avaliador->pegaOsTresMaiores($leilao);
$lances = $leilao->getLances();
echo '<pre>';
$franklin = new Usuario("Franklin");
$ultimoLance;
for ($i = 0; $i < count($lances); $i ++) {
    if ($lances[$i]->getUsuario()->getNome() === $franklin->getNome()) {
        $ultimoLance = $lances[$i];
    }
}

print_r($ultimoLance);





