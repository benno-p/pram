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
    <link href="css/plugins/jquery-ui.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/c_home.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <!--FONT AWESOME-->
    <link href="font-awesome/css/all.min.css" rel="stylesheet" type="text/css">

</head>

<?php
session_start();
include 'php/properties.php';
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
};
if (!isset($_SESSION['password'])) {
    header('Location: index.php');
    exit();
};


$dbconn = pg_connect("hostaddr=$DBHOST port=$PORT dbname=$DBNAME user=$LOGIN password=$PASS")
or die ('Connexion impossible :'. pg_last_error());
$sql = "select i.u_nom,i.u_prenom, i.u_id_nom_structure, i.u_logo from $users i where i.u_courriel = '".$_SESSION['email']."' AND i.u_pwd = md5('".$_SESSION['password']."') ";
//execute la requete dans le moteur de base de donnees  
$query_result1 = pg_exec($dbconn,$sql) or die (pg_last_error());
while($row = pg_fetch_row($query_result1))
{
    $nom         = $row[0];
    $prenom      = $row[1];
    $structure   = $row[2];
    $logo        = $row[3];
}
//ferme la connexion a la BD
pg_close($dbconn);
$menu_on = stripos($_SERVER['REQUEST_URI'], 'infos.php') ? "men_li_d" : "men_li";

?>

<body>
<div id="wrapper">
<ul class="navbar-nav bg-dark sidebar sidebar-dark accordion d-flex flex-column justify-content-center" id="accordionSidebar" style="z-index:10;">
        <div class="d-flex justify-content-center">
            <img class="img_bottom" src="img/pram.png" alt="PRAM Normandie"/>
        </div>
        <li class="nav-item mx-2 mt-4 mb-2">
            <a href="home.php" class="nav-link text-light">
                <i class="mx-2 fas fa-home"></i>Accueil
            </a>
        </li>
        <!--<li class="nav-item">
        <!--    <a class="nav-link collapsed text-light" href="#" data-toggle="collapse" data-target="#collapseSaisie" aria-expanded="false" aria-controls="collapseSaisie">
        <!--        <i class="mx-2 fas fa-edit"></i>Saisie
        <!--    </a>
        <!--    <div id="collapseSaisie" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
        <!--    <div class=" py-2 collapse-inner d-flex flex-column"  style="color:#004ea1;">
        <!--        <div class="d-flex"><div id="mare_loc_menu"     class="<?php //echo $menu_on; ?> btn btn-primary btn-sm m-2 justify-content-start" ><i class="fa fa-plus-circle"></i> Localisation</div></div>
        <!--        <div class="d-flex"><div id="mare_car_menu"     class="<?php //echo $menu_on; ?> btn btn-success btn-sm m-2" ><i class="fa fa-plus-circle"></i> Caractérisation</div></div>
        <!--        <div class="d-flex"><div id="mare_photo_menu"   class="<?php //echo $menu_on; ?> btn btn-yellowed btn-sm m-2" ><i class="fa fa-plus-circle"></i> Photo</div></div>
        <!--        <div class="d-flex"><div id="mare_delete_menu"  class="<?php //echo $menu_on; ?> btn btn-danger btn-sm m-2" ><i class="fa fa-minus-circle"></i> Mare</div></div>
        <!--        <div class="d-flex"><div id="mare_espece_menu"  class="<?php //echo $menu_on; ?> btn btn-purple btn-sm m-2" data-toggle="modal" data-target="#modalSpecies"><i class="fa fa-plus-circle"></i> Espèces</div></div>
        <!--        <div class="d-flex"><div id="mare_travaux_menu" class="<?php //echo $menu_on; ?> btn btn-pink btn-sm m-2" data-toggle="modal" data-target="#modalTravaux"><i class="fa fa-plus-circle"></i> Travaux</div></div>
        <!--    </div>
        <!--    </div>
        <!--</li>-->
        <li class="nav-item mx-2 my-2">
            <a class="nav-link collapsed text-light" href="#" data-toggle="collapse" data-target="#collapseExport" aria-expanded="false" aria-controls="collapseExport">
                <i class="mx-2 fas fa-file-export"></i>Export
            </a>
            <div id="collapseExport" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
                <div class="collapse-inner d-flex flex-column border border-secondary border-right-0 border-left-0 pl-2" style="">
                    <a id="export_mares_shapefile" class="m-2 small text-light <?php echo $menu_on; ?>"><i class="far fa-file-archive"></i> Shapefile</a>
                    <a id="export_mares_excel" class="m-2 small text-light <?php echo $menu_on; ?>"><i class="far fa-file-excel"></i> Excel</a>
                </div>
            </div>
        </li>
        <li class="nav-item mx-2 my-2">
            <a class="nav-link collapsed text-light" href="#" data-toggle="collapse" data-target="#collapseAnalyse" aria-expanded="false" aria-controls="collapseAnalyse">
                <i class="mx-2 fas fa-chart-bar"></i>Analyse
            </a>
            <div id="collapseAnalyse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
                <div class="collapse-inner d-flex flex-column border border-secondary border-right-0 border-left-0 pl-2 "  style="">
                    <a id="define_semi" class="m-2 small text-light <?php echo $menu_on; ?>" >
                        <span><i class="fas fa-edit"></i>
                        Definir un semi</span>
                    </a>
                    <a id="analyse_semi" class="m-2 small text-light <?php echo $menu_on; ?>" >
                        <i class="fas fa-chart-bar"></i>
                        Analyse du semi
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item mx-2 my-2">
            <a class="nav-link collapsed text-light" href="#" data-toggle="collapse" data-target="#collapseMobile" aria-expanded="false" aria-controls="collapseMobile">
                <i class="mx-2 fas fa-mobile-alt"></i>Mes données terrain
            </a>
            <div id="collapseMobile" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
            <div class="collapse-inner d-flex flex-column border border-secondary border-right-0 border-left-0 pl-2"  style="">
                <a id="valid_android" class="m-2 small text-light <?php echo $menu_on; ?>" ><i class="fab fa-android"></i> Saisies avec ODK</a>
                <a id="valid_android" class="m-2 small text-light <?php echo $menu_on; ?>" ><i class="fab fa-android"></i> Saisies avec Géomare</a>
            </div>
            </div>
        </li>
        <li class="nav-item mx-2 my-2">
            <a href="infos.php" class="nav-link text-light">
                <i class="mx-2 fas fa-user"></i>Mes Informations
            </a>
        </li>
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
    <div class="d-flex w-100  static-top bg-dark  pt-2 pb-2 mb-0 pb-0 justify-content-end align-items-center font-weight-bold" style="">
        <div><span href="#" class=" mx-2 font-weight-bold" id="mail_user" style="color:#fff;opacity:0.8;"> <?php echo $_SESSION['email']; ?></span></div>
        <div style="color:#fff;opacity:0.8;"><a class="small mx-2 logout font-weight-bold" href="php/logout.php"  style="color:#fff;"><i class="fa fa-fw fa-power-off"></i> Déconnexion</a></div>
    </div>
    <div class="row mt-1 ml-1 no-gutters">
        <div class="d-flex w-100">
            <div class="d-flex flex-column">
                <h4>Mes informations</h4>
                <div class="form-group">
                    <label>NOM Prénom :</label>
                    <span id="nom_prenom" class="form-control-static"><?php echo $nom.' '.$prenom; ?></span>
                </div>
                <div class="form-group">
                    <label>Courriel :</label>
                    <span id="courriel" class="form-control-static"><?php echo $_SESSION['email'];?></span>
                </div>
                <div class="form-group">
                    <label>Structure :</label>
                    <span id="structure" class="form-control-static"><?php echo $structure; ?></span>
                </div>
                <div class="form-group">
                    <label>Mot de passe :</label>
                    <span id="password" class="form-control-static"><?php echo $_SESSION['password'];?></span>
                </div>
                <div class="form-group">
                    <label>Logo :</label>
                    <span id="logo" class="form-control-static"></span>
                    <img src='img/logos/<?php echo $logo; ?>' style="max-height:60px;max-width:60px;" />
                </div>
                <div class="btn btn-primary" style="" data-toggle="modal" data-target="#ModalEdit"><i id="" class="fas fa-edit mr-2"></i>Éditer les données</div>
            </div>
            <div id="evolution" class="d-flex w-75" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
    </div>
    <div class="d-flex mt-auto justify-content-end align-items-center text-muted" >
        <kbd class="small">CEN Normandie © <?php echo date("Y"); ?></kbd>
    </div>
