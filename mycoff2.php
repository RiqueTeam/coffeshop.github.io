<?php
/* to calculate the amount to paid by customer of a coffee shop*/

// Associative array of coffee menu
$coffee = array(
    "Hazelnut" => 8.80, 
    "Americano" => 12.50, 
    "Latte" => 13, 
    "Matcha" => 10.90, 
    "Capuccino" => 11,
    "Mocha" => 7, 
    "Espresso" => 15
);

$tot = 0;
$selected_coffees = array();

if(isset($_POST['btnChoose'])) {
    // Retrieve selected coffees and quantities
    if(isset($_POST['coffee1'])) {
        $selected_coffees = $_POST['coffee1'];
        $quantities = $_POST['kuantiti'];
        
        // Calculate total
        foreach($selected_coffees as $index => $coffee_name) {
            $quantity = isset($quantities[$index]) ? max(1, intval($quantities[$index])) : 1;
            $price = $coffee[$coffee_name];
            $subtotal = $price * $quantity;
            $tot += $subtotal;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop Order</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #6f4e37;
            text-align: center;
            margin-top: 0;
        }
        .menu-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
        .coffee-name {
            font-weight: bold;
            color: #333;
        }
        .coffee-price {
            color: #6f4e37;
            font-weight: bold;
        }
        .quantity-input {
            width: 60px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
        }
        .submit-btn {
            background-color: #6f4e37;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 20px auto;
            transition: background-color 0.3s;
        }
        .submit-btn:hover {
            background-color: #5a3e2a;
        }
        .total-section {
            text-align: center;
            font-size: 20px;
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .total-amount {
            color: #6f4e37;
            font-weight: bold;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .coffee-icon {
            font-size: 24px;
            margin-right: 10px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>☕ Coffee Shop Order</h1>
            <p>Select your favorite coffees and quantities</p>
        </div>
        
        <form method="post" name="frmCoffee" action="">
            <table style="width: 100%;">
                <?php
                foreach($coffee as $name => $price) {
                    $checked = "";
                    $quantity_value = 1;
                    
                    // Check if this coffee was selected
                    if(isset($_POST['btnChoose']) && isset($_POST['coffee1']) && in_array($name, $selected_coffees)) {
                        $checked = "checked";
                        // Find the quantity for this coffee
                        $index = array_search($name, $selected_coffees);
                        if(isset($_POST['kuantiti'][$index])) {
                            $quantity_value = htmlspecialchars($_POST['kuantiti'][$index]);
                        }
                    }
                    
                    echo '<tr class="menu-item">';
                    echo '<td>';
                    echo "<input type='checkbox' name='coffee1[]' value='$name' $checked >";
                    echo "<span class='coffee-name'>$name</span>";
                    echo "</td>";
                    echo "<td class='coffee-price'>RM " . number_format($price, 2) . "</td>";
                    echo "<td>Quantity: <input type='number' class='quantity-input' name='kuantiti[]' value='$quantity_value' min='1' max='10'></td>";
                    echo '</tr>';
                }
                ?>
            </table>
            
            <input type="submit" class="submit-btn" name="btnChoose" value="Calculate Total">
            
            <?php 
            if(isset($_POST['btnChoose'])) {
                echo "<div class='total-section'>";
                echo "Total to Pay: <span class='total-amount'>RM " . number_format($tot, 2) . "</span>";
                echo "</div>";
            }
            ?>
        </form>
    </div>
</body>
</html>