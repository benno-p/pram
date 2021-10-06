<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>PRAM Normandie</title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap-5.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/pram.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="font-awesome/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/c_home.css" rel="stylesheet">
    
    
    
</head>
<body class="">
<div id="wrapper">
    <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <img class="img_bottom" src="img/pram.png" alt="PRAM Normandie"/>
      </a>
      <!-- Nav Item - Dashboard -->
      <!-- Divider -->
      <hr class="sidebar-divider">
      
      <div class="d-flex mt-auto justify-content-center">
      <div class="d-flex w-100 justify-content-between mt-1 mb-2 ml-2 mr-2 " >
            <img class="" style="max-width:40px;max-height:50px;opacity:0.8" src="img/logos/AESN.jpg" alt="AESN"/>
            <img class="" style="max-width:40px;max-height:50px;opacity:0.8" src="img/logos/Region.jpg" alt="Région Normandie"/>
            <img class="" style="max-width:40px;max-height:50px;opacity:0.8" src="img/logos/FEADER.jpg" alt="FEADER"/>
            <img class="" style="max-width:40px;max-height:50px;opacity:0.8" src="img/logos/AELB.jpg" alt="AELB"/>
      </div>
      </div>
      
    </ul>

    <div id="content-wrapper" class="d-flex flex-column w-100 bg-light text-dark" style="overflow-x: hidden;">
        <div class="d-flex w-100  static-top bg-dark  pt-2 pb-2 mb-0 pb-0 justify-content-center align-items-center font-weight-bold" >
            <span style="color:#fff;opacity:0.8;font-size:24px;">&nbsp;</span>
        </div>
        <!-- /.row -->
        <div class="">
            <div class="d-flex flex-column w-50 m-2">
                <h4>Connexion à l'application PRAM Normandie</h4>
                <form role="form">
                    <div class="input-group w-50">
                        <span class="input-group-text justify-content-center col-2" id="user"><i class="fas fa-user"></i></span>
                        <input id="courriel" type="text" class="form-control col-10 " placeholder="courriel@mail.com" aria-label="courriel@mail.com" aria-describedby="user" >
                    </div>
                    <div class="input-group w-50 my-2">
                        <span class="input-group-text justify-content-center col-2" id="passwordLabel"><i class="fas fa-key"></i></span>
                        <input id="pwd" type="password" class="form-control col-10 " placeholder="MoTDePassE" aria-label="MoTDePassE" aria-describedby="passwordLabel" >
                    </div>
                    <div class="my-2">
                        <button type="button" id="signin" class="btn btn-primary">Valider</button>
                    </div>
                </form>
                <div class="my-2">
                    <button type="button" class="btn btn-outline-success btn-sm my-2" data-bs-toggle="modal" data-bs-target="#CreateAccount">Création de compte</button>
                </div>
                
            </div>
            <div class="col-lg-6">
            </div>
        </div>
        <!-- /.row -->
        <div class="d-flex mt-auto justify-content-end align-items-center text-muted" >
            <kbd class="small">CEN Normandie © <?php echo date("Y"); ?></kbd>
        </div>
    </div><!-- /#content wrapper -->
</div>
    <!-- /#wrapper -->


