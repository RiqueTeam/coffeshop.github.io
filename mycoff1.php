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