<?php
use PHPUnit\Framework\TestCase;
use App\Model\Lance;
use App\Model\Usuario;

class LanceTest extends TestCase
{

    /**
     *
     *@expectedException InvalidArgumentException
     */
    public function testLanceIgualZero()
    {
        $lance = new Lance(new Usuario("Franklin"), 0);
    }
}

