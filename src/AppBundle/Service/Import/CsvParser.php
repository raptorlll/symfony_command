<?php
/**
 * Created by PhpStorm.
 * User: p.leonov
 * Date: 5.9.17
 * Time: 10.09
 */

namespace AppBundle\Service\Import;

use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\LexerConfig;

class CsvParser implements ParserInterface
{
    private $observers = [];

    private function configureParser(string $path) : LexerConfig
    {
        $encoding = $this->detectCharset($path);

        $config = new LexerConfig();
        $config
            ->setDelimiter(',')
            ->setEnclosure('\'')
            ->setEscape('\\')
            /**
             * Customize target encoding
             *
             * here potential issue, because table in latin1 charset,
             * so maybe better use latin1
             */
            ->setToCharset('UTF-8')
            ->setIgnoreHeaderLine(true);

        if (!$encoding) {
            /**
             * Implicitly set incoming encoding
             */
            $config->setFromCharset($encoding);
        }

        return $config;
    }

    public function parse(string $path)
    {
        $config = $this->configureParser($path);

        $lexer = new Lexer($config);

        $interpreter = new Interpreter();
        /** Ignore rows unconcistency */
        $interpreter->unstrict();

        $interpreter->addObserver(function (array $columns) {
            $this->notify($columns);
        });
        /**
         * Start parsing line by line
         */
        $lexer->parse($path, $interpreter);
    }

    public function addObserver($observer)
    {
        if (!is_callable($observer)) {
            throw new \InvalidArgumentException('observer must be callable');
        }
        $this->observers[] = $observer;
    }

    /**
     * New line event
     *
     * @param array $columns
     */
    public function notify(array $columns)
    {
        foreach ($this->observers as $observer) {
            call_user_func_array($observer, [$columns]);
        }
    }

    /**
     * Read first line from file and  try detect charset
     *
     * @param string $path
     * @return bool|false|mixed|string
     */
    private function detectCharset(string $path)
    {
        /**
         * Suggest that have UTF-8
         */
        $enc = 'UTF-8';
        $handle = fopen($path, 'r');
        if ($handle) {
            /**
             * Get only first line
             */
            if (($line = fgets($handle)) !== false) {
                $enc = mb_detect_encoding($line, mb_list_encodings(), true);
            }
            fclose($handle);
        }
        return $enc;
    }


}