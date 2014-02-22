<h1>Raaka-aineet</h1>
<br>
<form class="form-inline" role="form" action="raakaaineet.php" method="GET">
    <div class="form-group">
        <label class="sr-only" for="inputHakusana">Hae raaka-ainetta: </label>
        <input type="text" class="form-control" id="inputHakusana" name="hae" placeholder="hakusana">
    </div>
    <button type="submit" class="btn btn-default">Hae</button>
</form>
<br>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Raaka-aine</th>
            <th>kcal/100g</th>
            <th>H/100g</th>
            <th>P/100g</th>
            <th>R/100g</th>
            <th>€/kg</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data->raakaaineet as $raakaaine): ?>
            <tr>
                <td><a href="raakaaineet.php?id=<?php echo $raakaaine->getId(); ?>"><?php echo htmlspecialchars($raakaaine->getNimi()); ?></a></td>
                <td><?php echo $raakaaine->getKalorit(); ?></td>
                <td><?php echo $raakaaine->getHiilarit(); ?></td>
                <td><?php echo $raakaaine->getProteiinit(); ?></td>
                <td><?php echo $raakaaine->getRasvat(); ?></td>
                <td><?php echo $raakaaine->getHinta(); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p>Raaka-aineita yhteensä: <?php echo $data->lkm ?></p>
<br>
<?php if (onkoMuokkaaja()): ?>
<p><a href="raakaaineet.php?lisaa">Lisää uusi raaka-aine</a></p>
<?php endif; ?>
