<?php
// require_once 'vendor\autoload.php';
use PHPUnit\Framework\TestCase;
use App\Model\Usuario;
use App\Model\Leilao;
use App\Model\Lance;
use App\Model\Avaliador;
use App\Model\ConstrutorDeLeilao;

/**
 * Avaliador test case.
 */
class AvaliadorTest extends TestCase
{

    /**
     *
     * @var Avaliador
     */
    private $avaliador;

    private $joao;

    private $pedro;

    private $alberto;

    private $leilao;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        // TODO Auto-generated AvaliadorTest::setUp()

        $this->avaliador = new Avaliador();
        $this->joao = new Usuario("João");
        $this->pedro = new Usuario("Pedro");
        $this->alberto = new Usuario("Alberto");
        $this->leilao = new ConstrutorDeLeilao();
        $this->leilao->para("Playstation");
    }

    protected function tearDown()
    {
        $this->avaliador = null;
        $this->joao = null;
        $this->pedro = null;
        $this->alberto = null;

        parent::tearDown();
    }

    /**
     * Tests Avaliador->avalia()
     */
    public function testAvalia()
    {
        $this->leilao->lance($this->joao, 500)
            ->lance($this->pedro, 400)
            ->lance($this->alberto, 900);
        $this->avaliador->avalia($this->leilao->constroi());
        $maiorValor = 900;
        $menorValor = 400;
        $avaliador = $this->avaliador;
        $this->assertEquals($maiorValor, $this->avaliador->getMaiorLance(), 0.00001);
        $this->assertEquals($menorValor, $this->avaliador->getMenorLance(), 0.00001);
        return $avaliador;
    }

    /**
     *
     * @depends testAvalia
     */
    public function testValorMedio(Avaliador $avaliador)
    {
        $valorMedio = 600;
        $this->assertEquals($valorMedio, $avaliador->getValorMedio(), 0.00001);
    }

    public function testLeilaoUmLance()
    {
        $this->leilao->lance($this->alberto, 2000);
        $this->avaliador->avalia($this->leilao->constroi());
        $this->assertEquals(2000, $this->avaliador->getMaiorLance(), 0.00001);
        $this->assertEquals(2000, $this->avaliador->getMenorLance(), 0.00001);
    }

    public function testLeilaoOrdemAleatoria()
    {
        $this->leilao->lance($this->joao, 200)
            ->lance($this->pedro, 450)
            ->lance($this->alberto, 120)
            ->lance($this->joao, 700)
            ->lance($this->pedro, 630)
            ->lance($this->alberto, 230);
        $this->avaliador->avalia($this->leilao->constroi());
        $maiorValor = 700;
        $menorValor = 120;
        $avaliador = $this->avaliador;
        $this->assertEquals($maiorValor, $this->avaliador->getMaiorLance(), 0.00001);
        $this->assertEquals($menorValor, $this->avaliador->getMenorLance(), 0.00001);
    }

    public function testLeilaoOrdemDescrecente()
    {
        $this->leilao->lance($this->joao, 700)
            ->lance($this->pedro, 630)
            ->lance($this->pedro, 450)
            ->lance($this->alberto, 230);
        $this->avaliador->avalia($this->leilao->constroi());
        $maiorValor = 700;
        $menorValor = 230;
        $this->assertEquals($maiorValor, $this->avaliador->getMaiorLance(), 0.00001);
        $this->assertEquals($menorValor, $this->avaliador->getMenorLance(), 0.00001);
    }

    public function testPegaOsTresMaiores()
    {
        $this->leilao->lance($this->joao, 200)
            ->lance($this->pedro, 450)
            ->lance($this->alberto, 120)
            ->lance($this->joao, 700)
            ->lance($this->pedro, 630)
            ->lance($this->alberto, 230);
        $this->avaliador->avalia($this->leilao->constroi());
        $this->assertEquals(3, count($this->avaliador->getMaiores()));
        $this->assertEquals(700, $this->avaliador->getMaiores()[0]->getValor());
        $this->assertEquals(630, $this->avaliador->getMaiores()[1]->getValor());
        $this->assertEquals(450, $this->avaliador->getMaiores()[2]->getValor());
    }

    public function testLeilaoDoisLances()
    {
        $this->leilao->lance($this->joao, 700)->lance($this->pedro, 630);
        $this->avaliador->avalia($this->leilao->constroi());
        $this->assertEquals(2, count($this->avaliador->getMaiores()));
        $this->assertEquals(700, $this->avaliador->getMaiores()[0]->getValor());
        $this->assertEquals(630, $this->avaliador->getMaiores()[1]->getValor());
    }

    /**
     *
     * @expectedException InvalidArgumentException
     */
    public function testLeilaoSemLances()
    {
        $this->avaliador->avalia($this->leilao->constroi());
    }
}

