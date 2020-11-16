<?php
include 'services.php';
include 'docs.php';
include 'indexitem.php';

class QueryForm{
    private $logicoperators;
    private $verbs;
    private $coincidencematrix;
    private $service;
    private $queryconstruct;

    function __construct($query){
        $this->service = new Services();
        $words = explode(" ",$query);
        $numwords = count($words);
        $this->setLogicoperators($words,$numwords);
        $this->setVerbs($words,$numwords);
        $this->queryconstruct = "";
    }

    public function getLogicoperators(){
        return $this->logicoperators;
    }

    public function getVerbs(){
        return $this->verbs;
    }

    public function getQueryconstruct(){
        return $this->queryconstruct;
    }

    public function getAllVerbsCoincidence(){
        $numlogicaloperators = count($this->logicoperators);
        for($i=0;$i<$numlogicaloperators;$i++){
            if($this->logicoperators[$i] == 'and' && $i == 0){
                $this->queryconstruct.= "+".$this->verbs[$i]." +".$this->verbs[$i+1];
                continue;
            }
            if($this->logicoperators[$i] == 'and'){
                $this->queryconstruct.= " +".$this->verbs[$i+1];
                continue;
            }
            if($this->logicoperators[$i] == 'or' && $i == 0){
                $this->queryconstruct.= "".$this->verbs[$i]." ".$this->verbs[$i+1];
                continue;
            }
            if($this->logicoperators[$i] == 'or'){
                $this->queryconstruct.= " ".$this->verbs[$i+1];
                continue;
            }
        }
        $this->searchPatron();
        return $this->deployMysqlRow($this->service->createSearchQuery($this->queryconstruct));
    }

    private function searchPatron(){
        $arrayquery = explode(" ",$this->queryconstruct);
        $arraysize = count($arrayquery);
        for($i=0;$i<$arraysize;$i++){
            if(substr($arrayquery[$i],0,6) == 'patron'){
                $arrayquery[$i] = substr(substr($arrayquery[$i],0,-1),7)."*";
                continue;
            }
            if(substr($arrayquery[$i],1,6) == 'patron'){
                $arrayquery[$i] = "+".substr(substr($arrayquery[$i],1,-1),7)."*";
                continue;
            }
        }
        $this->queryconstruct = $this->arrayToString($arrayquery);
    }

    private function arrayToString($array){
        $arraysize = count($array);
        $query = "";
        for($i=0;$i<$arraysize;$i++){
            $query.= $array[$i]." ";
        }
        return substr($query,0,-1);
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

    private function deployMysqlRow($mysqlresult){
        $fileinfo = [];
        $contador = 0;
        while($row = $mysqlresult->fetch_assoc()){
            $fileinfo[$contador]['nombredocumento'] = $row['nombredocumento'];
            $fileinfo[$contador]['Score'] = $row['Score'];
            $contador++;
        }
        return $fileinfo;
    }

}
?>