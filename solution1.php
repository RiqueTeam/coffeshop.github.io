<?php
$coffee = array("Hazelnut" => 8.80, "Americano"=> 12.50, "Latte"=>13, "Matcha"=>10.90, "Capuccino"=> 11,
                "Mocha"=>7, "Espresso"=> 15);
$paidPrice = 0;

if(isset($_POST['btnChoose']))
{
    if(isset($_POST['coffee1']))
    {
        $ChoosenCoffee = $_POST['coffee1'];
        // Use the same index for both coffee and quantity
        foreach($ChoosenCoffee as $index => $coffeeName)
        {
            $qty = isset($_POST['kuantiti'][$index]) ? intval($_POST['kuantiti'][$index]) : 1;
            $hCoffee = $coffee[$coffeeName];
            $tPrice = $hCoffee * $qty;
            $paidPrice += $tPrice;
			
			// Store selected coffees to mark them as checked
            $selectedCoffees[$coffeeName] = $qty;
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
    <title>Coffee Shop</title>
</head>
<body>
    <table>
    <form method="post" name="frmCoffee" action="">
        <tr>
            <th>Coffee</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>
        <?php
        $index = 0;
        foreach($coffee as $coffeeName => $price)
        {
			$status = in_array($coffeeName,$ChoosenCoffee)? "checked": "";
            $quantityValue = $status ? $selectedCoffees[$coffeeName] : 1;
			echo "<tr>";
            echo "<td><input type='checkbox' name='coffee1[$index]' value='$coffeeName' $status></td>";
            echo "<td>$coffeeName (RM$price)</td>";
            echo "<td><input type='number' name='kuantiti[$index]' value='$quantityValue' min='1' max='20'></td>";
            echo "</tr>";
            $index++;
        }
        ?>
        <tr>
            <td colspan="3">
                <input type="submit" name="btnChoose" value="Get Price"> <br>
                <?php echo "Price to Pay: RM " . number_format($paidPrice, 2); ?>
            </td>
        </tr>
    </form>
    </table>
</body>
</html>