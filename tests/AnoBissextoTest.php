<?php
use PHPUnit\Framework\TestCase;
use App\Model\AnoBissexto;

class AnoBissextoTest extends TestCase
{

    public function testEhBissexto()
    {
        $ano = new AnoBissexto();
        $this->assertEquals(true, $ano->ehBissexto(2000));
        $this->assertEquals(false, $ano->ehBissexto(2014));
    }
}