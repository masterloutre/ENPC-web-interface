<?php
/* ENIGME */

require "./Global/connect.php";
require "./Global/global.php";
require_once "./Models/Enigme.php";
require_once "./Models/Etudiant.php";
require_once "./Models/Competence.php";

/* FONCTIONS BASIQUE DE BDD*/


function create_enigme($array_enigme)
{
  return new Enigme($array_enigme);
}

function add_enigme($db, Enigme $enigme)
{
  if(!enigme_exists($db, $enigme))
  {
    try {
      $db_req = $db->prepare('INSERT INTO enigme
        (index_unity, type, nom, temps_max, difficulte, score_max, tentatives_max, competence_id, active)
        VALUES ('.$enigme->get_index_unity().','.$enigme->get_type().',"'.$enigme->get_nom().'",'.$enigme->get_temps_max().','.$enigme->get_difficulte().','.$enigme->get_score_max().','.$enigme->get_tentatives_max().','.$enigme->get_competence()->get_id().','.$enigme->get_active().')');
      $db_req->execute();
      $enigme->set_id($db->lastInsertId());
      return true;
    }
    catch(PDOException $e) {
      echo "Enigma Insertion failed: " . $e->getMessage();
      return false;
    }
  }
  else { return false; }
}

function update_enigme($db, Enigme $enigme)
{
  if(enigme_exists($db, $enigme) && $enigme->get_id() != NULL)
  {
    try {
      
      $db_req = $db->prepare('UPDATE enigme
        SET index_unity = '.$enigme->get_index_unity().
        ', type = '.$enigme->get_type().
        ', nom = "'.$enigme->get_nom().
        '", temps_max = '.$enigme->get_temps_max().
        ', difficulte = '.$enigme->get_difficulte().
        ', score_max = '.$enigme->get_score_max().
        ', tentatives_max = '.$enigme->get_tentatives_max().
        ', competence_id = '.$enigme->get_competence()->get_id().
        ', active ='.$enigme->get_active().
        ' WHERE enigme.id = '.$enigme->get_id()
        );
      $db_req->execute();
      return true;
    }
    catch(PDOException $e) {
      echo "Update failed: " . $e->getMessage();
      return false;
    }
  }
  else { echo "Updating non-existing Enigma" ; return false; } //WTF
}

function delete_enigme($db, Enigme $enigme)
{
  if(enigme_exists($db, $enigme))
  {
    try {
        //delete score correspondant à l'enigme
        $db_req = $db->prepare('DELETE
        FROM score
        WHERE enigme_id = '.$enigme->get_id()
        );
      $db_req->execute();

        delete_ratio_situation_pro_enigme($db, $enigme);

        //delete enigme
      $db_req = $db->prepare('DELETE
        FROM enigme
        WHERE enigme.id = '.$enigme->get_id()
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

function enigme_exists($db, Enigme $enigme)
{
  try {
    $db_req = $db->prepare('SELECT id
      FROM enigme
      WHERE enigme.id = '.$enigme->get_id()
      );
    $db_req->execute();
    $result = $db_req->fetchAll();
  }
  catch(PDOException $e) {
    echo "Enigma existence error, id is uncomplete: " . $e->getMessage();
    return false;
  }

  if ($result != NULL) { return true; }
  else { return false; }
}

function get_enigme($db, $id)
{
  try {
    $db_req = $db->prepare('SELECT id, index_unity, type, nom, temps_max, difficulte, score_max, tentatives_max, competence_id, active
      FROM enigme
      WHERE enigme.id = '.$id
      );
    $db_req->execute();
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      $result[0]["competence"] = get_competence($db, $result[0]["competence_id"]);
      return create_enigme($result[0]);
    }
    else { return false; }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

function get_all_enigme($db)
{
  try {
    $db_req = $db->prepare('SELECT id, index_unity, type, nom, temps_max, difficulte, score_max, tentatives_max, competence_id, active
      FROM enigme
      ORDER BY id'
      );

    $db_req->execute();
    $enigme_tab = [];
    $result = $db_req->fetchAll();

    if (!empty($result))
    {
      for ($i = 0; $i < count($result); ++$i)
      {
        $result[$i]["competence"] = get_competence($db, $result[$i]["competence_id"]);
        $enigme_tab[] = create_enigme($result[$i]);
      }
      return $enigme_tab;
    }
    else { return false; }

  }
  catch(PDOException $e) {
    echo "Selections failed: " . $e->getMessage();
    return false;
  }

}





// Renvoie un tableau d'objet Enigme de toutes les énigmes en BDD ayant le même type
function get_all_enigme_by_type($db, int $type)
{
  try {
    $db_req = $db->prepare('SELECT id, index_unity, type, nom, temps_max, difficulte, score_max, tentatives_max, competence_id
      FROM enigme
      WHERE type = '.$type .'
      ORDER BY id'
      );

    $db_req->execute();
    $enigme_tab = [];
    $result = $db_req->fetchAll();

    if (!empty($result))
    {
      for ($i = 0; $i < count($result); ++$i)
      {
        $result[$i]["competence"] = get_competence($db, $result[$i]["competence_id"]);
        $enigme_tab[] = create_enigme($result[$i]);
      }
      return $enigme_tab;
    }
    else { return false; }

  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }

}

// Renvoie un tableau d'objet Enigme de toutes les énigmes actives en BDD
function get_all_active_enigme($db)
{
  try {
    $db_req = $db->prepare('SELECT id, index_unity, type, nom, temps_max, difficulte, score_max, competence_id
      FROM enigme
      WHERE active = 1
      ORDER BY id'
      );

    $db_req->execute();
    $enigme_tab = [];
    $result = $db_req->fetchAll();

    if (!empty($result))
    {
      for ($i = 0; $i < count($result); ++$i)
      {
        $result[$i]["competence"] = get_competence($db, $result[$i]["competence_id"]);
        $enigme_tab[] = create_enigme($result[$i]);
      }
      return $enigme_tab;
    }
    else { 
      echo "No enigma available for game session.";
      return [];
    }

  }
  catch(PDOException $e) {
    echo "[get_all_active_enigme] failed: " . $e->getMessage();
    return [];
  }

}

// Renvoie un tableau d'objet Enigme de toutes les énigmes résolues par un étudiant en BDD
function get_all_enigme_from_etudiant($db, Etudiant $etudiant)
{
  try {
    $db_req = $db->prepare('SELECT enigme.id, index_unity, type, nom, temps_max, difficulte, score_max, competence_id
      FROM enigme
      INNER JOIN score ON enigme.id = score.enigme_id
      WHERE score.etudiant_id = '.$etudiant->get_id().' ORDER BY id'
      );
    $db_req->execute();
    $enigme_tab = [];
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      for ($i = 0; $i < count($result); ++$i)
      {
        $result[$i]["competence"] = get_competence($db, $result[$i]["competence_id"]);
        $enigme_tab[] = create_enigme($result[$i]);
      }
      return $enigme_tab;
    }
    else { return false; }
  }
  catch(PDOException $e) {
    echo "Selection failed: " . $e->getMessage();
    return false;
  }
}

// Renvoie un tableau d'objet Enigme de toutes les énigmes évaluant une compétence
function get_enigme_by_competence($db, Competence $comp)
{
  try {
    $db_req = $db->prepare('SELECT enigme.id, index_unity, type, nom, temps_max, difficulte, score_max, competence_id
      FROM enigme
      WHERE enigme.competence_id = '.$comp->get_id().
      ' ORDER BY id'
      );
    $db_req->execute();
    $enigme_tab = [];
    $result = $db_req->fetchAll();
    if (!empty($result))
    {
      for ($i = 0; $i < count($result); ++$i)
      {
        $result[$i]["competence"] = get_competence($db, $result[$i]["competence_id"]);
        $enigme_tab[] = create_enigme($result[$i]);
      }
      return $enigme_tab;
    }
    else { 
      "Aucune énigme ne possède cette compétence.";
      return [];
    }
  }
  catch(PDOException $e) {
    echo "[get_enigme_by_competence] failed: " . $e->getMessage();
    return [];
  }
}

// Supprime toutes les informations de pondération de SP sur une énigme
function delete_ratio_situation_pro_enigme($db, Enigme $enigme){

    try{
        $db_req = $db->prepare('DELETE
        FROM rel_enigme_situation_pro
        WHERE enigme_id = '.$enigme->get_id()
        );
        $db_req->execute();
    }
    catch(PDOException $e) {
        echo "Selection failed: " . $e->getMessage();
        return false;
    }
}






 ?>
