<?php
/**
 * Created by PhpStorm.
 * User: p.leonov
 * Date: 5.9.17
 * Time: 10.07
 */

namespace AppBundle\Service\Import;


interface ParserInterface
{
    // parse file line by line
    public function parse(string $path);
    // add observer to the new line parse event
    public function addObserver($observer);
    // notify observers
    public function notify(array $columns);
}