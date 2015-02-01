<?php
namespace Nagoya\Dk8;

use Nagoya\Dk8\Model\MasuMatrix;

class Dk8
{
    /**
     * solve problem
     *
     * @param $input
     * @return int
     */
    public function solve($input) {
        $parsedInput = $this->parse($input);

        $matrix = new MasuMatrix();
        $matrix->build($parsedInput);
        $matrix->evaluate();

        return $matrix->getResult();
    }

    /**
     * parse input string
     *
     * @param $input
     * @return array
     */
    public function parse($input)
    {
        return array_map(function($row) {
            return str_split($row);
        }, explode('/', $input));
    }
}
