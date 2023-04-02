<h3 class="text-center">Új dolgozó felvétele</h3>
<hr>


<div class="col-lg-6 offset-lg-3">

    <?php
        if (isset($_POST['send'])){
            $name = escapeshellcmd($_POST['name']);
            $positionID = escapeshellcmd($_POST['positionID']);
           
        
            if (empty($name) || !isset($positionID))
            {
                showMessage('Nem adtál meg minden szükséges adatot!', 'danger');
            }
            else
            {
                $affectedRows = $db->exec("INSERT INTO workers VALUES(null, '$name', '$positionID')");
                 
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
            $_POST['name'] = "";
            $_POST['positionID'] = "";
            
        }
        
        $db->autoForm('
            action|workers_add¤
            text|name|Dolgozó neve¤
            number|positionID|Beosztás azonosítója|0¤
            submit|send|Felvesz|primary¤
            a|back|Vissza a leltárkészletre...|secondary');
    ?>

</div>

