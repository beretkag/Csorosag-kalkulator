<?php
    $page = @$_GET['pg'];

    switch ($page){
        default:{include("munkaidok.php");break;}
        case "workers":{include("dolgozok.php");break;}
        case "position":{include("position.php");break;}

        case "workers_del":{include("delworker.php");break;}
        case "shifts_del":{include("delshift.php");break;}
        case "position_del":{include("delposition.php");break;}

        case "shifts_add":{include("newshift.php");break;}
        case "workers_add":{include("newworker.php");break;}
        case "position_add":{include("newposition.php");break;}

        case "workers_info":{include("infoworker.php");break;}
        case "shifts_info":{include("infoshift.php");break;}
        case "position_info":{include("infoposition.php");break;}

        case "shifts_mod":{include("modshift.php");break;}
        case "workers_mod":{include("modworker.php");break;}
        case "position_mod":{include("modposition.php");break;}

    }
?>