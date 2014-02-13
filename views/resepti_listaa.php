
<h1>Reseptit</h1>
<form class="form-inline" role="form" action="reseptit.php" method="GET">
    <div class="form-group">
        <label class="sr-only" for="inputHakusana">Hae reseptiä: </label>
        <input type="text" class="form-control" id="inputHakusana" name="hae" placeholder="hakusana">
    </div>
    <button type="submit" class="btn btn-default">Hae</button>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nimi</th>
            <th>Kategoria</th>
            <th>Pääraaka-aine</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data->reseptit as $asia): ?>
            <tr>
                <td><a href="reseptit.php?nayta=<?php echo $asia->getId(); ?>"</a><?php echo htmlspecialchars($asia->getNimi()); ?></td>
                <td><?php echo htmlspecialchars($asia->getKategoria()); ?></td>
                <td><?php echo $asia->getPaaraakaaine(); ?></td-->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p>Reseptejä yhteensä: <?php echo $data->lkm ?></p>
<p><a href="reseptit.php?lisaa">Lisää uusi resepti</a></p>
