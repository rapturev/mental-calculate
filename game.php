<?php
//some kind of a Builder pattern implementation
//
//

echo "hello, user. this is your mental calculating trainer\n";

$director = new Director();
$director->chooseDifficultyAndStart();

//preparation process and start
//
//game difficulty choice
//
//start mind training
class Director {

    public function chooseDifficultyAndStart() {

        $builder = new ItemBuilder();
        global $difficultyMode;
        echo "please choose a difficulty level by entering a number: 1, 2 or 3\n";
        $difficultyLevel = readline();
        switch($difficultyLevel) {
            case '1':
                $builder->build(9);
                break;
            case '2':
                $builder->build(99);
                break;
            case '3':
                $builder->build(999);
                break;
            default:
                $this->chooseDifficultyAndStart();
        }
    }
}

//ItemBuilder is a creator of "items" - single math exercises
class ItemBuilder {

    //generating of plus, minus etc.
    public function generateOperation()
    {
        global $firstValue;
        global $secondValue;
        global $operation;
        global $resultValue;
        $opCode = rand(0, 3);
        switch($opCode) {
            case 0:
                $operation = "+";
                $resultValue = $firstValue + $secondValue;
                break;
            case 1:
                if ($firstValue > $secondValue) {
                    $operation = "-";
                    $resultValue = $firstValue - $secondValue;
                } else {
                    $this->generateOperation();
                }
                break;
            case 2:
                $operation = "*";
                $resultValue = $firstValue * $secondValue;
                break;
            case 3:
                if ($firstValue % $secondValue == 0) {
                    $operation = "/";
                    $resultValue = $firstValue / $secondValue;
                    break;
                } else {
                    $this->generateOperation();
                }
        }
    }

    //item creating
    //
    //generating of number values
    public function build($randRange) {

        global $firstValue;
        global $secondValue;
        global $operation;
        global $resultValue;
        $firstValue = rand(1, $randRange);
        $secondValue = rand(1, $randRange);
        $this->generateOperation();
        $item = new Item($firstValue, $secondValue, $operation, $resultValue);
        $answer = readline();
        if ($answer == $item->resultValue) {
            echo "right\n";
        } else {
            echo "wrong\n";
        }
        $this->build($randRange);
    }
}

//blueprint of a math exercise object
class Item {

    public $firstValue;
    public $secondValue;
    public $operation;
    public $resultValue;
    function __construct($firstValue, $secondValue, $operation, $resultValue) {

        $this->firstValue = $firstValue;
        $this->secondValue = $secondValue;
        $this->operation = $operation;
        $this->resultValue = $resultValue;
        echo "$firstValue $operation $secondValue\n";
    }
}