</div>
</div>
<!-- /#page-wrapper -->

<div id="ModalEdit" class="modal fade" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <div class="col-sm-12">
                    <p ></p>
                </div>
            </div>
            <div class="modal-body" >
                <div class="row text-left">
                    <div class="col-sm-12">
                    <form class="eventInsFormModal" action="#" method="post">
                        <div class="col-sm-12">
                            <div class="form-group">
                            <label>Nom :</label>
                            <input id="i_nom" class="form-control input-sm" value="<?php echo $nom; ?>" type="text"></input>
                            </div>
                            <div class="form-group">
                            <label>Prenom:</label>
                            <input id="i_prenom" class="form-control input-sm" value="<?php echo $prenom; ?>" type="text"></input>
                            </div>
                            <div class="form-group">
                            <label>Courriel:</label>
                            <input id="i_courriel" class="form-control input-sm" value="<?php echo $_SESSION['email'];?>" type="text"  disabled></input>
                            <small  class="help-block">N'est pas modifiable (contact : contact@pramnormandie.fr)</small >
                            </div>
                            <div class="form-group">
                            <label>Mot de passe :</label>
                            <input id="i_pwd" class="form-control input-sm" type="text" placeholder="zZZ11zz&&" value="<?php echo $_SESSION['password'];?>" type="text" disabled>
                            <small  class="help-block">N'est pas modifiable (contact : contact@pramnormandie.fr)</small > 
                            </div>
                            <div class="form-group">
                            <label>Structure :</label>
                            <input id="i_structure" class="form-control input-sm" type="text" placeholder="CEN" value="<?php echo $structure; ?>" type="text">
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="i_logo">
                                <label class="custom-file-label" for="i_logo" data-browse="Parcourir">Logo / image</label>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="save_i_edit" class="btn btn-primary"  aria-hidden="true">Enregistrer</button> <!--data-dismiss="modal"-->
            </div>
        </div>
    </div>
</div>

    </div>
    <!-- /#wrapper -->
<!-- JQUERY-->
<script src="js/jq3.5.js" ></script>
<script src="js/popper.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.js"></script>
    <!--HighCharts-->
    <script src="js/plugins/highcharts/code/highcharts.js" ></script>
    <script src="js/plugins/highcharts/code/modules/exporting.js" ></script>
    
    <!--Custom-->
    <script src="js/infos.js"></script>
    <script>
    yop();
    var validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
    var file_logo = false;
    //$("#i_logo").change(function() {
    //    file_logo = true;
    //    file = this.files[0];
    //    fileType = file['type'];
    //    fileName = this.files[0].name;
    //});
    $("#i_logo").on('change',function(e){
        var fileName = document.getElementById("i_logo").files[0].name;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = fileName
    });
    
    </script>
    
</body>
</html>
