<h1>Käyttäjät</h1>
<form class="form-inline" role="form" action="kayttajat.php" method="GET">
    <div class="form-group">
        <label class="sr-only" for="inputHakusana">Hae käyttäjää: </label>
        <input type="text" class="form-control" id="inputHakusana" name="hae" placeholder="hakusana">
    </div>
    <button type="submit" class="btn btn-default">Hae</button>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data->kayttajat as $kayttaja): ?>
            <tr>
                <td><a href="kayttajat.php?id=<?php echo $kayttaja->getId(); ?>"><?php echo htmlspecialchars($kayttaja->getNimi()); ?></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>