<!-- Modal -->
<div class="modal fade" id="CreateAccount" tabindex="-1" aria-labelledby="CreateAccountLabel" aria-hidden="true" >
  <div class="modal-dialog modal-lg" >
    <div class="modal-content" style="max-height:90vh;overflow-y:scroll;">
      <div class="d-flex modal-header">
		<div class="d-flex w-100">
			<h4 class="modal-title" id="CreateAccountLabel">Bienvenu !</h4>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
      </div>
      <div class="modal-body">
		<div class="alert alert-info m-y-2 small">
			Pour vous inscrire, veuillez renseigner les champs suivants et lire <strong>attentivement</strong> les conditions d'utilisation.
		</div>
		<form class="eventInsFormModal" action="#" method="post">
			<div class="input-group mt-4">
				<div class="input-group-prepend">
				<span class="input-group-text">Courriel et Mot de passe</span>
				</div>
				<input id="inscription_mail" type="text" class="form-control" placeholder="courriel">
				<input id="inscription_pwd"  type="text" class="form-control" placeholder="mot de passe">
			</div>
			<small  class="text-muted small mt-1 mb-4">8 caractères dont 1 Majuscule, 1 chiffre, 1 caractère spécial (?!#_)</small>
			<div class="input-group mt-4">
				<div class="input-group-prepend">
				<span class="input-group-text">Je ne suis pas un robot :</span>
				</div>
				<input id="verif" type="text" class="form-control" placeholder="MAJUSCULES" onblur="" >
				<img id="cap" src="php/captcha.php" style="border:solid 1px #ced4da;"></img>
				<a id="refresh" class="btn btn-default bg-light" style="border:solid 1px #ced4da;"><i  class="fas fa-sync"></i></a>
			</div>
			<small  class="text-muted small mt-1 mb-4">Recopiez les caractères ci-dessus</small>
			<div id="cgu_content" class="my-4">
				<h3><strong>Conditions Générales d'Utilisation :</strong></h3>
				<p class="small">
                    En naviguant sur notre site, l’internaute reconnaît avoir pris connaissance et accepté nos conditions générales d’utilisation
                </p>
                <p class="fs-5"><strong>Données personnelles :</strong></p>
                <p class="small">
                    Les données personnelles qui peuvent vous être demandées (exclusivement en vue de renseigner/décrire des mares) sont vos nom prénom et adresse mails.
                    Le traitement de ces données dont le responsable est Mr Benoit Perceval est en conformité avec le Règlement général de protection des données personnelles entré en vigueur le 25 Mai 2018.
                    Vous pouvez faire valoir vos droits de consultation, de rectification et de suppression en le contactant à l’adresse suivante b.perceval@cen-normandie.fr
                    Les documents (photos de mares) que vous importerez sur le site ainsi que les caractérisations des mares seront consultables par l'ensemble des utilisateurs.
                    Le recensement de mares (renseignement d'une fiche, photos) s'il est effectué sur un terrain privé doit se faire en accord avec le propriétaire.
                </p>
                <p class="small"><strong>Le CEN Normandie s'engage à ne jamais revendre ni donner ces informations à des tiers.</strong></p>
                <p class="fs-5"><strong>Propriété intellectuelle :</strong></p>
                <p class="small">
                Le site web a été réalisé par nos géomaticien : Charles Bouteiller et Benoit Perceval.
                Il est la propriété de l’association et ne peut faire l’objet de reproduction.
                </p>
                <p class="fs-5"><strong>Photographies et contenu :</strong></p>
                <p class="small">
                Les photographies, vidéos, textes et  illustrations publiés sur le site sont propriété de l’association ou ont fait l’objet de cession de droits.
                Ils  ne peuvent faire l’objet d’aucune réutilisation.
                </p>
                <p class="fs-5"><strong>Liens hypertextes :</strong></p>
                <p class="small">
                Le site pramnormandie.com peut contenir des liens hypertextes renvoyant à des pages ou des sites dont le contenu ne peut engager en rien l’association.
                Les liens hypertextes renvoyant vers notre site sont les bienvenus lorsqu’ils émanent de sites respectant la législation en vigueur.
                </p><br>
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" id="cgu_c">
					<label class="form-check-label" for="cgu_c"><strong>J'ai lu et j'accepte les conditions générales d'utilisation</strong></label>
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
		<button type="button" id="save_create_account" class="btn btn-primary"  aria-hidden="true">Enregistrer</button>
      </div>
    </div>
  </div>
</div>



<!-- JQUERY-->
<script src="js/jquery.js" ></script>
<!-- Bootstrap Core JavaScript -->
<script src="bootstrap-5.0.0/js/bootstrap.min.js"></script>
<!-- JQUERY AUTOCOMPLETE -->
<!--<script src="js/plugins/jquery-ui-1.12.1.custom/jquery-ui.js" ></script>-->
    <!--Custom-->
    <script src="js/index.js"></script>
    
    <script type="text/javascript">
    if (sessionStorage.getItem('trying') === 'account') {
        $('#ModalLogin').show();
    }
	$("#refresh").click( function () {
		$("img#cap").attr("src","php/captcha.php?_="+((new Date()).getTime()));
	});


    </script>
    
</body>
</html>
