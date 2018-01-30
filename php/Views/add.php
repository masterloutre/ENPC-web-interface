<?php

require "../Global/connect.php";
require_once("../Controllers/EtudiantController.php");
require_once("../Controllers/EnseignantController.php");
require_once("../Controllers/EnigmeController.php");
require_once("../Controllers/LancementJeuController.php");
require_once("../Controllers/SituationProController.php");

if(!array_key_exists('item', $_GET)){
    echo "erreur pas de clé item dans GET";
}else{
    $method = 'create_'.ucfirst($_GET['item']);
    $object = $method($_POST);

    if($object == NULL){
        //problème à la création
        header("Refresh:0; url=../Index/index.php?action=interface-admin&vue=liste&item=".$_GET['item']);
    }else{
        if($_GET['item'] == 'enigme'){
            $competence = get_competence($db, $_POST['competence']);
            $object->set_competence($competence);
        }
        if($_GET['item'] == 'etudiant' || $_GET['item'] == 'enseignant'){
            $object->set_mdp("12345");
        }
        
        $method = 'add_'.ucfirst($_GET['item']);
        $result = $method($db, $object);

        header("Refresh:0; url=../Index/index.php?action=interface-admin&vue=liste&item=".$_GET['item']);
    }
}

?>