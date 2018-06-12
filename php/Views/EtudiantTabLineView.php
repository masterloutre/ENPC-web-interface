<tr>
<a href="#">
  <td><?php echo ($etudiant['prenom'].' <span class="upper">'.$etudiant['nom'].'</span>'); ?></td>
</a>
  <?php for ($i=0; $i < count($competences_tab); $i++) { ?>
  	<td><?php echo ($etudiant['competence'.($i+1)]); ?></td>

  	<?php for ($j=0; $j < count($situation_pro_tab); $j++) { ?>

  	<td><?php echo ($etudiant['situation_pro'.($j+1)]); ?></td>

  	<?php }?>

  <?php }?>
</tr>
