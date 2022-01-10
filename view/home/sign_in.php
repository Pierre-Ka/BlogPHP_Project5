<?php

$title = 'Connexion';

ob_start(); ?>

<?php if ($incorrect===true): ?>
	<div class="alert alert-danger">
		Identifiants incorrects ou champs non remplis !
	</div>
<?php endif; ?>
<?php if (isset($message)): ?>
	<div class="alert alert-success">
		<?= $message; ?>
	</div>
<?php endif; ?>

<div class="text-center">
	<div>
		<h1>Connectez-vous à votre compte : </h1> 
		<form class="form-control" method="post">
				<label for="email"> Votre email : <input type="text" name="email" id="email"/></label><br/><br/>
				<label for="password"> Votre mot de passe : <input type="password" name="password" id="password"/></label><br/><br/>
			<input class=" btn btn-primary"type="submit" value="Connexion "/>
		</form>
	</div>

	<br/><br/>
	<p> Vous n'êtes pas encore inscrit mais souhaitez néanmoins publier sur ce blog ?</p>
	<p>Inscrivez-vous ici</p>
	<p> Creer un compte pour pouvoir publier des articles sur ce blog </p>

	<div>
		<h1>Créer mon compte </h1>
		<p>Tous les champs sont obligatoires</p>
		<p>Une fois votre compte crée vous receverez un mail de confirmation d'inscription sous peu et vous pourrez publier du contenu</p>
		<br/><br/>
		<form method="post" class="form-control">
				<label for="emailCreate"> Votre email </label><br/>
				<input type="text" name="emailCreate" id="emailCreate"/><br/><br/>
				<label for="nameCreate"> Votre nom </label><br/>
				<input type="text" name="nameCreate" id="nameCreate"/><br/><br/>
				<label for="passwordCreate"> Votre mot de passe</label><br/>
				<input type="password" name="passwordCreate" id="passwordCreate"/><br/><br/>
				<label for="passwordConfirm"> Confirmer votre mot de passe</label><br/>
				<input type="password" name="passwordConfirm" id="passwordConfirm"/><br/><br/>
				<label for="descriptionCreate"> Votre description </label><br/>
				<input type="text" name="descriptionCreate" id="descriptionCreate"/><br/><br/>
			<input type="submit" value="Creer mon compte"/>
		</form>
	</div>
<br/><br/>
</div>



<?php $content=ob_get_clean(); 

require('view/template/basic_template.php');

?>
