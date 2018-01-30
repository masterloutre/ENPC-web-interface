<?php

include "../Global/global.php";
include "../Global/connect.php";
require_once "../Controllers/EtudiantController.php";
require_once "../Models/SituationPro.php";

try {
  $etudiant = get_etudiant($db, 4);
  $situation_pro = $situation_pro1;

  $db_req = $db->prepare('SELECT enigme.score_max, rel_enigme_situation_pro.ratio
    FROM enigme
    INNER JOIN score ON score.enigme_id = enigme.id
    INNER JOIN etudiant ON etudiant.id = score.etudiant_id
    INNER JOIN rel_enigme_situation_pro ON rel_enigme_situation_pro.enigme_id = enigme.id
    INNER JOIN situation_pro ON situation_pro.id = rel_enigme_situation_pro.situation_pro_id
    WHERE etudiant.id = '.$etudiant->get_id().' AND situation_pro.id = '.$situation_pro->get_id()
  );
  var_dump($db_req);
  $db_req->execute();
  $result = $db_req->fetchAll();

  $score = 0;
  if (!empty($result))
  {
    for ($x = 0; $x < count($result); ++$x)
    {
      $score += $result[$x]['score_max'] * $result[$x]['ratio'] / 100;
      var_dump($score);
    }
  }
}

catch(PDOException $e)
{
  echo $e;
}
