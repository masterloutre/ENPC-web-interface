<?php

require "./Global/connect.php";
require_once "./Models/Etudiant.php";
require_once "./Controllers/SessionController.php";
require_once "./Controllers/EnigmeController.php";

/*****
FUNCTION
*****/

//get information on the student needed to play the game
function get_player_info(Etudiant $etudiant){
    $player = array('id' => $etudiant->get_id(),'studentNumber' => $etudiant->get_num_etud(), 'surname' =>$etudiant->get_nom(), 'firstname' =>$etudiant->get_prenom() , 'graduatingYear' =>$etudiant->get_promo());
    return $player;
}

//send json of the player info to the unity game app
function send_player_info(Etudiant $etudiant){
    header('Content-Type: application/json');
    $player = get_player_info($etudiant);
    $json = json_encode($player);
    echo($json);
}

function send_dummy_player_info(){
    $player = array('id' => 0,'studentNumber' => 6666666666, 'surname' => 'Dummy', 'firstname' => 'FromServer' , 'graduatingYear' =>'2000');
    header('Content-Type: application/json');
    $json = json_encode($player);
    echo($json);
}


//get ids of all the enigmas the player will have to do
function enigmes_dispo() {
    include "./Global/connect.php";
    $enigmes_type1 = get_n_random_from_array(get_all_enigme_by_type($db, 1), 1);
    $enigmes_type2 = get_n_random_from_array(get_all_enigme_by_type($db, 2), 1);
    $enigmes_type3 = get_n_random_from_array(get_all_enigme_by_type($db, 3), 1);
    $enigmes = array_merge($enigmes_type1, $enigmes_type2, $enigmes_type3);
    return $enigmes;
}

//send json of info on all available enigma to the game
function send_enigmes_dispo_info(){
    header('Content-Type: application/json');
    $enigmes = enigmes_dispo();
    $enigmes_json = array_map(function($eni) { return $eni->get_vars();}, $enigmes);
    $json = json_encode($enigmes_json);
    echo($json);
}

//get n random objects from an array
function get_n_random_from_array($array, $n){
    shuffle($array);
    if(count($array)>= n){
        return array_slice($array, 0, $n);
    } else {
        return array();
    }

}

//get authorization to start the game
function send_session_ouverte_info(){
    //arbitraire pour l'instant
    $session_ouverte = 1;
    header('Content-Type: application/json');
    $json = json_encode($session_ouverte);
    echo $json;
}

// handle the post form send the score for a particulr student and enigma
function process_score_info() {
    include "./Global/connect.php";
    try{
        $id_enigme = valid_numeric($_POST['id_enigme']);
        $id_etudiant = valid_numeric($_POST['id_etudiant']);
        $score_data = [
            'id' => NULL,
            'points' => valid_numeric($_POST['points']),
            'tentatives' => valid_numeric($_POST['tentatives']),
            'temps' => valid_numeric($_POST['temps']),
            'aide' => valid_int_bool($_POST['aide'])
        ];
        $score = create_score($score_data);

        $etudiant = get_etudiant($db, $id_etudiant);
        $enigme = get_enigme($db, $id_enigme);

        if($etudiant && $enigme) {
            $old_score = get_score_from_etudiant_on_enigme($db, $etudiant, $enigme);
        }
        if($old_score){
            $score->set_id($old_score->get_id());
            update_score($db, $score);
        } else {
            add_score($db, $score, $id_etudiant, $id_enigme);
        }


    } catch (Exception $e){
        throw new Exception("Le score n'a pas pu etre ajouté en BDD, motif :".$e->getMessage());
    }


}

//Value validations
function valid_int_bool($valeur){
    if($valeur != 0 && $valeur !=1 && $valeur != "0" && $valeur !="1"){
        throw new Exception($valeur.' n\'est pas une représentation de booléen');
    }
    return $valeur;
}


function valid_numeric($valeur){
    if(!is_numeric($valeur)){
        throw new Exception($valeur.' n\'est pas un nombre');
    }
    return $valeur;
}






