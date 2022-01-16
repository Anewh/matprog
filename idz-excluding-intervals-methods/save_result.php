<?php
    $file = 'result.txt';
    header('Content-Disposition: attachment; filename="'.$file.'"');
    header('Content-Type: text/html');
    readfile($file);
    exit();
?>