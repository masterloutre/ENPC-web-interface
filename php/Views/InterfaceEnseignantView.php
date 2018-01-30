<?php
require "../Global/global.php";
require "../Global/connect.php";
require_once "../Controllers/ScoreController.php"; ?>

<p>Bonjour Enseignant.</p>

<div class="wrapper">

    <table>
        <tr>
           <th>Etudiant</th>
            <th><?php echo $competence1->get_nom(); ?></th>
            <th><?php echo $competence2->get_nom(); ?></th>
            <th><?php echo $situation_pro1->get_nom(); ?></th>
            <th><?php echo $situation_pro2->get_nom(); ?></th>
            <th><?php echo $situation_pro3->get_nom(); ?></th>
            <th><?php echo $situation_pro4->get_nom(); ?></th>
            <th><?php echo $situation_pro5->get_nom(); ?></th>
            <th><?php echo $situation_pro6->get_nom(); ?></th>
        </tr>
        <?php $etudiants = get_all_etudiant($db);
        foreach($etudiants as $e):
             ?>
        <tr>
            <td><?php echo $e->get_nom()." ".$e->get_prenom(); ?></td>
            <td>
                <?php $score = get_score_from_etudiant_on_competence($db, $e, $competence1);
                echo $score->get_points(); ?>
            </td>
            <td>
                <?php $score = get_score_from_etudiant_on_competence($db, $e, $competence2);
                echo $score->get_points(); ?>
            </td>
            <td>
                <?php $score = get_score_from_etudiant_on_situation_pro($db, $e, $situation_pro1);
                echo $score->get_points(); ?>
            </td>
            <td>
                <?php $score = get_score_from_etudiant_on_situation_pro($db, $e, $situation_pro2);
                echo $score->get_points(); ?>
            </td>
            <td>
                <?php $score = get_score_from_etudiant_on_situation_pro($db, $e, $situation_pro3);
                echo $score->get_points(); ?>
            </td>
            <td>
                <?php $score = get_score_from_etudiant_on_situation_pro($db, $e, $situation_pro4);
                echo $score->get_points(); ?>
            </td>
            <td>
                <?php $score = get_score_from_etudiant_on_situation_pro($db, $e, $situation_pro5);
                echo $score->get_points(); ?>
            </td>
            <td>
                <?php $score = get_score_from_etudiant_on_situation_pro($db, $e, $situation_pro6);
                echo $score->get_points(); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>