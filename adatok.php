<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = '2123szft_munkaido';
    $appname = 'Munkaibér kalkulátor';
    $company = 'Bajai SZC Türr István Tecnikum';
    $author = 'Beretka Gellért';
    $uploadDir = 'uploads/';

    function showMessage($message, $type){
        echo '<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">
        '.$message.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
?>