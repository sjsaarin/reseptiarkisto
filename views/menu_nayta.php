<ol class="breadcrumb">
  <li><a href="menut.php">Haku</a></li>
  <li class="active">Menu</li>
</ol>
<div class="row">
    <h1><?php echo htmlspecialchars($data->menu->getNimi()); ?></h1>
    <br>
    <?php for ($i = 0; $i < count($data->menun_reseptit); $i++): ?>
        <?php if (!($data->menun_reseptit[$i][2] === NULL)): ?>
            <h3><?php echo htmlspecialchars($data->menun_reseptit[$i][0]); ?></h3>
            <p><a href="reseptit.php?nayta=<?php echo $data->menun_reseptit[$i][1]; ?>"><?php echo htmlspecialchars($data->menun_reseptit[$i][2]); ?></a></p>
        <?php endif; ?>
    <?php endfor; ?>
    <br>

</div>
<div class="row">
    <h3>Kuvaus:</h3>
    <pre><?php echo htmlspecialchars($data->menu->getKuvaus()); ?></pre>
</div>
<br>
<?php if (onkoMuokkaaja()): ?>
    <div class="row">
        <div class="col-md-2">
            <form action='menut.php' method="get">
                <input type="hidden" name="muokkaa" value="<?php echo $data->menu->getId(); ?>">
                <input type="submit" class="btn btn-info btn-sm" value="Muokkaa menuta">
            </form>
        </div>
        <div class="col-md-2">
            <form action='menut.php?poista' method="post" onsubmit="return confirm('Oletko varma?')">
                <input type="hidden" name="id" value="<?php echo $data->menu->getId(); ?>">
                <input type="submit" class="btn btn-danger btn-sm" value="Poista menu">
            </form>
        </div>
    </div>
<?php endif; ?>