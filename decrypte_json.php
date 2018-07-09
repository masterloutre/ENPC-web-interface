<?php

$json_source = file_get_contents("save_test.json"); 
$json_data = json_decode($json_source);

try{
    $BDD = new PDO('mysql:host=localhost;dbname=enpc','root','');
}
catch(Exception $e){
    die('error : '.$e->getMessage());
}

foreach($json_data->scores as &$score){
    $enigme = enigme_exists($BDD, $score->nom);

    if(!$enigme){
        echo "<br>l'enigme n'existe pas !<br>";
    }else{
        echo "<br>l'énigme a bien été trouvée !<br>";
    }

    $etudiant = etudiant_exists($BDD, $score->etudiant);

    if(!$etudiant){
        echo "<br>l'etudiant n'existe pas !<br>";
    }else{
        echo "<br>l'etudiant a bien été trouvé !<br>";
    }

    $prevScore = score_exists($BDD, $etudiant, $enigme);

    if(!$prevScore){
        add_score($BDD, $score, $etudiant, $enigme);
        echo "<br>score ajouté en bdd !<br>";
    }else{
        echo "<br>le score existe déjà en bdd !<br>";
    }
}

//var_dump($json_data->scores[1]->competences[1]);

//à modifier pour plutôt utiliser "index_unity"
function enigme_exists(PDO $BDD, $nomEnigme){
    $bdd_req = $BDD->prepare('SELECT id FROM `enigme` WHERE nom = '."\"".$nomEnigme."\"");
    $bdd_req->execute();
    
    $result = $bdd_req->fetchAll();
    if($result == NULL){
        return 0;
    }else{
        return $result[0]['id'];
    }    
}

function etudiant_exists(PDO $BDD, $numEtud){
    $bdd_req = $BDD->prepare('SELECT id FROM `etudiant` WHERE num_etud = '."\"".$numEtud."\"");
    $bdd_req->execute();
    
    $result = $bdd_req->fetchAll();
    if($result == NULL){
        return 0;
    }else{
        return $result[0]['id'];
    }    
}

//à voir quand l'utiliser exactement pour éviter de reparcourir tout le json à chaque envoi
function score_exists(PDO $BDD, $etudiant, $enigme){
    $bdd_req = $BDD->prepare('SELECT id FROM `score` WHERE etudiant_id = '.$etudiant.' AND enigme_id = '.$enigme);
    $bdd_req->execute();
    
    $result = $bdd_req->fetchAll();
    if($result == NULL){
        return 0;
    }else{
        return $result[0]['id'];
    }    
}

function add_score(PDO $BDD, $score, $etudiant, $enigme){
    $bdd_req = $BDD->prepare('INSERT INTO `score`(`id`, `etudiant_id`, `enigme_id`, `points`, `tentatives`, `temps`, `aide`) VALUES (NULL,:etudiant,:enigme,:points,:tentatives,:temps,:aide)');
    $bdd_req->bindParam(':etudiant', $etudiant, PDO::PARAM_STR,60);
    $bdd_req->bindParam(':enigme', $enigme, PDO::PARAM_STR,60);
    $bdd_req->bindParam(':points', $score->points, PDO::PARAM_STR,60);
    $bdd_req->bindParam(':tentatives', $score->tentatives, PDO::PARAM_STR,60);
    $bdd_req->bindParam(':temps', $score->temps, PDO::PARAM_STR,60);
    $bdd_req->bindParam(':aide', $score->aideExt, PDO::PARAM_STR,60);
    $bdd_req->execute();
}

?>