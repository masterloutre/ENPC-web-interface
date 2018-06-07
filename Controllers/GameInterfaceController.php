<?php

require "./Global/connect.php";
require_once "./Models/Etudiant.php";
require_once "./Controllers/SessionController.php";

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
    print_r($json);
    return json;
}

