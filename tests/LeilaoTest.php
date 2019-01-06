<?php
use PHPUnit\Framework\TestCase;
use App\Model\Leilao;
use App\Model\Lance;
use App\Model\Usuario;
use App\Model\ConstrutorDeLeilao;

/**
 * Leilao test case.
 */
class LeilaoTest extends TestCase
{

    /**
     *
     * @var Leilao
     */
    private $leilao;

    private $franklin;

    private $joao;

    private $debora;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->leilao = new ConstrutorDeLeilao();
        $this->franklin = new Usuario('Franklin');
        $this->joao = new Usuario("João");
        $this->debora = new Usuario("Débora");
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated LeilaoTest::tearDown()
        $this->leilao = null;
        $this->franklin = null;
        $this->joao = null;
        $this->debora = null;

        parent::tearDown();
    }

    public function testDeveReceberUmLance()
    {
        $this->leilao->para("Playstation")
            ->lance($this->franklin, 2000.0)
            ->constroi();
        $this->assertEquals(1, count($this->leilao->getLances()));
    }

    public function testDeveReceberVariosLances()
    {
        $this->leilao->para("Playstation")
            ->lance($this->franklin, 2000.0)
            ->lance($this->joao, 3000.0)
            ->lance($this->debora, 4000.0)
            ->constroi();
        $this->assertEquals(3, count($this->leilao->getLances()));
    }

    public function testNaoDeveAceitarDoisLancesSeguidosDoMesmoUsuario()
    {
        $this->leilao->para("Playstation")
            ->lance($this->franklin, 2000.0)
            ->lance($this->franklin, 3000.0)
            ->constroi();
        $this->assertEquals(1, count($this->leilao->getLances()));
        $this->assertEquals(2000, $this->leilao->getLances()[0]->getValor());
    }

    public function testNaoDeveAceitarMaisDoQue5LancesDeUmMesmoUsuario()
    {
        $this->leilao->para("Playstation")
            ->lance($this->franklin, 2000.0)
            ->lance($this->joao, 3000.0)
            ->lance($this->franklin, 4000.0)
            ->lance($this->joao, 5000.0)
            ->lance($this->franklin, 6000.0)
            ->lance($this->joao, 7000.0)
            ->lance($this->franklin, 8000.0)
            ->lance($this->joao, 9000.0)
            ->lance($this->franklin, 10000.0)
            ->lance($this->joao, 11000.0)
            ->lance($this->franklin, 12000.0)
            ->constroi();

        $this->assertEquals(10, count($this->leilao->getLances()));
        $ultimo = count($this->leilao->getLances()) - 1;
        $ultimoLance = $this->leilao->getLances()[$ultimo];
        $this->assertEquals(11000.0, $ultimoLance->getValor(), 0.00001);
    }

    public function testDobraLanceUsuario()
    {
        $this->leilao->para("Playstation")
            ->lance($this->franklin, 1000)
            ->lance($this->joao, 1000)
            ->constroi();
        $this->leilao->dobraLance($this->franklin);
        $this->assertEquals(3, count($this->leilao->getLances()));
        $this->assertEquals(2000, $this->leilao->getLances()[2]->getValor(), 0.00001);
    }

    public function testNaoDeveDobrarCasoNaoHajaLanceAnterior()
    {
        $this->leilao->para("PlayStation")->constroi();
        $this->leilao->dobraLance($this->franklin);

        $this->assertEquals(0, count($this->leilao->getLances()));
    }
}

