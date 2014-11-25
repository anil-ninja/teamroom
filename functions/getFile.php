<?php

    function checkPermission(){
        /*
            File can be at 2 place project file and home page file.
            
            The files which are home page file or the public project file will be give permission
            to access. 
            
            File which are inside private project need a validation

        */

            return true;

    }

    if (!checkPermission()){
         exit;
    }
     
    $file = '/var/collap_files/'.$_GET['file'];

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
?>