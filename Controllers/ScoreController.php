<?php

require "./Global/connect.php";
require "./Global/global.php";
require_once "./Models/Score.php";
require_once "./Models/Enigme.php";
require_once "./Models/Competence.php";

/*
A propos du calcul des points :

- les points arrivant de unity sont brute de transformations, les calculs liés à la certitude ou à la difficulté ne sont pas encore faits à cette étape de la chaine.
La valeur est sous forme de % de réussite à une question, qui octroiera une quantité équivalente en points selon le score maximum de points d'une énigme, la certitude, et le ratio de chaque situation pro associées.
Ce calcul est opéré par la méthode compute_score_point().
Remarquer que la difficulté n'est pas compté dans ce calcul.
Une fois cette valeur déterminée, elle sera stockée dans la BDD avec toutes les informations pour pouvoir la recalculer.

- pour calculer le score à une compétence, on somme tous les scores des énigmes qui feature celle-ci.
en particulier, pour calculer le score d'une situation pro, on ne prend que la fraction du score qui nous intéresse, avant de sommer.

- les scores résultant d'opération de compétences ou de situation pro ne doivent pas être intégré en BDD, seuls les scores d'énigmes sans difficulté y sont autorisés.

- La difficulté sert de coefficient de pondération à la note. Il n'a donc pas intérêt à être calculé avec la note lors de la mise en BDD,
mais plutôt à servir sa représentation sur l'interface web. En effet, les notes des énigmes et le score maximum théorique sont multipliés par la difficulté,
mais ils ne sont pas à confondre avec une moyenne.
Ainsi, cette difficulté apparait dans les méthodes dédiées à l'affichage.

*/

function create_score($array_score)
{
  return new Score($array_score);
}

