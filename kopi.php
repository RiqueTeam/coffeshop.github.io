<?php
/* to calculate the amount to paid by customer of a coffee shop*/

// Associative array of coffee menu items
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
$order_details = array();

if(isset($_POST['btnChoose'])) {
    // Check if any coffee was selected
    if(isset($_POST['coffee1'])) {
        $selected_coffees = $_POST['coffee1'];
        $quantities = $_POST['quantity'];
        
        // Process each selected coffee
        foreach($selected_coffees as $coffee_name) {
            // Get the quantity for this coffee (default to 1 if not set)
            $qty = isset($quantities[$coffee_name]) ? intval($quantities[$coffee_name]) : 1;
            if($qty < 1) $qty = 1; // Ensure at least 1
            
            $price = $coffee[$coffee_name] * $qty;
            $order_details[] = array(
                'name' => $coffee_name,
                'quantity' => $qty,
                'price' => $price,
                'unit_price' => $coffee[$coffee_name]
            );
            $tot += $price;
        }
    }
}
?>

<html>
    <head>
        <title>Coffee Shop Order</title>
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f5f5f5;
                margin: 0;
                padding: 20px;
                color: #333;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
                background: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0,0,0,0.1);
            }
            h1 {
                color: #6f4e37;
                text-align: center;
                border-bottom: 2px solid #6f4e37;
                padding-bottom: 10px;
            }
            .menu-item {
                display: flex;
                justify-content: space-between;
                margin-bottom: 15px;
                padding: 10px;
                background: #f9f9f9;
                border-radius: 5px;
                border-left: 4px solid #6f4e37;
            }
            .coffee-name {
                font-weight: bold;
                color: #6f4e37;
            }
            .coffee-price {
                color: #888;
            }
            .quantity-input {
                width: 60px;
                padding: 5px;
                border: 1px solid #ddd;
                border-radius: 3px;
                text-align: center;
            }
            .submit-btn {
                background-color: #6f4e37;
                color: white;
                border: none;
                padding: 12px 20px;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
                display: block;
                margin: 20px auto;
                transition: background-color 0.3s;
            }
            .submit-btn:hover {
                background-color: #5a3e2a;
            }
            .order-summary {
                margin-top: 30px;
                padding: 20px;
                background: #f9f9f9;
                border-radius: 5px;
            }
            .order-item {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
                padding-bottom: 10px;
                border-bottom: 1px dashed #ddd;
            }
            .total-row {
                font-weight: bold;
                font-size: 18px;
                color: #6f4e37;
                margin-top: 10px;
                padding-top: 10px;
                border-top: 2px solid #6f4e37;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>☕ Coffee Shop Order Form</h1>
            
            <form method="post" name="frmCoffee" action="">
                <h2>Select Your Coffees</h2>
                
                <?php
                foreach($coffee as $name => $price) {
                    echo "<div class='menu-item'>";
                    echo "<div>";
                    echo "<input type='checkbox' name='coffee1[]' value='$name' id='$name'>";
                    echo "<label for='$name' class='coffee-name'>$name</label>";
                    echo " <span class='coffee-price'>(RM " . number_format($price, 2) . ")</span>";
                    echo "</div>";
                    echo "<div>";
                    echo "Quantity: <input type='number' name='quantity[$name]' value='1' min='1' max='10' class='quantity-input'>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
                
                <input type="submit" name="btnChoose" value="Calculate Total" class="submit-btn">
                
                <?php
                if(isset($_POST['btnChoose'])) {
                    if(!empty($order_details)) {
                        echo "<div class='order-summary'>";
                        echo "<h2>Order Summary</h2>";
                        
                        foreach($order_details as $item) {
                            echo "<div class='order-item'>";
                            echo "<div>{$item['quantity']} x {$item['name']} (RM " . number_format($item['unit_price'], 2) . ")</div>";
                            echo "<div>RM " . number_format($item['price'], 2) . "</div>";
                            echo "</div>";
                        }
                        
                        echo "<div class='order-item total-row'>";
                        echo "<div>Total Amount:</div>";
                        echo "<div>RM " . number_format($tot, 2) . "</div>";
                        echo "</div>";
                        echo "</div>";
                    } else {
                        echo "<p style='color: #d32f2f; text-align: center;'>Please select at least one coffee.</p>";
                    }
                }
                ?>
            </form>
        </div>
    </body>
</html>