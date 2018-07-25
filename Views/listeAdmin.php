<?php
require_once ("./Controllers/EtudiantController.php");
require_once ("./Controllers/EnseignantController.php");
require_once ("./Controllers/CompetenceController.php");
require_once ("./Controllers/EnigmeController.php");
require_once ("./Controllers/LancementJeuController.php");
require_once ("./Controllers/SituationProController.php");
?>


<div class="wrapper">
<?php
    // Renvoie vers la page principale de interface admin si item n'existe pas
    if(!array_key_exists('item', $_GET)){
        header("Refresh:0; url=index.php?action=interface-admin");
    }else{ ?>

    <h3>Catalogue <?php echo $_GET['item']; ?></h3>

    <!-- Bouton d'ajout -->
    <a class="button" href="<?php echo 'index.php?action=interface-admin&vue=form&item='.$_GET['item']; ?>">Ajouter <?php echo $_GET['item']; ?></a>
    
    <!-- Bouton de modification-->
    <a class="button" href="index.php?action=interface-admin">Modifier une autre liste</a>

    <!-- On récupère tout de la bdd en composant le nom de la méthode avec l'item-->
    <?php $method = 'get_all_'.ucfirst($_GET['item']);
    $list = $method($db); ?>

    <!-- table head -->
    <table>
        <tr>
           <?php $headers = $list[0]->get_vars();
            foreach($headers as $key => $value): ?>
            <th><?php echo $key; ?></th>
            <?php endforeach; ?>
            <th colspan="2"></th>
        </tr>
        <!-- table content -->
        <?php foreach($list as $item): ?>
        <tr>
           <?php $id = $item->get_id();
          if($_GET['item'] == 'enseignant'){ $admin = $item->get_admin(); }
          if($_GET['item'] == 'enigme'){ $situPro = get_situation_pro_from_enigme($db, $item); }

            $item = $item->get_vars();
            foreach($item as $key => $value): ?>

                <td>
                    <!-- valeur des cases -->
                    <?php echo $value; ?>
                    <!-- si en plus on a des compétences à afficher -->
                    <?php if($_GET['item'] == 'enigme' && $key == 'competence'){
                    echo '<div class="situation_pro_bar"> <div class="flex-container">';
                        for ($y = 0; $y < count($situPro); ++$y)
                          {
                            echo '<span data-size="'.$situPro[$y]->get_ratio().'"></span>';
                          }
                    echo '</div> </div>';
                    } ?>
                </td>

            <?php endforeach;
            // icone pour modifier/supprimer en fin de tableau
            $modif_link = "index.php?action=interface-admin&vue=form&item=".$_GET['item']."&id=".$id;
            $delete_link = "./index.php?action=interface-admin&admin=delete&item=".$_GET['item']."&id=".$id; ?>

            <td><a href="<?php echo $modif_link; ?>"><i class="fa fa-pencil"></i></a></td>
                <td>
                <?php if(!isset($admin) || $admin != 1): ?>
                <a href="<?php echo $delete_link; ?>"><i class="fa fa-trash-o"></i></a>
                <?php endif; ?>
                </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <?php } ?>
</div>
