<?php

namespace AppBundle\Service\Import;

class ParserFactory
{
    public static function getParser(string $filePath): ParserInterface
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $parser = null;
        switch ($extension) {
            case 'csv':
                $parser = new CsvParser();
                break;

            default:
                throw new \InvalidArgumentException('There are no parser for extension ' . $extension);
        }
        return $parser;
    }
}