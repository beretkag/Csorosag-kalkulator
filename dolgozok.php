<?php
    $db->query("SELECT workers.ID as 'ID',
        workers.name as 'Név',
        position.name as 'Beosztás',
        wage as 'Órabér (Ft)'
        FROM workers INNER JOIN position
        ON position.ID=positionID
        ");

    echo '<h3 class="text-center">Dolgozók listája</h3><hr>';

    $db->toTable('c|i|u|d');

?>