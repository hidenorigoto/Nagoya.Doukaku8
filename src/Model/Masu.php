<?php
namespace Nagoya\Dk8\Model;

class Masu
{
    /**
     * @var string
     */
    private $index;

    /**
     * @var integer
     */
    private $number;

    /**
     * @var Masu[]
     */
    private $fromNeighbors = [];

    private $evaluated = false;
    private $evaluatedValue = 0;

    public function __construct($number, $index)
    {
        $this->index = $index;
        $this->number = $number;
    }

    /**
     * @param Masu $masu
     */
    public function addNeighbor(Masu $masu)
    {
        if ($this->isFrom($masu)) {
            $this->fromNeighbors[] = $masu;
        }
    }

    /**
     * @param Masu $target
     * @return bool
     */
    public function equalTo(Masu $target)
    {
        return $this->index == $target->index;
    }

    /**
     * @param Masu $target
     * @return bool
     */
    public function isFrom(Masu $target)
    {
        if ($this->number > $target->number) return true;
    }

    /**
     * execute evaluation
     *
     * @return int
     */
    public function evaluate()
    {
        if ($this->evaluated) return $this->evaluatedValue;

        if (count($this->fromNeighbors) > 0) {
            $values = [];
            foreach ($this->fromNeighbors as $masu) {
                $values[] = $masu->evaluate();
            }
            $this->evaluatedValue = max($values) + 1;
        } else {
            $this->evaluatedValue = 1;
        }

        $this->evaluated = true;

        return $this->evaluatedValue;
    }
}
