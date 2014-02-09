<h1>Raaka-aineet</h1>
<br>
<form class="form-inline" role="form" action="raakaaineet.php" method="GET">
    <div class="form-group">
        <label class="sr-only" for="inputHakusana">Hae raaka-ainetta: </label>
        <input type="text" class="form-control" id="inputHakusana" name="hae" placeholder="hakusana">
    </div>
    <button type="submit" class="btn btn-default">Hae</button>
</form>
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
        <?php foreach ($data->raakaaineet as $asia): ?>
            <tr>
                <td><a href="raakaaineet.php?id=<?php echo $asia->getId(); ?>"><?php echo htmlspecialchars($asia->getNimi()); ?></a></td>
                <td><?php echo $asia->getKalorit(); ?></td>
                <td><?php echo $asia->getHiilarit(); ?></td>
                <td><?php echo $asia->getProteiinit(); ?></td>
                <td><?php echo $asia->getRasvat(); ?></td>
                <td><?php echo $asia->getHinta(); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p>Raaka-aineita yhteensä: <?php echo $data->lkm ?></p>
<br>
<?php if (onkoAdmin()): ?>
<p><a href="raakaaineet.php?lisaa">Lisää uusi raaka-aine</a></p>
<?php endif; ?>
