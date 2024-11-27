<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>peys-app</title>
</head>
<body>
<?php

// Set default values
$size = isset($_POST['size']) && is_numeric($_POST['size']) ? intval($_POST['size']) : 60; 
$borderColor = isset($_POST['borderColor']) ? $_POST['borderColor'] : '#000000';  

$canvasWidth = $size;
$canvasHeight = $size;

?>

<form id="settingsForm" method="post">

    <label for="size">Select Photo Size:</label>
    <input type="range" id="sizeSlider" name="size" min="100" max="200" value="<?php echo htmlspecialchars($size); ?>" step="10"
        oninput="this.nextElementSibling.value = this.value">
    <output><?php echo htmlspecialchars($size); ?></output>
    
    <br><br>

    <label for="borderColor">Select Border Color:</label>
    <input type="color" id="borderColor" name="borderColor" value="<?php echo htmlspecialchars($borderColor); ?>">
    <br><br>

    <button type="submit" name="submit">Process</button>
    <br><br>

    <img id="sourceImage" src="pic.jpg" alt="Image for Canvas" hidden>

    <div
        style="border:3px solid <?php echo htmlspecialchars($borderColor); ?>; width: <?php echo $canvasWidth; ?>px; height: <?php echo $canvasHeight; ?>px; overflow:hidden;">
        <img src="pic.jpg" alt="Image for Canvas" width="<?php echo $canvasWidth; ?>"
            height="<?php echo $canvasHeight; ?>">
    </div>

</form>

</body>
</html>