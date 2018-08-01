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

    <?php if($_GET['item']=="enigme"){?>
        <a class="button" href="<?php echo 'index.php?action=interface-admin&vue=enable&item='.$_GET['item']; ?>">Activer plusieurs énigmes</a>
    <?php }?>
    <!-- On récupère tout de la bdd en composant le nom de la méthode avec l'item-->
    <?php $method = 'get_all_'.ucfirst($_GET['item']);
    $list = $method($db); ?>

    <!-- table head -->
    <table>
        <tr>
           <?php $headers = $list[0]->get_vars();
           //print_r($headers);
            if($_GET['item']=='enigme'){ $headers['situation_pro']='';unset($headers['tentatives_max']); }
            foreach($headers as $key => $value):?>
            <th><?php echo $key; ?></th>
            <?php endforeach; ?>
            <th colspan="2"></th>
        </tr>
        <!-- table content -->
        <?php foreach($list as $item): ?>
        <tr>
           <?php $id = $item->get_id();
            $item = $item->get_vars();
            if($_GET['item'] == 'enseignant'){
                $admin = $item['admin'];
            }
            if($_GET['item'] == 'enigme'){
                unset($item['tentatives_max']);
                $item['situation_pro']='';
            }
            foreach($item as $key => $value): ?>

                <td>
                    <!-- valeur des cases -->
                    
                    <!-- si en plus on a des compétences à afficher -->
                    <?php if($_GET['item'] == 'enigme'){
                        if($key == 'active'){
                            if($value){ echo "true"; }
                            else{ echo "false"; }
                        }
                        else if($key == 'situation_pro'){
                            $sps=get_ratio_situation_pro_enigme($db,$item['id']);
                            foreach ($sps as $sp) {
                                echo get_situation_pro($db,$sp['situation_pro_id'])->get_nom().': '.$sp['ratio'].'%'.'<br>';
                            }
                        }
                        else{
                            echo $value;
                        }
                    }else{
                        echo $value;
                    }
                    ?>
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
