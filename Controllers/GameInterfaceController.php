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
    $player = get_player_info($etudiant);
    $json = json_encode($player);
    echo($json);
}

//get ids of all the enigmas the player will have to do
function enigmes_dispo() {
    include "./Global/connect.php";
    $enigmes = get_all_enigme($db);
    return $enigmes;
}

//get all necessary info for the game on an enigma
function get_enigme_info(){
}

//send json of info on all available enigma to the game
function send_enigmes_dispo_info(){
    $enigmes = enigmes_dispo();
    print_r($enigmes);
}

//get n random objects from an array
/*
function get_n_random_from_array($array, int n){
    shuffle($array);
    if($array.size()>= n){
        return array_slice($array, 0, n);
    } else {
        return array();
    }
}
*/
