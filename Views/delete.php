<?php

require "./Global/connect.php";
require_once ("./Controllers/EtudiantController.php");
require_once ("./Controllers/EnseignantController.php");
require_once ("./Controllers/EnigmeController.php");
require_once ("./Controllers/LancementJeuController.php");
require_once ("./Controllers/SituationProController.php");

if(!array_key_exists('item', $_GET)){
    echo "erreur pas de clé item dans GET";
    header("Refresh:0; url=./index.php?action=interface-admin");
}else{
    if(!array_key_exists('id', $_GET)){ //pas d'id à delete
        header("Refresh:0; url=./index.php?action=interface-admin&vue=liste&item=".$_GET['item']);
    }else{
        $method = 'get_'.ucfirst($_GET['item']);
        $object = $method($db, $_GET['id']);

        if($object == NULL){
            //object not found in database
            header("Refresh:0; url=./index.php?action=interface-admin&vue=liste&item=".$_GET['item']);
        }else{
            $method = 'delete_'.ucfirst($_GET['item']);
            $result = $method($db, $object);

            //header("Refresh:0; url=./index.php?action=interface-admin&vue=liste&item=".$_GET['item']);
            header("Location:./index.php?action=interface-admin&vue=liste&item=".$_GET['item']);
        }
    }
}

?>
