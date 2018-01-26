<?php

require_once "../Models/Competence.php";
require_once "../Controllers/EtudiantController.php";

$competence1 = new Competence(["id" => 1,
                               "nom" => "Modéliser et exploiter les processus mécaniques"]);
$competence2 = new Competence(["id" => 2,
                               "nom" => "Concevoir des pièces et assemblage mécanique"]);
