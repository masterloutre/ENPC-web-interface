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
    $method = 'create_'.ucfirst($_GET['item']);
    $object = $method($_POST);

    if($object == NULL){
        //problème à la création
        header("Refresh:0; url=listeAdmin.php?item=".$_GET['item']);
    }else{
        if($_GET['item'] == 'enigme'){
            $competence = get_competence($db, $_POST['competence']);
            $object->set_competence($competence);
        }
        
        $method = 'update_'.ucfirst($_GET['item']);
        $result = $method($db, $object);

        header("Refresh:0; url=listeAdmin.php?item=".$_GET['item']);
    }
}

?>