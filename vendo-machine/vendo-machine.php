<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendo Machine</title>
</head>
<body>
    <div class="container">
        <h2>Vendo Machine</h2>
        <form method="POST">

            <fieldset class="fset">
                <legend>Products:</legend>             
                <input type="checkbox" name="products[]" value="Root beer,10"> Root beer - ₱10<br>
                <input type="checkbox" name="products[]" value="R.C,15"> R.C - ₱15<br>
                <input type="checkbox" name="products[]" value="7.UP,12"> 7.UP - ₱12<br>
                <input type="checkbox" name="products[]" value="Fanta,15"> Fanta - ₱15<br>
                <input type="checkbox" name="products[]" value="Mirinda,20"> Mirinda - ₱20<br>
            </fieldset>

            <fieldset class="fset">
                <legend>Options:</legend>
                <label for="size">Size: </label>
                <select name="size">
                    <option value="Regular,0">Regular</option>
                    <option value="Upsize,5">Upsize (add ₱5)</option>
                    <option value="Jumbo,10">Jumbo (add ₱10)</option>
                </select>

                <label for="quantity">Quantity: </label>
                <input type="number" name="quantity" id="quantity" value="0" min="0">
                <button type="submit" name="checkout">CheckOut</button>
            </fieldset>
        </form>

        <?php
        session_start();

        if (isset($_POST['checkout'])) {
            // Initialize variables
            $products = isset($_POST['products']) ? $_POST['products'] : [];
            $sizeDetails = isset($_POST['size']) ? explode(",", $_POST['size']) : ['Regular', 0];
            $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

            $sizeName = $sizeDetails[0];
            $sizeSurcharge = intval($sizeDetails[1]);

            $totalCost = 0;
            $selectedProducts = [];

            // Calculate the total cost of selected products
            foreach ($products as $product) {
                list($productName, $productPrice) = explode(",", $product);
                $selectedProducts[] = $productName;
                $totalCost += intval($productPrice);
            }

            // Apply quantity and size surcharge
            $totalCost = ($totalCost + $sizeSurcharge) * $quantity;

            // Store order summary in session
            if (count($selectedProducts) > 0 && $quantity > 0) {
                $_SESSION['order'][] = [
                    'products' => $selectedProducts,
                    'size' => $sizeName,
                    'quantity' => $quantity,
                    'totalCost' => $totalCost
                ];
            } else {
                echo "<hr><b>No products selected or invalid quantity. Please try again.</b>";
            }
        }

        // Display all orders from the session
        if (isset($_SESSION['order']) && count($_SESSION['order']) > 0) {
            echo "<hr><b>Order Summary History:</b><br>";
            foreach ($_SESSION['order'] as $index => $order) {
                echo "<b>Order " . ($index + 1) . ":</b><br>";
                echo "Products: " . implode(", ", $order['products']) . "<br>";
                echo "Size: " . htmlspecialchars($order['size']) . "<br>";
                echo "Quantity: " . $order['quantity'] . "<br>";
                echo "Total Cost: ₱" . $order['totalCost'] . "<br><br>";
            }
        }
        ?>

        <?php if (isset($_SESSION['order']) && count($_SESSION['order']) > 0): ?>
            <form method="POST">
                <button type="submit" name="newOrder">New Order</button>
            </form>
        <?php endif; ?>

        <?php
        // Handle "New Order" button click
        if (isset($_POST['newOrder'])) {
            session_destroy();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
        ?>
    </div>
</body>
</html>
