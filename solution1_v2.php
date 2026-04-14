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
            background-color: #f5e9d7;
            color: #3e2723;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }
        h1 {
            text-align: center;
            color: #5d4037;
            margin-top: 0;
        }
        .coffee-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #d7ccc8;
        }
        .coffee-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 10px;
            background-color: #f9f5f0;
            border-radius: 8px;
            transition: background-color 0.3s;
        }
        .coffee-item:hover {
            background-color: #f3e5d2;
        }
        .coffee-name {
            font-weight: 600;
            flex: 2;
        }
        .coffee-price {
            color: #795548;
            font-weight: 500;
            flex: 1;
            text-align: right;
            padding-right: 15px;
        }
        .quantity-input {
            width: 70px;
            padding: 8px;
            border: 1px solid #d7ccc8;
            border-radius: 4px;
            text-align: center;
        }
        .submit-btn {
            background-color: #6d4c41;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            display: block;
            margin: 25px auto 15px;
            transition: background-color 0.3s;
        }
        .submit-btn:hover {
            background-color: #5d4037;
        }
        .total-price {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #5d4037;
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f5f0;
            border-radius: 8px;
        }
        .header-image {
            text-align: center;
            margin-bottom: 20px;
        }
        .coffee-icon {
            font-size: 24px;
            margin-right: 10px;
            color: #795548;
        }
        .instructions {
            text-align: center;
            color: #795548;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>☕ Coffee Shop Order</h1>
        
        <div class="instructions">
            <p>Select your coffee and quantity, then click "Calculate Total"</p>
        </div>

        <form method="post" name="frmCoffee" action="">
            <div class="coffee-header">
                <div class="coffee-name">Coffee Type</div>
                <div class="coffee-price">Price (RM)</div>
                <div>Quantity</div>
            </div>
            
            <?php
            $coffee = array(
                "Hazelnut" => 8.80, 
                "Americano" => 12.50, 
                "Latte" => 13, 
                "Matcha" => 10.90, 
                "Capuccino" => 11,
                "Mocha" => 7, 
                "Espresso" => 15
            );
            
            $paidPrice = 0;
            $selectedCoffees = array();
            
            if(isset($_POST['btnChoose'])) {
                if(isset($_POST['coffee1'])) {
                    $ChoosenCoffee = $_POST['coffee1'];
                    $quantities = $_POST['kuantiti'];
                    
                    foreach($ChoosenCoffee as $index => $coffeeName) {
                        $qty = isset($quantities[$index]) ? intval($quantities[$index]) : 1;
                        $hCoffee = $coffee[$coffeeName];
                        $tPrice = $hCoffee * $qty;
                        $paidPrice += $tPrice;
                        
                        // Store selected coffees to mark them as checked
                        $selectedCoffees[$coffeeName] = $qty;
                    }
                } else {
                    echo "<div style='color: #d32f2f; text-align: center; margin: 15px 0;'>Please select at least one coffee</div>";
                }
            }
            
            // Display coffee options
            $index = 0;
            foreach($coffee as $coffeeName => $price) {
                $isChecked = array_key_exists($coffeeName, $selectedCoffees) ? "checked" : "";
                $quantityValue = $isChecked ? $selectedCoffees[$coffeeName] : 1;
                
                echo "<div class='coffee-item'>";
                echo "<div class='coffee-name'>";
                echo "<input type='checkbox' name='coffee1[$index]' value='$coffeeName' $isChecked >";
                echo " <span class='coffee-icon'>☕</span> $coffeeName";
                echo "</div>";
                echo "<div class='coffee-price'>RM " . number_format($price, 2) . "</div>";
                echo "<div>";
                echo "<input type='number' class='quantity-input' name='kuantiti[$index]' value='$quantityValue' min='1' max='20'>";
                echo "</div>";
                echo "</div>";
                
                $index++;
            }
            ?>
            
            <button type="submit" class="submit-btn" name="btnChoose">Calculate Total</button>
            
            <?php
            if($paidPrice > 0) {
                echo "<div class='total-price'>Total Price: RM " . number_format($paidPrice, 2) . "</div>";
            }
            ?>
        </form>
    </div>

    <script>
        // Add interactivity to make checkboxes easier to select
        document.querySelectorAll('.coffee-item').forEach(item => {
            item.addEventListener('click', function(e) {
                // Don't toggle if the click was on the quantity input
                if (e.target.type !== 'number' && e.target.type !== 'checkbox') {
                    const checkbox = this.querySelector('input[type="checkbox"]');
                    checkbox.checked = !checkbox.checked;
                    
                    // Focus on quantity input when selected
                    if (checkbox.checked) {
                        const quantityInput = this.querySelector('input[type="number"]');
                        quantityInput.focus();
                        quantityInput.select();
                    }
                }
            });
        });
    </script>
</body>
</html>