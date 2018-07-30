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
    
        <a class="button" href="index.php?action=interface-admin">Modifier une autre liste</a>
        
        

        <form action="./index.php?action=interface-admin&admin=multiple_update&item=<?php echo $_GET['item']; ?>" method="POST">
            <!-- Bouton de modification-->
            <div>
                <input type="submit" value="Modifier" > 
                <!-- <a class="button" href="" disabled> Activer par ...</a>
                    <select style="display:inline;" name="filtre">
                        <option value="1">QCM</option>
                        <option value="2">Input</option>
                        <option value="3">Algo</option>
                    </select> -->
            </div>
    
            <!-- On récupère tout de la bdd en composant le nom de la méthode avec l'item-->
            <?php 

            $method = 'get_all_'.ucfirst($_GET['item']);
            $list = $method($db); 
            // pour avoir active checkbox sur la première colonne
            $size = count($list);
            $items_array= array();
            for($i=0;$i<$size;$i++) {
                $items_array[$i]= $list[$i]->get_vars();
                $temp= array();
                $temp['active'] = $items_array[$i]['active'];
                unset($items_array[$i]['active']);
                $items_array[$i]=array_merge($temp,$items_array[$i]);
                
            }
            
            ?>
            
            <!-- table head -->
            <table>
                <!-- Intitulé des colonnes du tableau -->
                <tr>
                    <?php 
                    $headers = $items_array[0];
                    foreach($headers as $key => $value):
                    ?>
                    
                        <th><?php echo $key; ?></th>
                    
                    <?php endforeach; ?>
                    
                </tr>
    
                <!-- Valeurs des entrées -->
                <?php
                $i=0;
                foreach($items_array as $item):

                ?>
                    <tr>
                        <?php 
        
                        $id = $item['id'];
                        //if($_GET['item'] == 'enseignant'){ $admin = $item->get_admin(); }
                        //if($_GET['item'] == 'enigme'){ $situPro = get_situation_pro_from_enigme($db, $item); }
            
                        
                        foreach($item as $key => $value): 
                        ?>
            
                            <td>
                                <!-- Valeur des cases -->
                                
                                <!--  -->
                                <?php if($_GET['item'] == 'enigme' && $key == 'active'){
                                    if($value){ $checked= "checked"; }
                                    else{ $checked= "unchecked"; }
                                ?>
                                    <input class="enable" type="checkbox" name="<?php echo 'active['.$i.']' ?>" <?php echo $checked ?> >

                                <?php
                                }else{
                                ?>
                                    <input class="enable" type="text" name="<?php echo $key.'['.$i.']' ?>" value="<?php echo $value?>" readonly>
                                    
                                <?php } ?>
                            </td>
            
                        <?php endforeach;?>
            
                        
                    </tr>
                <?php 
                $i++;
                endforeach; ?>
            </table>
        </form>

    <?php } ?>
</div>
