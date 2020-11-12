<?php

include_once 'assets/src/cocktail.php';

$cocktail = new Cocktail('https://www.thecocktaildb.com/api/json/v1/1/random.php');

if(isset($_GET['vote'])){
    if($_GET['vote'] == 1){
        $cocktail->swipe();
        header('location: index.php');
    
    } 
    
    if($_GET['vote'] == 0) {
    echo "<script>alert('Nope')</script>";
    header('location: index.php');
    }   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/img/logo_cocktail.png">
    <title>Cocktail swipe</title>
</head>
<body>
    <div id="content">
        <a href="index.php?vote=0" id="delete" class="button">-</a>
        <div id="main">
            <div id="car_name">
                <?= $cocktail->name; ?>
                <a href="list.php">List</a>
            </div>
            <div id="car_img">
                <ul>
                    <li><?= $cocktail->alcohol ?></li>
                    <li><?= $cocktail->glas ?></li>
                    <li><br>Ingredients:</li>
                    <?php
                        $y = 0;

                        for($y; $y <= count($cocktail->ingredients)-1; $y++){
                            echo "<li>" . $cocktail->ingredients[$y] . "</li>";
                        }

                       
                    ?>
                </ul>
            </div>
        </div>
        <a href="index.php?vote=1&cocktail_id=<?= $cocktail->id ?>" id="add" class="button">+</a>
    </div>
    <div id="copyright">Copyright - <a href="http://marco-molenaar.nl" target="_blank">Marco Molenaar</a> 2020</div>
    <script>
        document.getElementById('car_img').style.backgroundImage = "url('<?= $cocktail->img ?>')";
    </script>
</body>
</html>