function add_score($db, Score $score, $etudiant_id, $enigme_id)
{
  if(!compute_score_points($db,$score,get_enigme($db,$enigme_id))){
    echo "compute_score_points a failed, le score n'a pas été ajouté";
    return false;
  }
  if(!score_exists($db, $score))
  {
    try {
      $db_req = $db->prepare(
        'INSERT INTO score
         (points, taux_de_succes, tentatives, temps, aide, etudiant_id, enigme_id)
         VALUES ('.$score->get_points().','.$score->get_taux_de_succes().','.$score->get_tentatives().','.$score->get_temps().','.$score->get_aide().', '.$etudiant_id.', '.$enigme_id.')');
      $db_req->execute();
      $score->set_id($db->lastInsertId());
      return true;
    }
    catch(PDOException $e) {
      echo "Insertion failed: " . $e->getMessage();
      return false;
    }
  }
  else { return false; }
}

function update_score($db, Score $score)
{
  if(score_exists($db, $score) && $score->get_id() != NULL)
  {
    try {
      $db_req = $db->prepare(
        'UPDATE score
         SET points = "'.$score->get_points().'", tentatives = '.$score->get_tentatives().', temps = '.$score->get_temps().', aide = '.$score->get_aide().'
         WHERE score.id = '.$score->get_id()
        );
      $db_req->execute();
      return true;
    }
    catch(PDOException $e) {
      echo "Update failed: " . $e->getMessage();
      return false;
    }
  }
  else { return false; }
}

function delete_score($db, Score $score)
{
  if(score_exists($db, $score))
  {
    try {
      $db_req = $db->prepare(
        'DELETE
         FROM score
         WHERE score.id = '.$score->get_id()
        );
      $db_req->execute();
      return true;
    }
    catch(PDOException $e) {
      echo "Deletion failed: " . $e->getMessage();
      return false;
    }
  }
  else { return false; }
}

function score_exists($db, Score $score)
{
  if ($score->get_id() != NULL)
  {
    try {
      $db_req = $db->prepare(
        'SELECT id
         FROM score
         WHERE score.id= '.$score->get_id()
        );
      $db_req->execute();
      $result = $db_req->fetchAll();
    }
    catch(PDOException $e) {
      echo "Selection failed: " . $e->getMessage();
      return false;
    }

    if ($result != NULL) { return true; }
    else { return false; }
  }
  else { return false; }
}
function compute_score_points($db,Score $score, $enigme){

  //prendre le taux dans model
  // prendre les ratios de SP dans la bdd
  // prendre le scoremax de l'enigme dans la bdd
  // appliquer tout
  // hydrater le score : en bdd ou le modele ?
  try {
    $db_req = $db->prepare('SELECT enigme.score_max,rel_enigme_situation_pro.ratio
      FROM enigme
      INNER JOIN rel_enigme_situation_pro ON rel_enigme_situation_pro.enigme_id = enigme.id
      WHERE enigme.id = '.$enigme->get_id()
    );
    $db_req->execute();
    $result = $db_req->fetchAll();
    // en théorie, c'est le même score_max qui apparait plusieurs fois par relation 1 score -> n situationpro
    if (!empty($result))
    {
      // recalcule du score
      $score["points"]=0;
      for ($i = 0; $i < count($result); ++$i)
      {
        $score["points"] += ($score->get_taux_de_succes()/100) * $result[$i]["score_max"] * ($result[$i]["ratio"] / 100);
        
      }
      return true;
    }
    else {
      return false;
    }
  }
  catch(PDOException $e) {
    echo "(compute_score_points) Selection failed: " . $e->getMessage();
    return false;
  }
}
function get_score($db, $id)
{
  try {
    $db_req = $db->prepare(
      'SELECT id, points, tentatives, temps, aide
       FROM score
       WHERE score.id = '.$id
      );
    $db_req->execute();
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      return create_score($result[0]);
    }
    else { return false; }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

function get_all_score($db)
{
  try {
    $db_req = $db->prepare(
      'SELECT *
       FROM score
       ORDER BY id'
      );
    $db_req->execute();
    $score_tab = [];
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      for ($i = 0; $i < count($result); ++$i)
      {
        $score_tab[] = create_score($result[$i]);
      }
      return $score_tab;
    }
    else { return false; }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
   }
}

function get_score_max_from_enigme($db, Enigme $enigme)
{
  $score = [
    "points" => $enigme->get_score_max(),
    "tentatives" => $enigme->get_tentatives_max(),
    "temps" => $enigme->get_temps_max()
  ];
  return create_score($score);
}

function get_score_max_from_competence_by_etudiant($db, Competence $competence, Etudiant $etudiant)
{
  try {
      $db_req = $db->prepare('SELECT score_max, difficulte
        FROM enigme
        INNER JOIN competence ON enigme.competence_id = competence.id
        INNER JOIN score ON score.enigme_id = enigme.id
        INNER JOIN etudiant ON enigme.id = score.etudiant_id
        WHERE etudiant.id = '.$etudiant->get_id().' AND competence.id = '.$competence->get_id() );
      $db_req->execute();
      $result = $db_req->fetchAll();

    $total = 0;
    if (!empty($result))
    {
      for ($x = 0; $x < count($result); ++$x)
      {
        // pondération par la difficulté
        $total += $result[$x]['score_max']*$result[$x]['difficulte'];
      }
      return $total;
    }
    else { return 0; }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

function get_score_max_from_competence($db, Competence $competence)
{
  try {
      $db_req = $db->prepare('SELECT score_max, difficulte
        FROM enigme
        INNER JOIN competence ON enigme.competence_id = competence.id
        WHERE competence.id = '.$competence->get_id() );
      $db_req->execute();
      $result = $db_req->fetchAll();

    $total = 0;
    if (!empty($result))
    {
      for ($x = 0; $x < count($result); ++$x)
      {
        // pondération par la difficulté
        $total += $result[$x]['score_max']*$result[$x]['difficulte'];
      }
      return $total;
    }
    else { return 0; }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

function get_score_max_from_situation_pro_by_etudiant($db, SituationPro $situation_pro, Etudiant $etudiant)
{
  try {
    $db_req = $db->prepare('SELECT enigme.score_max, rel_enigme_situation_pro.ratio,enigme.difficulte
      FROM enigme
      INNER JOIN score ON score.enigme_id = enigme.id
      INNER JOIN etudiant ON etudiant.id = score.etudiant_id
      INNER JOIN rel_enigme_situation_pro ON rel_enigme_situation_pro.enigme_id = enigme.id
      INNER JOIN situation_pro ON situation_pro.id = rel_enigme_situation_pro.situation_pro_id
      WHERE etudiant.id = '.$etudiant->get_id().' AND situation_pro.id = '.$situation_pro->get_id()
    );
    $db_req->execute();
    $result = $db_req->fetchAll();

    $total = 0;
    if (!empty($result))
    {
      for ($x = 0; $x < count($result); ++$x)
      {
        // pondération par la difficulté
        $total += $result[$x]['difficulte']*$result[$x]['score_max'] * $result[$x]['ratio'] / 100;
      }
      return $total;
    }
    else { return 0; }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

// Prend toutes les énigmes en bdd qui évalue $situation_pro
//, et somme les points maximum qu'on peut obtenir de chaque énigme
// pour avoir le score PERFECT sur $situation_pro

// Exemple = tu as 220/250 missile tank
function get_score_max_from_situation_pro($db, SituationPro $situation_pro)
{
  try {
    $db_req = $db->prepare('SELECT enigme.score_max, rel_enigme_situation_pro.ratio,enigme.difficulte
      FROM enigme
      INNER JOIN score ON score.enigme_id = enigme.id
      INNER JOIN rel_enigme_situation_pro ON rel_enigme_situation_pro.enigme_id = enigme.id
      INNER JOIN situation_pro ON situation_pro.id = rel_enigme_situation_pro.situation_pro_id
      WHERE situation_pro.id = '.$situation_pro->get_id()
    );
    $db_req->execute();
    $result = $db_req->fetchAll();

    $total = 0;
    if (!empty($result))
    {
      for ($x = 0; $x < count($result); ++$x)
      {
        // pondération par la difficulté
        $total += $result[$x]['difficulte']*$result[$x]['score_max'] * $result[$x]['ratio'] / 100;
      }
      return $total;
    }
    else { return 0; }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

function get_score_from_etudiant_on_enigme($db, Etudiant $etudiant, Enigme $enigme)
{
  try {
    $db_req = $db->prepare('SELECT score.id, points, tentatives, temps, aide, enigme.difficulte
      FROM score
      INNER JOIN etudiant ON etudiant.id = score.etudiant_id
      INNER JOIN enigme ON enigme.id = score.enigme_id
      WHERE etudiant.id = '.$etudiant->get_id().'
      AND enigme.id = '.$enigme->get_id()
    );
    $db_req->execute();
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      return create_score($result[0]);
    }
    else { return false; }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

function get_score_from_etudiant_on_competence($db, Etudiant $etudiant, Competence $competence)
{
  try {
    $db_req = $db->prepare('SELECT score.id, points, tentatives, temps, aide,enigme.difficulte
      FROM score
      INNER JOIN etudiant ON etudiant.id = score.etudiant_id
      INNER JOIN enigme ON enigme.id = score.enigme_id
      INNER JOIN competence ON competence.id = enigme.competence_id
      WHERE etudiant.id = '.$etudiant->get_id().'
      AND competence.id = '.$competence->get_id()
    );
    $db_req->execute();
    $score_tab = ["points" => 0, "tentatives" => 0, "temps" => 0, "aide" => 0];
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      for ($i = 0; $i < count($result); ++$i)
      {
        // pondération par difficulté
        $score_tab["points"] += $result[$i]["points"]*$result[$i]["difficulte"];
        $score_tab["tentatives"] += $result[$i]["tentatives"];
        $score_tab["temps"] += $result[$i]["temps"];
        $score_tab["aide"] += $result[$i]["aide"];
      }
      return create_score($score_tab);
    }
    else {
      $array = ['points' => 0, 'tentatives' => 0, 'temps' => 0, 'aide' => 0];
      return create_score($array); }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

function get_score_from_etudiant_on_situation_pro($db, Etudiant $etudiant, SituationPro $situation_pro)
{
  try {
    $db_req = $db->prepare('SELECT score.id, taux_de_succes, tentatives, temps, aide, rel_enigme_situation_pro.ratio, enigme.score_max,enigme.difficulte
      FROM score
      INNER JOIN etudiant ON etudiant.id = score.etudiant_id
      INNER JOIN enigme ON enigme.id = score.enigme_id
      INNER JOIN rel_enigme_situation_pro ON rel_enigme_situation_pro.enigme_id = enigme.id
      INNER JOIN situation_pro ON situation_pro.id = rel_enigme_situation_pro.situation_pro_id
      WHERE etudiant.id = '.$etudiant->get_id().' AND situation_pro.id = '.$situation_pro->get_id()
    );
    $db_req->execute();
    $score_tab = ["points" => 0, "tentatives" => 0, "temps" => 0, "aide" => 0];
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      for ($i = 0; $i < count($result); ++$i)
      {
        // pondération par difficulté
        $score_tab["points"] += ($result[$i]["taux_de_succes"]/100)* $result[$i]["score_max"] * ($result[$i]["ratio"] / 100) * $result[$i]["difficulte"];
        $score_tab["tentatives"] += $result[$i]["tentatives"];
        $score_tab["temps"] += $result[$i]["temps"];
        $score_tab["aide"] += $result[$i]["aide"];
      }
      return create_score($score_tab);
    }
    else {
      $array = ['points' => 0, 'tentatives' => 0, 'temps' => 0, 'aide' => 0];
      return create_score($array); }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

function get_moyenne_score_from_enigme($db, Enigme $enigme)
{
  try {
    $db_req = $db->prepare('SELECT points, tentatives, temps, aide, enigme.difficulte
      FROM score
      INNER JOIN enigme ON enigme.id = score.enigme_id
      AND enigme.id = '.$enigme->get_id()
    );
    $db_req->execute();
    $score_tab = ["points" => 0, "tentatives" => 0, "temps" => 0, "aide" => 0];
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      for ($i = 0; $i < count($result); ++$i)
      {
        // pondération par difficulté
        $score_tab["points"] += $result[$i]["points"]*$result[$i]["difficulte"];
        $score_tab["tentatives"] += $result[$i]["tentatives"];
        $score_tab["temps"] += $result[$i]["temps"];
        $score_tab["aide"] += $result[$i]["aide"];
      }
      $score_tab["points"] = round($score_tab["points"] / count($result), 2);
      $score_tab["tentatives"] = round($score_tab["tentatives"] / count($result), 2);
      $score_tab["temps"] = round($score_tab["temps"] / count($result), 2);
      $score_tab["aide"] = round($score_tab["aide"] / count($result), 2);
      return create_score($score_tab);
    }
    else { return create_score($score_tab); }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

function get_moyenne_score_from_competence($db, Competence $competence)
{
  try {
    $db_req = $db->prepare('SELECT points, tentatives, temps, aide,enigme.difficulte
      FROM score
      INNER JOIN enigme ON enigme.id = score.enigme_id
      INNER JOIN competence ON competence.id = enigme.competence_id
      WHERE competence.id = '.$competence->get_id()
    );
    $db_req->execute();
    $score_tab = ["points" => 0, "tentatives" => 0, "temps" => 0, "aide" => 0];
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      for ($i = 0; $i < count($result); ++$i)
      {
        $score_tab["points"] += $result[$i]["points"]*$result[$i]["difficulte"];
        $score_tab["tentatives"] += $result[$i]["tentatives"];
        $score_tab["temps"] += $result[$i]["temps"];
        $score_tab["aide"] += $result[$i]["aide"];
      }
      $score_tab["points"] = round($score_tab["points"] / count($result), 2);
      $score_tab["tentatives"] = round($score_tab["tentatives"] / count($result), 2);
      $score_tab["temps"] = round($score_tab["temps"] / count($result), 2);
      $score_tab["aide"] = round($score_tab["aide"] / count($result), 2);
      return create_score($score_tab);
    }
    else { return false; }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

function get_moyenne_score_from_situation_pro($db, SituationPro $situation_pro)
{
  try {
    $db_req = $db->prepare('SELECT taux_de_succes, tentatives, temps, aide, rel_enigme_situation_pro.ratio, enigme.score_max, enigme.difficulte
      FROM score
      INNER JOIN enigme ON enigme.id = score.enigme_id
      INNER JOIN rel_enigme_situation_pro ON rel_enigme_situation_pro.enigme_id = enigme.id
      INNER JOIN situation_pro ON situation_pro.id = rel_enigme_situation_pro.situation_pro_id
      WHERE situation_pro.id = '.$situation_pro->get_id()
    );
    $db_req->execute();
    $score_tab = ["points" => 0, "tentatives" => 0, "temps" => 0, "aide" => 0];
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      for ($i = 0; $i < count($result); ++$i)
      {
        $score_tab["points"] += $result[$i]["difficulte"] * $result[$i]["score_max"] * ($result[$i]["ratio"]/100) * ($result[$i]["taux_de_succes"]/100);
        $score_tab["tentatives"] += $result[$i]["tentatives"];
        $score_tab["temps"] += $result[$i]["temps"];
        $score_tab["aide"] += $result[$i]["aide"];
      }
      $score_tab["points"] = round($score_tab["points"] / count($result), 2);
      $score_tab["tentatives"] = round($score_tab["tentatives"] / count($result), 2);
      $score_tab["temps"] = round($score_tab["temps"] / count($result), 2);
      $score_tab["aide"] = round($score_tab["aide"] / count($result), 2);
      return create_score($score_tab);
    }
    else { return create_score($score_tab); }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

 ?>
