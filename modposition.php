<h1>Pozíció edit:</h1>
<?php 
    $id = $_GET['ID'];
    if (isset($_POST["submit"])){
        $name = escapeshellcmd($_POST["name"]);
        $wage = escapeshellarg($_POST["wage"]);
        if (empty($name)||empty($wage)) showMessage("Nem adtál meg minden adatot!", "danger");
        else {
            $db->exec("update position set name='$name', wage=$wage where ID=$id");
            showMessage("Sikeres módosítás!", "success");
        }
    }
    $results = $db->query("SELECT * FROM position WHERE ID=".$_GET['ID']);
    $_POST= $results[0];

    $db->autoForm("action|position_mod&ID=".$id."¤
    text|name|Poszt neve¤
    number|wage|Órabér¤
    submit|submit|Módosítás|warning¤
    ");
?>