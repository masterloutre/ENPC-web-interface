<?php

include "../Global/connect.php";
require_once "../Models/Etudiant.php";

$array = [
  "id" => 1,
  "nom" =>  "Rose",
  "prenom" => "Daphné",
  "promo" => "2020",
  "num_etud" => "1231454444"
];

$etudiant = new Etudiant($array);

echo $etudiant->get_nom();

 ?>
