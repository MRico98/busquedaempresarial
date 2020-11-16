<?php
include 'fileunploaded.php';
include 'invertindex.php';
include 'wordstandardization.php';
include 'services.php';

if(isset($_POST['submit'])){
    $files = getUnploadedFiles();
    $servicios = new Services();
    setTableDocumentsInfo($files,$servicios);
    $servicios->closeConnection();
    header("Location: ../pages/filesupload.html");
    exit();
}

function getUnploadedFiles(){
    $countfiles = count($_FILES['file']['name']);
    $files = [];
    for($i=0;$i<$countfiles;$i++){
        move_uploaded_file($_FILES['file']['tmp_name'][$i],'../documents/'.$_FILES['file']['name'][$i]);
        $files[$i] = new FileUnploaded($_FILES['file']['name'][$i],file_get_contents('../documents/'.$_FILES['file']['name'][$i]));
    }
    return $files;
}

function setTableDocumentsInfo($files,$servicioquery){
    $numdocuments = count($files);
    for($i=0;$i<$numdocuments;$i++){
        $servicioquery->setMysqlDocumentsTableItem($files[$i]->getNamefile(),$files[$i]->getContentfile());
    }
}

?>