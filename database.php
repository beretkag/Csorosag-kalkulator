<?php
    // Bajai SZC Türr István Technikum
    // 2/14.SZFT. Szoftverfejlesző
    // 2021/23.
    // Objektum orientált PDO-MySQL Adatbázis osztály 
    
    class DB {
        // attributes
        private $dbhost;
        private $dbname;
        private $dbuser;
        private $dbpass;
        private $connection;
        private $debug = 0;
        private $results;
        private $tablename;
        private $fields = array();

        // constructor
        public function __construct($dbhost, $dbname, $dbuser, $dbpass)
        {
            $this->dbhost = $dbhost; 
            $this->dbname = $dbname;
            $this->dbuser = $dbuser;
            $this->dbpass = base64_decode($dbpass);   

            try 
            {
                $this->connection = new PDO("mysql:host=$this->dbhost;dbname=$this->dbname", $this->dbuser, $this->dbpass);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $this->connection->exec("SET NAMES utf8");
            } 
            catch(PDOException $e) 
            {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        public function __destruct()
        {
            // amikor az objektum páldány megszűnik, nem kötelező
            $this->connection = null;
        }

        // methods
        public function query($sql){
            if ($this->debug)
            {
               $this->showMessage($sql, 'warning');
            }
            $res = $this->connection->query($sql);
            $this->tablename = $res->getColumnMeta(0)['table'];
            $this->results = $res->fetchAll();
            $this->fields = array();
            foreach($this->results[0] as $field => $key){
                $this->fields[] = $field;
            }
            return $this->results;
        }

        public function exec($sql){
            return $this->connection->exec($sql);
        }

        public function errorInfo()
        {
            return $this->connection->errorInfo();
        }

        public function showMessage($msg, $type)
        {
            echo '<div class="alert alert-'.$type.' animate__animated animate__heartBeat alert-dismissible fade show" role="alert">
            '.$msg.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }

        public function toTable($params){
           
            if (!empty($params)){
                $actions = explode('|', $params);       
            }else{
                $actions = [];       
            }
           
            if (in_array('c', $actions)){
                echo '<a href="index.php?pg='.$this->tablename.'_add" class="btn btn-primary mb-3">Új rekord felvétele...</a>';
            }

            $fields = [];
            echo '<table class="table table-hover table-striped table-bordered">
            <thead class="table-light">
                <tr>';
                foreach($this->results[0] as $field => $key){
                    $fields[] = $field;
                    echo '<th>'.$field.'</th>';
                }
                if (in_array('i', $actions) || in_array('u', $actions) || in_array('d', $actions)){
                    $fieldSize = sizeof($fields) + 1;
                    echo '<th class="text-end">Műveletek</th>';
                }
                else
                { 
                    $fieldSize = sizeof($fields);
                }
             echo '</tr>
            </thead>
            <tbody>';

            foreach($this->results as $result){
                echo '<tr>';
                foreach($result as $field){
                    echo '<td>'.$field.'</td>';
                }
                if (in_array('i', $actions) || in_array('u', $actions) || in_array('d', $actions)){

                    echo '<td class="text-end">';
                    if (in_array('i', $actions)){
                        echo '<a href="index.php?pg='.$this->tablename.'_info&ID='.$result['ID'].'" class="btn btn-dark btn-sm ms-1 me-1"><i class="bi bi-info-circle-fill"></i></a>';
                    }
                    if (in_array('u', $actions)){
                        echo '<a href="index.php?pg='.$this->tablename.'_mod&ID='.$result['ID'].'" class="btn btn-warning btn-sm ms-1 me-1"><i class="bi bi-pencil-fill"></i></a>';
                    }
                    if (in_array('d', $actions)){
                        echo '<a href="index.php?pg='.$this->tablename.'_del&ID='.$result['ID'].'" class="btn btn-danger btn-sm ms-1 me-1"><i class="bi bi-trash3-fill"></i></a>';
                    }       
                    echo '</td>';
                }
                echo '</tr>';
                
            }
            echo '</tbody>
            <tfoot>
                <tr>
                    <td colspan="'.$fieldSize.'" class="text-center">Összesen: '.sizeof($this->results).' rekord</td>
                </tr>
            </tfoot>
            </table>';
        }

                                    
        public function toSelect($label, $value, $field){
            $str = '<div class="form-floating mb-3">
            <select class="form-select" name="'.$this->tablename.'">
              <option selected>Válasszon...</option>';

            foreach($this->results as $result)
            {
                $str .='<option value="'.$result[$value].'">'.$result[$field].'</option>';
            }
    
            $str .='</select>
                <label for="'.$this->tablename.'">'.$label.'</label>
            </div>';

            echo $str;
        }

        public function showRecord($param){
            $str = '<table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th class="col-lg-3">Tulajdonság</th>
                    <th class="col-lg-9">Érték</th>
                </tr>
            </thead>
            <tbody>';
            foreach($this->fields as $field)
            {
                $str .= '<tr>
                    <td>'.$field.'</td>
                    <td>'.$this->results[0][$field].'</td>
                </tr>';
            }
            $str .= '</tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Összesen: '.sizeOf($this->fields).' tulajdonság</td>
                </tr>
            </tfoot>
            </table>';
            if ($param == 'b')
            {
                $str .= '<a href="index.php?pg='.$this->tablename.'" class="btn btn-primary mb-3">Vissza...</a>';
            }
            echo $str;
        }

        public function autoForm($param){

            $formElements = array();
            $enctype = '';
            $rows = explode('¤', $param);

            $method = 'POST';
            $action = 'index.php?pg=';

            foreach($rows as $row){
                $items = explode('|', $row);
                
                if (!isset($items[3])){$items[3] = '';}
                if (!isset($items[4])){$items[4] = '';}
                if (!isset($items[5])){$items[5] = '';}
                if (!isset($items[6])){$items[6] = '';}
                
                $items[0] = trim($items[0]);
            
                switch($items[0])
                {
                    case 'method': {
                        $method = $items[1]; break;
                    }

                    case 'action': {
                        $action .= $items[1]; break;
                    }

                    case 'text': {
                        $formElements[] = '<div class="form-floating mb-3">
                        <input type="text" class="form-control" name="'.$items[1].'" placeholder="" value="'.@$_POST[$items[1]].'">
                        <label for="'.$items[1].'">'.$items[2].'</label>
                    </div>'; break;
                    }

                    case 'number': {
                        $formElements[] = '<div class="form-floating mb-3">
                        <input type="number" class="form-control" name="'.$items[1].'" placeholder="" value="'.@$_POST[$items[1]].'"  min="'.$items[3].'" max="'.$items[4].'">
                        <label for="'.$items[1].'">'.$items[2].'</label>
                    </div>'; break;
                    }

                    case 'email': {
                        $formElements[] = '<div class="form-floating mb-3">
                        <input type="email" class="form-control" name="'.$items[1].'" placeholder="" value="'.@$_POST[$items[1]].'">
                        <label for="'.$items[1].'">'.$items[2].'</label>
                    </div>'; break;
                    }

                    case 'date': {
                        $formElements[] = '<div class="form-floating mb-3">
                        <input type="date" class="form-control" name="'.$items[1].'" placeholder="" value="'.@$_POST[$items[1]].'">
                        <label for="'.$items[1].'">'.$items[2].'</label>
                    </div>'; break;
                    }
                    case 'time':{
                        $formElements[] = '<div class="form-floating mb-3">
                        <input type="time" class="form-control" name="'.$items[1].'" placeholder="" value="'.@$_POST[$items[1]].'">
                        <label for="'.$items[1].'">'.$items[2].'</label>
                    </div>'; break;
                    }
                    case 'password': {
                        $formElements[] = '<div class="form-floating mb-3">
                        <input type="password" class="form-control" name="'.$items[1].'" placeholder="" value="'.@$_POST[$items[1]].'">
                        <label for="'.$items[1].'">'.$items[2].'</label>
                    </div>'; break;
                    }
                    case 'file' : {
                        $enctype = 'enctype="multipart/form-data"';
                        $formElements[] = '<div class="form-floating mb-3">
                            <input type="file" class="form-control" id="'.$items[1].'" name="'.$items[1].'" placeholder="'.$items[2].'" accept="'.$items[3].'">
                            <label for="'.$items[1].'">'.$items[2].'</label>
                        </div>';
                        break;
                    }

                    case 'checkbox' : {
                        if ($items[3] != '') { $items[3] = '-'.$items[3]; }
                        $formElements[] = '<div class="form-check'.$items[3].' mb-3 ">
                            <input class="form-check-input" type="checkbox" id="'.$items[1].'" name="'.$items[1].'" '.$items[3].'>
                            <label class="form-check-label" for="'.$items[1].'">
                                '.$items[2].' 
                            </label>
                        </div>';
                        break;
                    }
                    case 'switch' : {
                        if ($items[3] == '1') {$items[3] = 'checked';}
                        $formElements[] = '<div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="'.$items[1].'" name="'.$items[1].'" '.$items[3].'>
                            <label class="form-check-label" for="'.$items[1].'">'.$items[2].'</label>
                        </div>';
                        break;
                    }

                    case 'radio' : {
                        if ($items[3] != '') { $items[3] = '-'.$items[3]; }
                        $formElements[] = '<div class="form-check'.$items[3].' mb-3">
                        <input class="form-check-input" type="radio" name="'.$items[1].'" id="'.$items[1].'" '.$items[3].'>
                        <label class="form-check-label" for="flexRadioDefault1">
                          '.$items[2].'
                        </label>
                      </div>';
                        break;
                    }

                    case 'label' : {
                        $formElements[] = '<label class="form-check-label mb-3">'.$items[1].'</label><br>';
                        break;}

                    case 'textarea' : {
                        $formElements[] = '<div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="'.$items[2].'" id="'.$items[1].'" name="'.$items[1].'"></textarea>
                        <label for="'.$items[1].'">'.$items[2].'</label>
                      </div>';
                        break;
                    }

                    case 'select' : {
                       // $db = new DB($this->dbhost, $this->dbname, $this->dbuser, base64_encode($this->dbpass));
                       $this->query("SELECT * FROM ".$items[1]);
                        $input_elements[] = $this->toSelect($items[1], $items[2], $items[3]);
                        break;
                    }

                    case 'submit': {
                        $formElements[] = '<input type="submit" value="'.$items[2].'" name="'.$items[1].'" class="btn btn-'.$items[3].' mb-3">'; break;
                    }

                    case 'a': {
                        $formElements[] = ' <a href="index.php" name="'.$items[1].'" class="btn btn-'.$items[3].' mb-3" >'.$items[2].'</a>'; break;
                    }
                
                }
            }

            $str = '<form action="'.$action.'" method="'.$method.'" '.$enctype.'>';
            foreach($formElements as $element){
                $str .= $element;
            }
            $str .= '</form>';

            echo $str;
            
        }

        public function fileUpload($from, $to){
            if (move_uploaded_file($from, $to))
            {
                $this->showMessage('A fájl feltöltve', 'success');
            }
            else
            {
                $this->showMessage('Hiba a fájl feltöltése sotrán!', 'danger');
            }
        }
    }
?>