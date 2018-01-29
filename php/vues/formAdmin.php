<?php
require("../Controllers/EtudiantController.php");
require("../Controllers/EnseignantController.php");
require("../Controllers/EnigmeController.php");
require("../Controllers/LancementJeuController.php");
require("../Controllers/SituationProController.php");
?>

<!DOCTYPE html>
<html>
   <head>
       <title>Interface Ajout Admin</title>
       <link rel="stylesheet" href="../../css/font-awesome.css">
       <style>
           body{
               text-transform: capitalize;
               font-family: sans-serif;
           }
           .wrapper{
               margin: 0 auto;
               width: max-content;
           }
           input{
               display: block;
               margin: 5px 0 20px;
               width: 300px;
               padding: 3px 0;
           }
           input[type='submit']{
               border-style: solid;
           }
           a{
               text-decoration: none;
               color: black;
           }
           a:visited{
               color: black;
           }
           .button{
               margin: 20px 0;
               border: 1px solid black;
               padding: 5px 10px;
               display: inline-block;
               text-transform: none;
           }
       </style>
   </head>
   
    <body>
      <div class="wrapper">
       <?php
            if(!array_key_exists('item', $_GET)){
                header("Refresh:0; url=homeAdmin.php");
            }else{
                if(!array_key_exists('id', $_GET)){ ?>
        
                <h1>Ajouter <?php echo $_GET['item']; ?></h1>

                <?php $method = 'create_'.ucfirst($_GET['item']);
                $empty = $method(array());
                //var_dump($empty); ?>

                <!-- AJOUT -->
                <form action="add.php?item=<?php echo $_GET['item']; ?>" method="POST">
                   <?php $empty = $empty->get_vars();
                    foreach($empty as $key => $value): ?>
                        <label for="<?php echo $key; ?>"><?php echo $key; ?></label>
                        <input type="text" name="<?php echo $key; ?>">
                    <?php endforeach; ?>
                    <?php if($_GET['item'] == 'enigme'): ?>
                        <input type="radio" name="competence" value="<?php echo $competence1->get_id(); ?>"> <?php echo $competence1->get_nom(); ?>
                        <input type="radio" name="competence" value="<?php echo $competence2->get_id(); ?>"> <?php echo $competence2->get_nom(); ?>
                    <?php endif; ?>
                    <input type="submit" value="Ajouter">
                </form>

                <?php }else{ ?>

                <h1>Modifier <?php echo $_GET['item']; ?></h1>

                <?php $method = 'get_'.ucfirst($_GET['item']);
                $object = $method($db, $_GET['id']);

                if($object == NULL){
                    unset($_GET['id']);
                    header("Refresh:0; url=listeAdmin.php?item=".$_GET['item']);
                }
                            
                if($_GET['item'] == "enigme"){
                    $competence = $object->get_competence();
                } ?>

                <!-- MODIF -->
                <form action="update.php?item=<?php echo $_GET['item']; ?>" method="POST">
                   <?php $object = $object->get_vars();
                    foreach($object as $key => $value): ?>
                        <label for="<?php echo $key; ?>"><?php echo $key; ?></label>
                        <input type="text" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
                    <?php endforeach; ?>
                    <?php if($_GET['item'] == 'enigme'): ?>
                        <input type="radio" name="competence" value="<?php echo $competence1->get_id(); ?>"<?php if($competence == $competence1){echo "checked";} ?>> <?php echo $competence1->get_nom(); ?>
                        <input type="radio" name="competence" value="<?php echo $competence2->get_id(); ?>"<?php if($competence == $competence2){echo "checked";} ?>> <?php echo $competence2->get_nom(); ?>
                    <?php endif; ?>
                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                    <input type="submit" value="Modifier">
                </form>
        
                <?php } ?>
                
                <a class="button" href="listeAdmin.php?item=<?php echo $_GET['item']; ?>">Retour à la liste</a>
                
        <?php } ?>
        </div>
    </body>
</html>