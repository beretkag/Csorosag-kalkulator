<h3 class="text-center">Rekord információ</h3>
<hr>
<?php

    $db->query("SELECT workers.ID as 'ID',
    workers.name as 'Név',
    position.name as 'Beosztás',
    wage as 'Órabér (Ft)'
    FROM workers INNER JOIN position
    ON position.ID=positionID WHERE workers.ID=".$_GET['ID']);

    $db->showRecord('b');
?>