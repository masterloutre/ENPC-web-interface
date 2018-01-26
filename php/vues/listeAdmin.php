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
       <title>Test Interface Admin</title>
       <link rel="stylesheet" href="../../css/font-awesome.css">
       <style>
           body{
               text-transform: capitalize;
               font-family: sans-serif;
           }
           table, th, td{
               border: 1px solid black;
               border-collapse: collapse;
               padding: 15px 30px;
           }
           a{
               text-decoration: none;
           }
           a:visited{
               color: black;
           }
           #add{
               margin: 20px 0;
               border: 1px solid black;
               padding: 5px 10px;
               display: inline-block;
           }
           .wrapper{
               margin: 0 auto;
               width: max-content;
           }
       </style>
   </head>
   
    <body>
      <div class="wrapper">
       <?php
            if(!array_key_exists('item', $_GET)){
                echo "erreur pas de clé GET";
            }else{
        ?>
        
        <h1>Catalogue <?php echo $_GET['item']; ?></h1>
        <a id="add" href="<?php /**/ ?>">Ajouter <?php echo $_GET['item']; ?></a>
        
        <?php $method = 'get_all_'.ucfirst($_GET['item']);
        $list = $method($db);
        //var_dump($list);
        //var_dump($list[0]->get_vars()); ?>
        
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
               <?php $item = $item->get_vars();
                foreach($item as $key => $value): ?>

                    <td><?php echo $value; ?></td>
                
                <?php endforeach; ?>
                <td><a href=""><i class="fa fa-pencil"></i></a></td>
                <td><a href=""><i class="fa fa-trash-o"></i></a></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <?php } ?>
        </div>
    </body>
</html>