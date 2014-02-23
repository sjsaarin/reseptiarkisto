<ol class="breadcrumb">
  <li class="active">Haku</li>
</ol>
<h1>Käyttäjät</h1>
<br>
<form class="form-inline" role="form" action="kayttajat.php" method="GET">
    <div class="form-group">
        <label class="sr-only" for="inputHakusana">Hae käyttäjää: </label>
        <input type="text" class="form-control" id="inputHakusana" name="hae" placeholder="hakusana">
    </div>
    <button type="submit" class="btn btn-default">Hae</button>
</form>
<br>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Id:</th>
            <th>Nimi:</th>
            <th>Rooli:</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data->kayttajat as $kayttaja): ?>
            <tr>
                <td><?php echo $kayttaja->getId() ?></td>
                <td><?php echo htmlspecialchars($kayttaja->getNimi()); ?></td>
                <td><?php if ($kayttaja->getRooli() == 0) { echo 'Ylläpitäjä'; } elseif ($kayttaja->getRooli() == 1) { echo 'Muokkaaja'; } elseif ($kayttaja->getRooli() == 2) { echo 'Selaaja'; } ?></td>
                <td>
                    <form action='kayttajat.php' method="get">
                        <input type="hidden" name="muokkaa" value="<?php echo $kayttaja->getId(); ?>">
                        <input type="submit" class="btn btn-info btn-xs" value="Muokkaa">
                    </form>
                </td>
                <td>
                    <form action='kayttajat.php?poista' method="post" onsubmit="return confirm('Oletko varma?')">
                        <input type="hidden" name="id" value="<?php echo $kayttaja->getId(); ?>">
                        <input type="submit" class="btn btn-danger btn-xs" value="Poista">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<br>
<a href="kayttajat.php?uusi">Lisää uusi käyttäjä</a> 