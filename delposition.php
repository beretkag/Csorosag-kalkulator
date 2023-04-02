<h3 class="text-center">Rekord törlése</h3>
<hr>
<?php
    if (isset($_POST['delete'])){
        var_dump("UPDATE workers SET positionID=0 WHERE positionID=".$_GET['ID']);
        $db->exec("UPDATE workers SET positionID=0 WHERE positionID=".$_GET['ID']) ;
        $db->exec("DELETE FROM position WHERE ID=".$_GET['ID']);
        header("location: index.php");
    }

    $db->autoForm('action|position_del&ID='.$_GET['ID'].'¤
    label|Biztosan törlöd az alábbi rekordot?¤
    submit|delete|Igen|danger¤
    a|cancel|Mégsem|secondary');

    include("infoposition.php");
?>