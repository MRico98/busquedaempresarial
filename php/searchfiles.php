<?php
include 'queryform.php';
include 'vectorspacemodel.php';
include 'wordstandardization.php';

$busqueda = $_POST['search'];

$busqueda = WordStandardization::toLowerCase($busqueda);
$queryform = new QueryForm($busqueda);

$resultado = $queryform->getAllVerbsCoincidence();
print_r($resultado);
header(constructHeader($resultado));
exit();

function constructHeader($result){
    $location = "Location: ../pages/search.php?";
    $numrows = count($result);
    for($i=0;$i<$numrows;$i++){
        $location = $location.$result[$i]['nombredocumento']."=".$result[$i]['Score']."&";
    }
    return $location;
}
?>