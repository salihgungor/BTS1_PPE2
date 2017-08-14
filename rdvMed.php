<!DOCTYPE html>
<?php
include_once 'Fonctions.php';
?>

<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style_rdv.css">
	<title>Médecine de l'hopital du bien être</title>
	<script src="ressources/js/pdfmake.min.js"></script>
	<script src="ressources/js/vfs_fonts.js"></script>
	<script src="ressources/js/rdv_info.js"></script>
</head>
<body id="Haut">
	<div id="CentrePage">
        <div id="DivNav">
			<ul id="MenuNav">
				<a href="index.html"><li class="MNG">Accueil</li></a>
				<a href="medecine.html"><li class="MNG">Médecine</li></a>
				<a href="pediatrie.html"><li class="MNG">Pédiatrie</li></a>
				<a href="chirurgie.html"><li class="MNG">Chirurgie</li></a>
				<a href="urgences.html"><li class="MNG">Urgences</li></a>
				<a href="formalites.html"><li class="MND">Formalités</li></a>
				<a href="contact.html"><li class="MND">Contacts</li></a>
			</ul>
        </div>
            <br />
            <center><img src="ressources/index_03.gif" width="933" height="95" alt="bannière" /></center>
            <br />
		<div id="fs">
            <div id="dmdrdv">
                <form method="POST" action="rdvMed.php">
                    <fieldset>
                        <legend>RDV</legend>   
                        <br/>
						
                        <a>Choissisez un medecin : </a>
                                    
                        <select name="toutMedecin">
                            <option value="Selectionner">Selectionner</option>
                                        <?php
										include_once 'Fonctions.php';
                                            
                                        $mesMedecin = getMedecin();
                                            
                                                foreach($mesMedecin as $unMedecin){
                                                
                                                    echo '<option value="'.$unMedecin['nom'].'">M(mme).'.$unMedecin['nom'].'</option>';
                                                }
                                        ?>
                                        
                        </select>   
                                    
                        <br/>
                        <div id="infos">
                            <div id="gauche">
							<br/>                    
								<legend>Veuillez selectionnez une horaires : </legend>
									<p><input type="radio" name="horaire" value="08:00:00">08:00:00</p>
									<p><input type="radio" name="horaire" value="09:00:00">09:00:00 </p>
									<p><input type="radio" name="horaire" value="10:00:00">10:00:00</p>
									<p><input type="radio" name="horaire" value="11:00:00">11:00:00</p>
									<p><input type="radio" name="horaire" value="12:00:00">12:00:00</p>
		
							</div>
                        </div>   
                        <div id="formbuttons">
                            <input type="submit" value="Valider" />
                        </div>
                                             

                    </fieldset>
                </form>  
            </div>
            <?php
            include_once 'Fonctions.php';
			
                if(isset($_POST['horaire']))
				{
                                
					echo '<div id="listeRDV">';
					echo '<fieldset>';
					echo '<legend>Liste des rendez-vous</legend>';
                    echo '<div id="mailListeRDV">';
                                            
						
					include_once 'Fonctions.php';
																										
					$bdd = connexionBDD();

					$lesRdv= getInfo($_POST['horaire'],$_POST['toutMedecin']);
					
					echo '<div id="AfficheRDV">';
					echo '<table>';
					echo '<tr>';
					echo '<th>nom</th>';
					echo '<th>patient</th>';
					echo '<th>date</th>';
													   
						foreach($lesRdv as $unRdv)
						{
																
						echo '<tr>';
						echo '<td>M(mme).'.$unRdv['nom'].'</td>';
						echo '<td>n°'.$unRdv['patient'].'</td>';
						echo '<td>'.$unRdv['date'].'</td>';
						echo '</tr>';
					
						}
															
						echo '</table>';
				}
                    
                                                       
			
                                            
                                                
                    echo '</div>';                        
					echo '</div>';
					echo '</fieldset>';
					echo '</div>';
            ?>  
			
        </div>
	</div>
</body>
</html>

