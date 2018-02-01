<?php

require "./Global/connect.php";
require_once("./Controllers/EtudiantController.php");
require_once("./Controllers/EnseignantController.php");
require_once("./Controllers/EnigmeController.php");
require_once("./Controllers/LancementJeuController.php");
require_once("./Controllers/SituationProController.php");

//echo "OH TU MARCHES ?";

if(!array_key_exists('item', $_GET)){
    //echo "erreur pas de clé item dans GET";
    header("Refresh:0; url=./index.php?action=interface-admin");
}else{
    if($_GET['item'] == 'enigme'){
        //récupère les ratio des situations pro
        $ratio = array();
        for($i=1; $i<=6; $i++){
            array_push($ratio, $_POST['situation_pro'.$i]);
            unset($_POST['situation_pro'.$i]);
        }
    }

    $method = 'create_'.ucfirst($_GET['item']);
    $object = $method($_POST);
    
    //var_dump($object);

    if($object == NULL){
        //problème à la création
        header("Refresh:0; url=./index.php?action=interface-admin&vue=liste&item=".$_GET['item']);
    }else{
        if($_GET['item'] == 'enigme'){
            $competence = get_competence($db, $_POST['competence']);
            $object->set_competence($competence);
            $object->set_score_max($object->get_difficulte() * $object->get_type() * 100);
        }
        if($_GET['item'] == 'etudiant' || $_GET['item'] == 'enseignant'){
            $object->set_mdp("12345");
        }

        $method = 'add_'.ucfirst($_GET['item']);
        $result = $method($db, $object);

        if($_GET['item'] == 'enigme'){
            //insère les ratio des situations pro dans la base
            for($i=1; $i<=6; $i++){
                if(!empty($ratio[$i-1]) && $ratio[$i-1] != 0){
                    add_ratio_situation_pro_enigme($db, $object->get_id(), $i, $ratio[$i-1]);
                }
            }
        }
        
        //echo "Bonjour";
        header("Refresh:0; url=./index.php?action=interface-admin&vue=liste&item=".$_GET['item']);
    }
}

?>
