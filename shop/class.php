<?

class Price {
  public $product_name;
  public $product_price;
  public $product_category;
 
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