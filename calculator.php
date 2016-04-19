<?php

require_once 'iCalculator.php';

class Calculator implements iCalculator
{
  public function plus($a = 0, $b = 0){
  	return $a + $b;
  }
  public function minus($a = 0, $b = 0){
  	return $a - $b;
  }
  public function divide($a = 0, $b = 0){
    return $b; // ?
  }
  public function multiply($a, $b){
  	return $a * $b;
  }
}

$calculator = new Calculator();
$calculator->plus(1, 2); // 3
