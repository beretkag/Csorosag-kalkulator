<h3 class="text-center">Rekord információ</h3>
<hr>
<?php

    $db->query("SELECT shifts.ID as 'ID',
    workers.name as 'Dolgozó neve',
    starttime as  'Kezdés',
    endtime as 'Végzés',
    day as 'Nap',
    ROUND((HOUR(Time(endtime)-Time(starttime))*wage+minute(Time(endtime)-Time(starttime))*wage/60)) as 'Fizetendő (Ft)'
    FROM shifts 
    INNER JOIN workers on workers.ID=workerID 
    INNER JOIN position on positionID=position.id
    WHERE shifts.ID=".$_GET['ID']);

    $db->showRecord('b');
?>