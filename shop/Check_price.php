<link href="Bd/style.css" rel="stylesheet">


<?php

require_once 'Check_lib.php';

$name = $_GET['Product_name'];
$category = $_GET['product_category'];
$cost = $_GET['product_cost'];

check_and_write($name, $cost, $category);