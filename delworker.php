<h3 class="text-center">Rekord törlése</h3>
<hr>
<?php
    if (isset($_POST['delete'])){
        $db->exec("DELETE FROM shifts WHERE workerID =".$_GET['ID']);
        $db->exec("DELETE FROM workers WHERE ID=".$_GET['ID']);
        header("location: index.php");
    }

    $db->autoForm('action|workers_del&ID='.$_GET['ID'].'¤
    label|Biztosan törlöd az alábbi rekordot?¤
    submit|delete|Igen|danger¤
    a|cancel|Mégsem|secondary');

    include("infoworker.php");
?>