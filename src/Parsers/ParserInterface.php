<?php

namespace Searchmetrics\Parsers;

/**
 * Interface ParserInterface
 * @package Searchmetrics\Parsers
 */
interface ParserInterface
{

    /**
     * Parse a response form the Searchmetrics API.
     *
     * @return mixed
     *   A parsed array containing relevant data.
     */
    public function parse();

}
