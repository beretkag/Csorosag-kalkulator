<h3 class="text-center">Új munkaidő felvétele</h3>
<hr>


<div class="col-lg-6 offset-lg-3">

    <?php
        if (isset($_POST['send'])){
            $worker = escapeshellcmd($_POST['workerID']);
            $start = escapeshellcmd($_POST['start']);
            $end = escapeshellcmd($_POST['end']);
            $day = escapeshellcmd($_POST['day']);   
        
            if (empty($worker) || empty($start) || empty($end)  || empty($day))
            {
                showMessage('Nem adtál meg minden szükséges adatot!', 'danger');
            }
            else
            {
                $affectedRows = $db->exec("INSERT INTO shifts VALUES(null, '$worker', '$start', '$end ', '$day')");
                
                if ($affectedRows != 0)
                {
                    showMessage('A tétel bekerült az adatbázisba!', 'success');
                    setDefault();
                }
                else
                {
                    showMessage('Hiba az adatbázis művelet során!', 'danger');
                }
            }
        }
        else
        {
            setDefault();
        }

        function setDefault(){
            $_POST['workerID'] = "";
            $_POST['start'] = "";
            $_POST['end'] = "";
            $_POST['day'] = "";
        }
        
        $db->autoForm('
            action|shifts_add¤
            number|workerID|Dolgozó azonosítója|1¤
            time|start|Kezdés ideje¤
            time|end|Végzés ideje¤
            number|day|Hét napja|1|7¤
            submit|send|Felvesz|primary¤
            a|back|Vissza a munkaidőkhöz...|secondary');
    ?>

</div>

