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
    <link href="css/bootstrap.min.css" rel="stylesheet">
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
        <div class="row">
            <div class="col-lg-6 mt-2 ml-2">
                <h4>Connexion à l'application PRAM Normandie</h4>
                <form role="form">
                    <div class="form-group">
                        <label for="courriel">Identifiant :</label>
                        <input id="courriel" class="form-control" placeholder="courriel@mail.com" onblur="" >
                    </div>
                    <div class="form-group">
                        <label for="pwd">Mot de passe :</label>
                        <input id="pwd" type="password" class="form-control" placeholder="xxxxxx" onblur="" >
                    </div>
                    <div class="form-group">
                        <!--<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Valider" alt="Submit">-->
                        <button type="button" id="signin" class="btn btn-lg btn-primary">Valider</button>
                    </div>
                </form>
                <a class="create_account point_er" data-toggle="modal" data-target="#ModalLogin">Création de compte</a>
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




<div id="ModalLogin" class="modal fade" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex flex-column">
                <div class="d-flex flex-inline w-100 mb-1">
                    <div class="mr-auto"><h3 class="modal-title" id="">Bienvenu !</h3></div>
                    <div class=""><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></div>
                </div>
                <div class="d-flex flex-column">
                    <div class="alert alert-info">
                    <p class="small">Pour vous inscrire, veuillez renseigner les 3 champs suivants et accepter les conditions générales d'utilisation.</p>
                    <p class="small">Une fois le compte activé, vous pourrez contribuer au recensement des mares et à la protection de la biodiversité ! (Merci d'avance)</p>
                    </div>
                    
                </div>
            </div>
            <div class="modal-body mx-2" >
                <div class="d-flex w-100 flex-column">
                    <div class="d-flex">
                        <div class="mr-auto flex-column">
                            <div class="form-group flex-column">
                                <label for="inscription_mail">Courriel</label>
                                <input type="email" class="form-control" id="inscription_mail" aria-describedby="emailHelp" >
                                <small id="emailHelp" class="form-text text-muted">Votre e-mail servira d'identifiant.</small>
                            </div>
                            <div class="form-group flex-column">
                                <label for="inscription_pwd">Mot de passe</label>
                                <input type="password" class="form-control" id="inscription_pwd" placeholder="zZZ11zz&&" aria-describedby="pwdHelp" minlength="8" required >
                                <small id="pwdHelp" class="form-text text-muted">8 caractères dont 1 Majuscule, 1 chiffre, 1 caractère spécial</small>
                            </div>
                            
                        </div>
                        
                        <div class="form-group flex-column">
                                    <div class="justify-content-center"><label>Je ne suis pas un robot :</label></div>
                                    <div class="justify-content-center">
                                        <div class="mb-1" data-toggle="" data-placement="" title="uniquement : ABCDEFGHIJKLMNOPQRSTUVWXYZ" >
                                            <img class="shadow" src="php/captcha.php"></img>
                                        </div>
                                        <div class=""><input id="verif" type="text" class="form-control" placeholder="xxxxxx" onblur="" ></div>
                                    </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="small">
                                 <h6 class="font-weight-bold mb-2 mt-2">Conditions d'utilisation :</h6>
                                En naviguant sur notre site, l’internaute reconnaît avoir pris connaissance et accepté nos conditions générales d’utilisation
                                 <h6 class="font-weight-bold mb-2  mt-2">Données personnelles :</h6>
                                Les données personnelles qui peuvent vous être demandées (exclusivement en vue de renseigner/décrire des mares) sont vos nom prénom et adresse mails.
                                Le traitement de ces données dont le responsable est Mr Benoit Perceval est en conformité avec le Règlement général de protection des données personnelles entré en vigueur le 25 Mai 2018.
                                Vous pouvez faire valoir vos droits de consultation, de rectification et de suppression en le contactant à l’adresse suivante b.perceval@cen-normandie.fr
                                Les documents (photos de mares) que vous importerez sur le site ainsi que les caractérisations des mares seront consultables par l'ensemble des utilisateurs.
                                Le recensement de mares (renseignement d'une fiche, photos) s'il est effectué sur un terrain privé doit se faire en accord avec le propriétaire.
                                <strong>Le CEN Normandie s'engage à ne jamais revendre ni donner ces informations à des tiers.</strong>
                                 <h6 class="font-weight-bold mb-2  mt-2">Propriété intellectuelle :</h6>
                                Le site web a été réalisé par nos géomaticien : Charles Bouteiller et Benoit Perceval.
                                Il est la propriété de l’association et ne peut faire l’objet de reproduction.
                                 <h6 class="font-weight-bold mb-2 mt-2">Photographies et contenu :</h6>
                                Les photographies, vidéos, textes et  illustrations publiés sur le site sont propriété de l’association ou ont fait l’objet de cession de droits.
                                Ils  ne peuvent faire l’objet d’aucune réutilisation.
                                 <h6 class="font-weight-bold mb-2 mt-2">Liens hypertextes :</h6>
                                Le site pramnormandie.com peut contenir des liens hypertextes renvoyant à des pages ou des sites dont le contenu ne peut engager en rien l’association.
                                Les liens hypertextes renvoyant vers notre site sont les bienvenus lorsqu’ils émanent de sites respectant la législation en vigueur.
                                <div class="mt-2 font-weight-bold"><input id="cgu_c" value="" type="checkbox" > J'accepte les conditions générales d'utilisation</input></div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="save_create_account" class="btn btn-primary"  aria-hidden="true">Enregistrer</button> <!--data-dismiss="modal"-->
            </div>
        </div>
    </div>
</div>


<!-- JQUERY-->
<script src="js/jq3.5.js" ></script>
<script src="js/popper.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.js"></script>
<!-- JQUERY AUTOCOMPLETE -->
<!--<script src="js/plugins/jquery-ui-1.12.1.custom/jquery-ui.js" ></script>-->
    <!--Custom-->
    <script src="js/index.js"></script>
    
    <script type="text/javascript">
    if (sessionStorage.getItem('trying') === 'account') {
        $('#ModalLogin').modal();
    }
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        console.log("tooltiped");
    })
    </script>
    
</body>
</html>
