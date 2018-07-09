<?php

require "connect.php";
require_once "./Models/Competence.php";
require_once "./Models/SituationPro.php";
require_once "./Controllers/CompetenceController.php";
require_once "./Controllers/SituationProController.php";

$competences_tab = get_all_competence($db);
$situation_pro_tab = get_all_situation_pro($db);