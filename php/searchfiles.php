<?php
include 'queryform.php';
include 'vectorspacemodel.php';
include 'wordstandardization.php';

$busqueda = $_POST['search'];
$busqueda = WordStandardization::toLowerCase($busqueda);
$queryform = new QueryForm($busqueda);
$query = $queryform->getVerbs();
print_r($queryform->getVerbs());
echo "<br>";
print_r($queryform->getLogicoperators());
/*
header("Location: ../pages/search.php?");
exit();
*/

function buildDocumentInfoArray($documentsname){
    $documentarrayinfo = [];
    $numdocument = count($documentsname);
    foreach($documentsname as $i => $value){
        $documentarrayinfo[$documentsname[$i]] = file_get_contents('../documents/'.$value);
    }
    return $documentarrayinfo;
}

function constructHeader($result){
    $location = "Location: ../pages/search.php?";
    foreach($result as $key=>$value){
        $location = $location.$key."=".$value."&";
    }
    return $location;
}
?>