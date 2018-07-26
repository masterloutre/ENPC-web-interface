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
    if($_GET['item'] == 'enigme'){
        //récupère les ratio des situations pro
        $ratio = array();
        foreach($_POST as $key=>$value){
            if(strpos($key,'situation_pro')!==false){
                $ratio[$key]=$value;
                unset($_POST[$key]);
            }
        }
    }

    $method = 'create_'.ucfirst($_GET['item']);
    $object = $method($_POST);

    if($object == NULL){

        //problème à la création
        header("Refresh:0; url=./index.php?action=interface-admin&vue=liste&item=".$_GET['item']);
    }else{
        if($_GET['item'] == 'enigme'){
            $competence = get_competence($db, $_POST['competence']);
            $object->set_competence($competence);
            $object->set_score_max($object->get_difficulte() * $object->get_type() * 100);
        }

        $method = 'update_'.ucfirst($_GET['item']);
        $result = $method($db, $object);
        if($_GET['item'] == 'enigme'){
            //suppr lignes correspondant à enigme dans rel_enigme_situation_pro
            delete_ratio_situation_pro_enigme($db, $object);

            //add nouvelels lignes dans rel_enigme_situation_pro
            foreach($ratio as $key => $value){
                if(!empty($value) && $value != 0){
                    add_ratio_situation_pro_enigme($db, $object->get_id(), ((int) filter_var($key, FILTER_SANITIZE_NUMBER_INT)), $value);
                }
            }
        }

        header("Refresh:0; url=./index.php?action=interface-admin&vue=liste&item=".$_GET['item']);
        //header("Location:./index.php?action=interface-admin&vue=liste&item=".$_GET['item']);
    }
}

?>