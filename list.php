<?php
    include_once 'assets/src/cocktail.php';
    include_once 'assets/config/connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/logo_cocktail.png">
    <link rel="stylesheet" href="assets/css/list.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <title>cocktail list</title>
</head>
<body>
    <div id="container">
        <ul>
        <?php
            // selects all cocktails from database
            $sql = "SELECT * FROM cocktail_list";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<li class='list_item'><div class='c_name'>"
                    . $row['name'] . "</div><div class='c_like'><i class='fas fa-heart'></i>" . $row['liked'] . 
                        "</div></li>";
                }
            } else {
                echo "0 cocktails found";
            }
            $conn->close();

            ?>
        </ul>
    </div>

</body>
</html>