<?php
    $workersQuery = $db->query("select ID from workers");
    $workers = array();
    foreach ($workersQuery as $dt) {
        array_push($workers, new Worker($dt["ID"]));
    }
    echo '<h3 class="text-center">Műszakok listája</h3><hr>';
    $db->query("SELECT shifts.ID as 'ID',
                workers.name as 'Dolgozó neve',
                starttime as 'Kezdés',
                endtime as 'Végzés',
                day as 'Hét napja'
                FROM shifts
                INNER JOIN workers on workers.ID=workerID");
    $db->toTable('c|i|u|d');
?>