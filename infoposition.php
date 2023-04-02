<h3 class="text-center">Rekord információ</h3>
<hr>
<?php

    $db->query("SELECT ID as 'ID',
    name as 'Pozíció megnevezése',
    wage as 'Órabér'
    FROM position
    WHERE ID=".$_GET['ID']);

    $db->showRecord('b');
?>