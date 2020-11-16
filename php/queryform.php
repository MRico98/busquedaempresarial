<?php
include 'services.php';
include 'docs.php';
include 'indexitem.php';

class QueryForm{
    private $logicoperators;
    private $verbs;
    private $coincidencematrix;
    private $service;
    private $subquery = [];

    function __construct($query){
        $this->service = new Services();
        $words = explode(" ",$query);
        $numwords = count($words);
        $this->setLogicoperators($words,$numwords);
        $this->setVerbs($words,$numwords);
    }

    public function getLogicoperators(){
        return $this->logicoperators;
    }

    public function getVerbs(){
        return $this->verbs;
    }

    public function getAllVerbsCoincidence(){
        
    }

    public function applyLogicOperators(){
        $filesmatrix = $this->getFilesWithWords();
        for($i=0;$i<count($this->logicoperators);$i++){
            if($this->logicoperators[$i] == 'and'){

            }
            elseif($this->logicoperators[$i] == 'or'){

            }
        }
        return $filesmatrix[count($filesmatrix)-1];
    }

    private function setLogicoperators($words,$numwords){
        $this->logicoperators = [];
        for($i=1,$j=0;$i<$numwords;$i=$i+2,$j++){
            $this->logicoperators[$j] = $words[$i];
        }
    }

    private function setVerbs($words,$numwords){
        $this->verbs=[];
        for($i=0,$j=0;$i<$numwords;$i=$i+2,$j++){
            $this->verbs[$j] = $words[$i];
        }
    }

    private function intersectArrays($array1,$array2){
        return array_intersect($array1,$array2);
    }

    private function unionArrays($array1,$array2){
        return array_merge($array1,$array2);
    }

}
?>