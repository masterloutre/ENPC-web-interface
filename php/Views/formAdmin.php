<?php
require "../Global/global.php";
require_once ("../Controllers/EtudiantController.php");
require_once ("../Controllers/EnseignantController.php");
require_once ("../Controllers/EnigmeController.php");
require_once ("../Controllers/LancementJeuController.php");
require_once ("../Controllers/SituationProController.php");
?>
     
<div class="wrapper">
<?php
    if(!array_key_exists('item', $_GET)){
        header("Refresh:0; url=index.php?action=interface-admin");
    }else{
        if(!array_key_exists('id', $_GET)){ ?>

        <h3>Ajouter <?php echo $_GET['item']; ?></h3>

        <?php $method = 'create_'.ucfirst($_GET['item']);
        $empty = $method(array());
        //var_dump($empty); ?>

        <!-- AJOUT -->
        <form action="../Views/add.php?item=<?php echo $_GET['item']; ?>" method="POST">
           <?php $empty = $empty->get_vars();
            foreach($empty as $key => $value): ?>
                <label for="<?php echo $key; ?>"><?php echo $key; ?></label>
                <?php if($_GET['item'] == 'enigme' && $key == 'type'): ?>
                    <select name="<?php echo $key; ?>">
                        <option value="1">QCM</option>
                        <option value="2">Input</option>
                        <option value="3">Algo</option>
                    </select>
                <?php else : ?>
                    <input type="text" name="<?php echo $key; ?>" required>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if($_GET['item'] == 'enigme'): ?>
               <label for="competence">Competence</label>
                <input type="radio" name="competence" value="<?php echo $competence1->get_id(); ?>" checked> <?php echo $competence1->get_nom(); ?>
                <input type="radio" name="competence" value="<?php echo $competence2->get_id(); ?>"> <?php echo $competence2->get_nom(); ?>
            <?php endif; ?>
            <input type="submit" value="Ajouter">
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
        } ?>

        <!-- MODIF -->
        <form action="../Views/update.php?item=<?php echo $_GET['item']; ?>" method="POST">
           <?php $object = $object->get_vars();
                    if($_GET['item'] == 'enigme'){
                unset($object['competence']);
            }
            foreach($object as $key => $value): ?>
                <label for="<?php echo $key; ?>"><?php echo $key; ?></label>
                <?php if($_GET['item'] == 'enigme' && $key == 'type'): ?>
                    <select name="<?php echo $key; ?>">
                        <option value="1" <?php if($value == "QCM"){echo "selected";}?> >QCM</option>
                        <option value="2" <?php if($value == "Input"){echo "selected";}?> >Input</option>
                        <option value="3" <?php if($value == "Algo"){echo "selected";}?> >Algo</option>
                    </select>
                <?php else : ?>
                    <input type="text" name="<?php echo $key; ?>" value="<?php echo $value; ?>" required>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if($_GET['item'] == 'enigme'): ?>
               <label for="competence">Competence</label>
                <input type="radio" name="competence" value="<?php echo $competence1->get_id(); ?>"<?php if($competence == $competence1){echo "checked";} ?>> <?php echo $competence1->get_nom(); ?>
                <input type="radio" name="competence" value="<?php echo $competence2->get_id(); ?>"<?php if($competence == $competence2){echo "checked";} ?>> <?php echo $competence2->get_nom(); ?>
            <?php endif; ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <input type="submit" value="Modifier">
        </form>

        <?php } ?>

        <a class="button" href="index.php?action=interface-admin&vue=liste&item=<?php echo $_GET['item']; ?>">Retour à la liste</a>
        
        <script src="../Public/verif_<?php echo $_GET['item']; ?>.js"></script>

<?php } ?>
</div>
