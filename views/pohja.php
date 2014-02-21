<!DOCTYPE html>
<html>
    <head>
        <title>Reseptiarkisto: <?php echo $data->title ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link href="css/bootstrap.css" rel="stylesheet">
        <script src="js/bootstrap.js"></script>
        <!--link href="css/bootstrap-theme.css" rel="stylesheet"-->
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
        <?php if (isset($_SESSION['kayttaja'])): ?>
            <div class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="paavalikko">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="" class="navbar-brand" >Reseptiarkisto</a>
                </div>
                <div class="navbar-collapse collapse" id="paavalikko">     
                    <ul class="nav navbar-nav">
                        <li <?php if ($data->sivu == "reseptit") { echo 'class="active"'; } ?>><a href="reseptit.php">Reseptit</a></li>
                        <li <?php if ($data->sivu == "raaka-aineet") { echo 'class="active"'; } ?>><a href="raakaaineet.php">Raaka-aineet</a></li>
                        <?php if (onkoMuokkaaja()): ?><li <?php if ($data->sivu == "kategoriat") { echo 'class="active"'; } ?>><a href="kategoriat.php">Kategoriat</a></li><?php endif; ?>
                        <?php if (onkoAdmin()): ?><li <?php if ($data->sivu == "kayttajat") { echo 'class="active"'; } ?>><a href="kayttajat.php">Kayttajat</a></li><?php endif; ?>
                        <li <?php if ($data->sivu == "ostoslista") { echo 'class="active"'; } ?>><a href="ostoslista.php">Ostoslista</a></li>
                    </ul>    
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown<?php if ($data->sivu == "kayttaja") { echo ' active'; } ?>">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="kayttaja">Käyttäjä <b class="caret"></b></a>
                            <ul class="dropdown-menu" aria-labelledby="kayttaja">
                                <li><a href="kayttajat.php?omat_tiedot">Omat tiedot</a></li>
                                <li class="divider"></li>
                                <li><a href="kirjautuminen.php?logout">Kirjaudu ulos</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                </div>
        </div>
        <?php endif; ?>
        <div class="container">
            <?php if (!empty($data->virhe)): ?>
                <div class="alert alert-danger">Virhe: <?php echo $data->virhe; ?></div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['virhe'])): ?>
                <div class="alert alert-danger">Virhe: <?php echo $_SESSION['virhe']; ?></div>
                <?php unset($_SESSION['virhe']); ?>
            <?php endif; ?>
            <?php if(!empty($_SESSION['ilmoitus'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['ilmoitus']; ?>
                </div>
                <?php unset($_SESSION['ilmoitus']); ?>
            <?php endif; ?>
            <?php require $sivu; ?>
        </div>
    </body>
</html>