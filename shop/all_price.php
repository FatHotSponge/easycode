
<?php
require_once 'Check_lib.php';
class Price {
  public $product_name;
  public $product_price;
 
  public function product_name()
  {
    return $this->product_name;
  }
  public function product_price()
  {
    return $this->product_price;
  }
  public function product_category()
  {
  	return $this->product_category;
  }
}


$pdo = new PDO('mysql:host=localhost;dbname=price', 'root', '');
$pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 



  $data = $pdo->query('SELECT id FROM price')->fetchAll(PDO::FETCH_COLUMN);

  $cont = count($data);

    $result = $pdo->query('SELECT * FROM price order by id desc limit '. $cont. '');


  	$result->setFetchMode(PDO::FETCH_CLASS, 'Price');
 	
  	

all_price($result);
?>
 <p><a href="index.php" class="design">ещё?</a>