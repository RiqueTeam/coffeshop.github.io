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
$orderDetails = array();

if(isset($_POST['btnChoose'])) {
    // Check if any coffee was selected
    if(isset($_POST['coffee1']) && is_array($_POST['coffee1'])) {
        // Retrieve quantities
        $quantities = isset($_POST['kuantiti']) ? $_POST['kuantiti'] : array();
        
        // Process each selected coffee
        foreach($_POST['coffee1'] as $index => $coffeeName) {
            // Get the quantity for this coffee (default to 1 if not provided)
            $qty = isset($quantities[$index]) && is_numeric($quantities[$index]) && $quantities[$index] > 0 
                   ? (int)$quantities[$index] 
                   : 1;
            
            // Get the price from our coffee array
            $price = isset($coffee[$coffeeName]) ? $coffee[$coffeeName] : 0;
            
            // Calculate subtotal for this item
            $subtotal = $price * $qty;
            
            // Add to order details
            $orderDetails[] = array(
                'name' => $coffeeName,
                'price' => $price,
                'quantity' => $qty,
                'subtotal' => $subtotal
            );
            
            // Add to total
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
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #6f4e37;
            text-align: center;
            margin-bottom: 30px;
        }
        .coffee-form {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        .coffee-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #f9f9f9;
        }
        .coffee-item input[type="checkbox"] {
            margin-right: 10px;
        }
        .coffee-info {
            flex-grow: 1;
        }
        .coffee-name {
            font-weight: bold;
            color: #6f4e37;
        }
        .coffee-price {
            color: #888;
        }
        .quantity {
            width: 50px;
            margin-left: 10px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .submit-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #6f4e37;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }
        .submit-btn:hover {
            background-color: #5a3e2b;
        }
        .order-summary {
            margin-top: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .order-total {
            font-weight: bold;
            font-size: 18px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #ddd;
            display: flex;
            justify-content: space-between;
        }
        .no-order {
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>☕ Coffee Shop Order Form</h1>
        
        <form method="post" name="frmCoffee">
            <div class="coffee-form">
                <?php foreach($coffee as $name => $price): ?>
                    <div class="coffee-item">
                        <input type="checkbox" name="coffee1[]" value="<?php echo htmlspecialchars($name); ?>" 
                               id="coffee_<?php echo htmlspecialchars($name); ?>">
                        <div class="coffee-info">
                            <label for="coffee_<?php echo htmlspecialchars($name); ?>" class="coffee-name">
                                <?php echo htmlspecialchars($name); ?>
                            </label>
                            <div class="coffee-price">RM <?php echo number_format($price, 2); ?></div>
                        </div>
                        <input type="number" name="kuantiti[]" class="quantity" 
                               min="1" max="10" value="1" placeholder="Qty">
                    </div>
                <?php endforeach; ?>
            </div>
            
            <button type="submit" name="btnChoose" class="submit-btn">Calculate Total</button>
        </form>
        
        <?php if(isset($_POST['btnChoose'])): ?>
            <div class="order-summary">
                <h2>Order Summary</h2>
                
                <?php if(!empty($orderDetails)): ?>
                    <?php foreach($orderDetails as $item): ?>
                        <div class="order-item">
                            <span><?php echo htmlspecialchars($item['name']); ?> 
                                (<?php echo $item['quantity']; ?> x RM <?php echo number_format($item['price'], 2); ?>)</span>
                            <span>RM <?php echo number_format($item['subtotal'], 2); ?></span>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="order-total">
                        <span>Total to pay:</span>
                        <span>RM <?php echo number_format($tot, 2); ?></span>
                    </div>
                <?php else: ?>
                    <p class="no-order">No coffee selected. Please choose at least one coffee.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>