<?php

namespace AppBundle\Service\Import\Mode;

abstract class ModeAbstract implements ModeInterface
{
    protected $errorSaved = [];

    protected $successSaved = [];

    public function addErrorSaved(string $errorString = '')
    {
        array_push($this->errorSaved, $errorString);
    }


    public function addSuccessfullySaved(string $successString = '')
    {
        array_push($this->successSaved, $successString);
    }

    /**
     * return statistic about saving
     *
     * @return string
     */
    public function getSavingInformation(): string
    {
        $countSuccess = count($this->successSaved);
        $countError = count($this->errorSaved);
        $total = $countSuccess + $countError;

        return '--| Total: '.$total.' Success : '.$countSuccess.' Error - '.$countError.' |--';
    }

    public function getErrorInformation() : string {
        $filteredErrors = array_filter($this->errorSaved);

        return implode(PHP_EOL, array_map(function (string $data, int $key){
            return ($key+1).' - '.$data;
        }, $filteredErrors, array_keys($filteredErrors)));
    }

}