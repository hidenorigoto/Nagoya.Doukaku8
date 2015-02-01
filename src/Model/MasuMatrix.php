<?php
namespace Nagoya\Dk8\Model;

class MasuMatrix
{
    private $data;
    private $width = 0;
    private $result = 0;

    /**
     * build objects
     *
     * @param $inputArray
     */
    public function build($inputArray)
    {
        $this->data = $inputArray;

        $rowIndex = 0;
        $this->width = count($inputArray);
        foreach ($inputArray as $row) {
            $colIndex = 0;
            foreach ($row as $col) {
                $masu = new Masu($row[$colIndex], $rowIndex . $colIndex);
                $this->data[$rowIndex][$colIndex] = $masu;
                $colIndex++;
            }
            $rowIndex++;
        }

        $rowIndex = 0;
        $this->width = count($inputArray);
        foreach ($inputArray as $row) {
            $colIndex = 0;
            foreach ($row as $col) {
                $masu = $this->data[$rowIndex][$colIndex];

                // collect neightbors
                if (null !== ($neightbor = $this->get($rowIndex - 1, $colIndex)))
                {
                    $masu->addNeighbor($neightbor);
                }
                if (null !== ($neightbor = $this->get($rowIndex, $colIndex - 1)))
                {
                    $masu->addNeighbor($neightbor);
                }
                if (null !== ($neightbor = $this->get($rowIndex + 1, $colIndex)))
                {
                    $masu->addNeighbor($neightbor);
                }
                if (null !== ($neightbor = $this->get($rowIndex, $colIndex + 1)))
                {
                    $masu->addNeighbor($neightbor);
                }
                $colIndex++;
            }
            $rowIndex++;
        }
    }

    /**
     * execute evaluation
     */
    public function evaluate()
    {
        $this->result = 0;
        array_walk_recursive($this->data, function($masu) {
            $temp = $masu->evaluate();
            $this->result = max($this->result,$temp);
        });
    }

    /**
     * get result
     *
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param $row
     * @param $col
     * @return Masu|null
     */
    public function get($row, $col)
    {
        if ($row < 0 || $row >= $this->width) return null;
        if ($col < 0 || $col >= $this->width) return null;

        return $this->data[$row][$col];
    }
}