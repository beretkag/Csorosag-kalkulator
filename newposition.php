<h3 class="text-center">Új beosztás felvétele</h3>
<hr>


<div class="col-lg-6 offset-lg-3">

    <?php
        if (isset($_POST['send'])){
            $name = escapeshellcmd($_POST['name']);
            $wage = escapeshellcmd($_POST['wage']);
           
        
            if (empty($name) || !isset($wage))
            {
                showMessage('Nem adtál meg minden szükséges adatot!', 'danger');
            }
            else
            {
                $affectedRows = $db->exec("INSERT INTO position VALUES(null, '$name', '$wage')");
                 
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
            $_POST['wage'] = "";
            
        }
        
        $db->autoForm('
            action|position_add¤
            text|name|Megnevezés¤
            number|wage|Órabér|0¤
            submit|send|Felvesz|primary¤
            a|back|Vissza a leltárkészletre...|secondary');
    ?>

</div>

