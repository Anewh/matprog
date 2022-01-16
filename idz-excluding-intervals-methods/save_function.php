<?php
    $file = 'input.txt';
    header('Content-Disposition: attachment; filename="'.$file.'"');
    header('Content-Type: text/html');
    readfile($file);
    exit();
?>