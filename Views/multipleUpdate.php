﻿<?php

require "./Global/connect.php";

if(!array_key_exists('item', $_GET)){
    echo "erreur pas de clé item dans GET";
    header("Refresh:0; url=./index.php?action=interface-admin");
}else{
    //echo "VOICI POST AVANT:<br>";
    //print_r($_POST);
    $size= count($_POST["id"]);
    $content = array();
    for($i=0;$i<$size;$i++){
        $entry = array();
        foreach ($_POST as $key => $value) {
            if($key == "active"){
                if(!array_key_exists($i, $value)){
                    $value[$i]=0;
                }else{
                    $value[$i]=1;
                }
            }
            $entry[$key]=$value[$i];
            
        }
        $entry["competence"]=$entry["competence_id"];

        $situation_pro_ratio = get_ratio_situation_pro_enigme($db,$entry["id"]);
        foreach ($situation_pro_ratio as $sp) {
            $entry["situation_pro".$sp["situation_pro_id"]]=$sp["ratio"];
        }
        $content[$i]=$entry;

    }
    $i=0;
    //echo "VOICI POST APRES:<br>";
    foreach ($content as $entry) {
        $_POST= $content[$i];
        //print_r($_POST);
        require('./Views/update.php');
        $i++;
        //echo "Appel exécuté $i<br>";
        
    }
    
}

?>