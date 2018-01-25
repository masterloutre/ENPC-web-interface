<?php

include "../Global/connect.php";
include "../Global/global.php";
require_once "../Controllers/ScoreController.php";
require_once "../Controllers/EtudiantController.php";
require_once "../Controllers/EnigmeController.php";
require_once "../Controllers/CompetenceController.php";
require_once "../Controllers/SituationProController.php";

$enigme = get_enigme($db, 5);
$etudiant = get_etudiant($db, 4);
$situation_pro = get_situation_pro($db, 3);

//var_dump(get_score_max_from_enigme($db, $enigme));
//var_dump(get_score_from_etudiant_on_enigme($db, $etudiant, $enigme));
//var_dump(get_score_from_etudiant_on_competence($db, $etudiant, $competence2));
//var_dump(get_score_from_etudiant_on_situation_pro($db, $etudiant, $situation_pro));
//var_dump(get_moyenne_score_from_enigme($db, $enigme));
//var_dump(get_moyenne_score_from_competence($db, $competence1));
var_dump(get_moyenne_score_from_situation_pro($db, $situation_pro));

?>
