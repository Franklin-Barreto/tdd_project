<?php
namespace App\Model;

class AnoBissexto
{

    public function ehBissexto($ano)
    {
        if (($ano % 400 == 0) or ($ano % 4 == 0) and ($ano % 100 != 0)) {
            return true;
        } else {
            return false;
        }
    }
}

