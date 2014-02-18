
<h1>Reseptit</h1>
<br>
<form class="form-inline" role="form" action="reseptit.php" method="GET"> 
    <div class="form-group">
        <label class="sr-only" for="inputHakusana">Hae reseptiä: </label>
        <input type="text" class="form-control" id="inputHakusana" name="nimi" placeholder="hakusana">
    </div>
    <label for="kategoriaLista">Kategoria:</label>
    <div class="form-group" id="kategoriaLista" >
        <select class="form-control" name="kategoria">
            <option value="-1"> </option>
            <?php foreach ($data->kategoriat as $asia): ?>
                <option value="<?php echo $asia->getId(); ?>"><?php echo htmlspecialchars($asia->getNimi()); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <label for="paaraakaaineLista">Pääraaka-aine:</label>
    <div class="form-group" id="paaraakaaineLista">
        <select class="form-control" name="paaraakaaine">
            <option value="-1"> </option>
            <?php foreach ($data->paaraakaaineet as $asia): ?>
                <option value="<?php echo $asia[0] ?>"><?php echo htmlspecialchars($asia[1]); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-default">Hae</button>
</form>
<br>
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
                <td><a href="reseptit.php?nayta=<?php echo $asia[0]; ?>"</a><?php echo $asia[1]; ?></td>
                <td><?php echo $asia[2]; ?></td>
                <td><?php echo $asia[3]; ?></td-->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p>Reseptejä yhteensä: <?php echo $data->lkm ?></p>
<?php if (onkoAdmin()): ?><p><a href="reseptit.php?lisaa">Lisää uusi resepti</a></p><?php endif; ?>
