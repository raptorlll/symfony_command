<?php

namespace AppBundle\Service\Import\Mode;

use AppBundle\Service\Import\ImportProducts;

class ModeFactory
{
    public static function getMode(string $modeString): ModeInterface
    {
        $mode = null;
        switch ($modeString) {
            case ImportProducts::MODE_TEST:
                $mode = new ModeTest();
                break;
            case ImportProducts::MODE_PRODUCTION:
                $mode = new ModeProduction();
                break;

            default:
                throw new \InvalidArgumentException('There are no such mode '.$modeString);
        }
        return $mode;
    }
}