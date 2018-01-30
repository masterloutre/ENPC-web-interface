<?php

require "connect.php";
require_once "../Models/Competence.php";
require_once "../Models/SituationPro.php";
require_once "../Controllers/CompetenceController.php";
require_once "../Controllers/SituationProController.php";

$competence1 = get_competence($db, 1);
$competence2 = get_competence($db, 2);

$situation_pro1 = get_situation_pro($db, 1);
$situation_pro2 = get_situation_pro($db, 2);
$situation_pro3 = get_situation_pro($db, 3);
$situation_pro4 = get_situation_pro($db, 4);
$situation_pro5 = get_situation_pro($db, 5);
$situation_pro6 = get_situation_pro($db, 6);
