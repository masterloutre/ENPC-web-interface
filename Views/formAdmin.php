<?php
require "./Global/global.php";
require_once ("./Controllers/EtudiantController.php");
require_once ("./Controllers/EnseignantController.php");
require_once ("./Controllers/EnigmeController.php");
require_once ("./Controllers/LancementJeuController.php");
require_once ("./Controllers/SituationProController.php");
?>
<!-- FORMULAIRE GENERIQUE POUR MODIFICATION EN BDD
  Utilisé en interface admin
-->
<div class="wrapper">
<?php
    if(!array_key_exists('item', $_GET)){
        header("Refresh:0; url=index.php?action=interface-admin");
    }else{
        if(!array_key_exists('id', $_GET)){ ?>

        <h3>Ajouter <?php echo $_GET['item']; ?></h3>

        <?php $method = 'create_'.ucfirst($_GET['item']);
        $empty = $method(array());
        ?>

        <!-- AJOUT -->
        <form action="./index.php?action=interface-admin&admin=add&item=<?php echo $_GET['item']; ?>" method="POST">
           <?php $empty = $empty->get_vars();
           unset($empty['id']);
               if($_GET['item'] == 'enigme'){
                   unset($empty['score_max']);
               }

            foreach($empty as $key => $value): ?>
              <!-- Input classique -->
               <div>
                <label for="<?php echo $key; ?>"><?php echo $key; ?></label>
                <!-- Si gestion d'énigmes et si on est sur l'input du type, on crée un sélecteur -->
                <?php if($_GET['item'] == 'enigme' && $key == 'type'): ?>
                    <select name="<?php echo $key; ?>">
                        <option value="1">QCM</option>
                        <option value="2">Input</option>
                        <option value="3">Algo</option>
                    </select>

                    <!-- Sinon champ d'input normal-->
                <?php else :?>
                    <input type="text" name="<?php echo $key; ?>" required>
                
                <?php endif; ?>
                </div>

            <?php endforeach; ?>

            <?php if($_GET['item'] == 'enigme'): ?>
             <!-- Competences pour une enigme -->
              <div>
               <label for="competence">Competence</label>
                <?php foreach ($competences_tab as $cp) { ?>
                    <input type="radio" name="competence" value="<?php echo $cp->get_id(); ?>" onchange="<php? $skill =$cp;" checked> <p><?php echo $cp->get_nom(); ?></p>
                <?php } ?>
                </div>

                <!-- Situations professionnelles pour une enigme -->
               <div>
               <label for="situation_pro">Situations Professionnelles</label>
               <?php 
               
               foreach ($situation_pro_tab as $sp) { ?>
                    <input type="number" step="5" min="0" max="100" name="situation_pro<?php echo $sp->get_id();?>" data-id="<?php echo $sp->get_id(); ?>">
                    <p><?php echo $sp->get_nom(); ?></p>
               <?php } ?>
                
                </div>
            <?php endif; ?>

            <!-- fin ADD form -->
            <div><input type="submit" value="Ajouter"></div>
        </form>

        <?php }else{ ?>

        <h3>Modifier <?php echo $_GET['item']; ?></h3>

        <?php $method = 'get_'.ucfirst($_GET['item']);
        $object = $method($db, $_GET['id']);

        if($object == NULL){
            unset($_GET['id']);
            header("Refresh:0; url=index.php?action=interface-admin&vue=liste&item=".$_GET['item']);
        }

        if($_GET['item'] == "enigme"){
            $competence = $object->get_competence();
            $situation_pro = get_situation_pro_from_enigme($db, $object);
            
        } ?>

        <!-- MODIF -->
        <form action="./index.php?action=interface-admin&admin=update&item=<?php echo $_GET['item']; ?>" method="POST">
           <?php $object = $object->get_vars();
                if($_GET['item'] == 'enigme'){
                    unset($object['competence']);
                    unset($object['score_max']);
                }

            foreach($object as $key => $value): ?>
              <!-- Input classique et gestion type enigme -->
               <div>
                <label for="<?php echo $key; ?>"><?php echo $key; ?></label>
                <?php if($_GET['item'] == 'enigme' && $key == 'type'): ?>
                    <select name="<?php echo $key; ?>">
                        <option value="1" <?php if($value == "QCM"){echo "selected";}?> >QCM</option>
                        <option value="2" <?php if($value == "Input"){echo "selected";}?> >Input</option>
                        <option value="3" <?php if($value == "Algo"){echo "selected";}?> >Algo</option>
                    </select>
                
                <?php else :
                  if($key=="id"){?>                
                    <input type="text" name="<?php echo $key; ?>" value="<?php echo $value; ?>" disabled="disabled">
                  <?php }else{ ?> 
                    <input type="text" name="<?php echo $key; ?>" value="<?php echo $value; ?>" required>
                  <?php } ?> 
                  
                <?php endif; ?>
                </div>

            <?php endforeach; ?>

            <?php if($_GET['item'] == 'enigme'): ?>
             <!-- Competences pour une enigme -->
              <div>
               <label for="competence">Competence</label>
               <?php foreach ($competences_tab as $cp) { ?>
                    <input type="radio" name="competence" value="<?php echo $cp->get_id(); ?>" <?php if($competence == $cp){echo "checked";} ?>> <p><?php echo $cp->get_nom(); ?></p>
               <?php } ?>
              </div>

                <!-- Situations professionnelles pour une enigme -->
                <div>
               <label for="situation_pro">Situations Professionnelles</label>
                
                <?php foreach ($situation_pro_tab as $sp) { ?>
                    <input type="number" step="5" min="0" max="100" name="situation_pro<?php echo $sp->get_id();?>"
                    <?php for($i=0; $i<count($situation_pro); $i++){
                        if($situation_pro[$i]->get_id() == $sp->get_id()){
                            echo 'value="'.$situation_pro[$i]->get_ratio().'"';
                        }
                    }?>
                    data-id="<?php echo $sp->get_id(); ?>">
                    <p><?php echo $sp->get_nom(); ?></p>
    
                <?php } ?>

                </div>
            <?php endif; ?>

            <!-- Garde id dans hidden et fin MODIF form -->
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <div><input type="submit" value="Modifier"></div>
        </form>

        <?php } ?>

        <a class="button" href="index.php?action=interface-admin&vue=liste&item=<?php echo $_GET['item']; ?>">Retour à la liste</a>

        <script src="./Public/js/verif_<?php echo $_GET['item']; ?>.js"></script>

<?php } ?>
</div>
