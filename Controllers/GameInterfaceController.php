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
    $player = array('num_etud' => $etudiant->get_num_etud(), 'nom' =>$etudiant->get_nom(), 'prenom' =>$etudiant->get_prenom() , 'promo' =>$etudiant->get_promo());
    return $player;
}

//send json of the player info to the unity game app
function send_player_info(Etudiant $etudiant){
    header('Content-Type: application/json');
    $player = get_player_info($etudiant);
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
function get_n_random_from_array($array, int $n){
    shuffle($array);
    if(count($array)>= n){
        return array_slice($array, 0, $n);
    } else {
        return array();
    }

}



