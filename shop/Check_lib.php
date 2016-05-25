<link href="Bd/style.css" rel="stylesheet">
<?php

require_once 'db.php';
function check_length($value = "", $min, $max) {
    $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
    return !$result;
}
function check_and_write($name, $cost, $category){
if(!empty($name) && !empty($cost))  {
    if(check_length($name, 3, 50) && (is_numeric ($cost))){
    	echo 'Вы ввели данные:';
        echo 'Product name: '. $name;
        echo '<br />' ;
        echo 'Category: '. $category;
        echo '<br />';
        echo 'Product cost: '. $cost . 'грн';
          addDb($name, $cost, $category);
        echo '<p><a href="all_price.php" class="design">весь прайс</a>';
    } else {
        echo '<title> лузер </title>';
        require_once 'index.php';
        echo "Введенные данные некорректные или не верен формат числа!";
    }
} else {
    echo '<title> лузер </title>';
    require_once 'index.php';
    echo "Заполните пустые поля!";
}
}

function all_price($result){
     while($price = $result->fetch()){
		echo '<table border align="center" cellpadding="10" border="1" width="80%">';
	  		echo '<tr>';
			  	echo '<th> имя </th>';
			  	echo '<th> стоимость </th>';
			  	echo '<th> категория </th>';
	    	echo '</tr>';
     		echo '<tr>';
			    echo '<td  align="center" >'. $price->product_name() .'</td>';
			    
			    echo '<td  align="center" >'. $price->product_price() . '</td>';
			    
			    echo '<td  align="center" >'. $price->product_category . '</td>';
		    echo '</tr>';

   		echo '</table>';	
	}
}
?>
