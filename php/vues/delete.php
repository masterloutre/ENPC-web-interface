<?php

include "../Global/connect.php";
require("../Controllers/EtudiantController.php");
require("../Controllers/EnseignantController.php");
require("../Controllers/EnigmeController.php");
require("../Controllers/LancementJeuController.php");
require("../Controllers/SituationProController.php");

if(!array_key_exists('item', $_GET)){
    echo "erreur pas de clé item dans GET";
}else{
    if(!array_key_exists('id', $_GET)){ //pas d'id à delete
        header("Refresh:0; url=listeAdmin.php?item=".$_GET['item']);
    }else{
        $method = 'get_'.ucfirst($_GET['item']);
        $object = $method($db, $_GET['id']);
        
        if($object == NULL){
            //object not found in database
            header("Refresh:0; url=listeAdmin.php?item=".$_GET['item']);
        }else{
            $method = 'delete_'.ucfirst($_GET['item']);
            $result = $method($db, $object);
            
            header("Refresh:0; url=listeAdmin.php?item=".$_GET['item']);
        }
    }
}

?>