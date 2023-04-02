<h1>Munkaidő módosítás:</h1>

<?php
    if (isset($_POST["upload"])){
        if (isset($_POST["starttime"]) && isset($_POST["endtime"])&& isset($_POST["day"]) &&
            !empty($_POST["starttime"])&& !empty($_POST["endtime"]) && !empty($_POST["day"])){
                $db->exec("update shifts set starttime=Time('".$_POST["starttime"]."'), endtime=Time('".$_POST["endtime"]."'), day='".$_POST["day"]."' where ID=".$_GET["ID"]);
                showMessage("Sikeres feltöltés!", "success");
        }
        else {
            showMessage("Nem adtál meg minden adatot!", "danger");
        }
    }

    $id = $_GET["ID"];
    $results = $db->query("select workerID from shifts where ID=$id");
    $work = new Worker($results[0]["workerID"]);
    foreach ($work->shifts as $shift){
        if ($shift->ID == $_GET["ID"]){
            $_POST = array(
                "starttime"=>$shift->starttime,
                "endtime"=>$shift->endtime,
                "day"=>$shift->day
            );
        }
    } 
    $_POST;

    $db->autoForm(
        "action|shifts_mod&ID=".$id."¤
        
        time|starttime|Kezdés¤
        time|endtime|Végzés¤
        number|day|Hét napja¤
        submit|upload|Feltöltés|primary¤
        "
    )
?>