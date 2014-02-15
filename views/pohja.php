<!DOCTYPE html>
<html>
    <head>
        <title>Reseptiarkisto: <?php echo $data->title ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body>
        <?php if (isset($_SESSION['kayttaja'])): ?>
        <ul class="nav nav-tabs">
            <li <?php if ($data->sivu == "reseptit") { echo 'class="active"'; } ?>><a href="reseptit.php">Reseptit</a></li>
            <li <?php if ($data->sivu == "raaka-aineet") { echo 'class="active"'; } ?>><a href="raakaaineet.php">Raaka-aineet</a></li>
            <?php if (onkoAdmin()): ?><li <?php if ($data->sivu == "kategoriat") { echo 'class="active"'; } ?>><a href="kategoriat.php">Kategoriat</a></li><?php endif; ?>
            <li <?php if ($data->sivu == "kayttaja") { echo 'class="active"'; } ?>><a href="kayttaja.php">Käyttäjä</a></li>
        </ul>
        <?php endif; ?>
        <div class="container" id="content">
            <?php if (!empty($data->virhe)): ?>
                <div class="alert alert-danger">Virhe: <?php echo $data->virhe; ?></div>
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