<?php

function addDb($name, $cost, $category){

$pdo = new PDO('mysql:host=localhost;dbname=price', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    


$sql = 'INSERT INTO price (product_name, product_price, product_category) VALUES(:name, :price, :category)';
$sth=$pdo->prepare($sql);
$sth->bindValue(':name', $name);
$sth->bindValue(':price', $cost);
$sth->bindValue(':category', $category);
$sth->execute();
}

