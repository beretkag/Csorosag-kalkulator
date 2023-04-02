<!DOCTYPE html>
<?php
    require("adatok.php");
    require("database.php");
    $db = new DB($dbhost, $dbname, $dbuser, $dbpass);
    require("munkaido.php");
?>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $appname; ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/munkaido.css">
</head>
<body>
    <div class="container">
        <header>
            <hr>
            <?php echo $appname; ?>
            <hr>
        </header>
        <main>
            <?php include("navbar.php"); ?>
            <div id="content">
                <?php 
                    include("loader.php");
                ?>
            </div>
        </main>
        <footer>
            <?php 
                echo $company.' - '.$author;
            ?>
        </footer>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>