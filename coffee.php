<?php

/* to calculate the amount to paid by customer of a coffee shop*/

//write an associative array that consist of 7 menu of coffee

$coffee = array("Hazelnut" => 8.80, "Americano"=> 12.50, "Latte"=>13, "Matcha"=>10.90, "Capuccino"=> 11,
				"Mocha"=>7, "Espresso"=> 15);
$paidPrice = 0;

if(isset($_POST['btnChoose']))
{
	//retrive value 	
	$myquantity = $_POST['kuantiti'];
		
	/*Now mycoffee is selected coffee menu from user 
	become the indexed array*/
	if(isset($_POST['coffee1']))
	{
		$ChoosenCoffee = $_POST['coffee1'];
		foreach($ChoosenCoffee as $a => $b)
		{
		
		$qty = isset($myquantity[$a]) ? intval($myquantity[$a]) : 1;
			
		//to set the price according to coffee array (associative arry)
		$hCoffee = $coffee[$b];
		
		//get the price of coffee multiply with quantity 
		$tPrice = $hCoffee * $qty;
		
		//echo $tPrice;
		//get harga keseluruhan
		$paidPrice = $paidPrice + $tPrice;
		}
	}
	else
	{
		echo "please select at least a menu";
	}
	
}

?>

<html>
	<head>
		<title> </title>
	</head>
	<body>
		<table>
		<form method="post" name="frmCoffee" action="">
			<tr>
				<td> Choose Your Coffee </td>
				<td> 
				
				<?php
				$defaultKey =0;
				foreach($coffee as $index => $value)
				{
					$status = in_array($coffee,$ChoosenCoffee)? "checked": "";
					echo "<input type='checkbox' name='coffee1[$defaultKey]' value='$index' $status >
					$index (RM$value)";
						
					echo " Quantity : <input type='number' name='kuantiti[$defaultKey]' 
					value='' min='1' max='20'  >
					<br>";
					$defaultKey++;	
					}
				
				?>

				</td>
			</tr>
			<tr>
				<td> </td>
				<td> 
				<input type="submit" name="btnChoose" value="Get Price"> <br>
				<?php echo "Price to Pay:".$paidPrice; ?>
				</td>
			</tr>
			</form>
		</table>
	</body>
</html>