


<h1>Munkás edit:</h1>



<?php 
    $id = $_GET['ID'];
    if (isset($_POST["submit"])){
        $name = escapeshellcmd($_POST["name"]);
        $postID = escapeshellarg($_POST["positionID"]);
        if (empty($name)||empty($postID)) showMessage("Nem adtál meg minden adatot!", "danger");
        else {
            $db->exec("update workers set name='$name', positionID=$postID where ID=$id");
            showMessage("Sikeres módosítás!", "success");
        }
    }
    $results = $db->query("SELECT * FROM workers WHERE ID=".$_GET['ID']);
    $_POST= $results[0];

    $db->query("select * from workers where ID=$id");
    $db->autoForm("action|workers_mod&ID=".$id."¤
    text|name|Munkás neve¤
    number|positionID|Pozició azonosító¤
    submit|submit|Módosítás|warning¤
    ");


?>