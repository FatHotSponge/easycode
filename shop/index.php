<link href="Bd/style.css" rel="stylesheet">

   	<form size="centre" method="GET" action="Check_price.php">
    	<?php print("Для продолжения работы введите наименование товара!");?></br> 
        Prosuct name: <input name="Product_name" id='Product_name' /> <br /> 
        Product Category: <select name="product_category">
		    <option value="food">food</option>
			<option value="clouthes">clouthes</option>
			<option value="ather">ather</option>
		</select>  
		<br />
		Prosuct Cost: <input  name="product_cost" id = "product_cost" />
		<br />
		<input class="design" type="submit" value="Go?" />
		<input class="design" type="reset" value="Очистить" />
    </form>
   			 <p><a href="all_price.php" class="design">весь прайс</a>
