<ol class="breadcrumb">
  <li class="active">Haku</li>
</ol>
<h1>Menut</h1>
<br>
<form class="form-inline" role="form" action="menut.php" method="GET">
    <div class="form-group">
        <label class="sr-only" for="inputHakusana">Hae menua: </label>
        <input type="text" class="form-control" id="inputHakusana" name="hae" placeholder="hakusana">
    </div>
    <div class="form-group">
        <label class="control-label" for="inputResepti">Resepti:</label>
        <input type="text" class="form-control" id="inputResepti" name="hae" placeholder="resepti">
    </div>
    <button type="submit" class="btn btn-default">Hae</button>
</form>
<br>
<table class="table table-striped">
    <thead>
        <tr>
            <th class="col-sm-2">Nimi</th>
            <th class="col-sm-2">Alkuruoka</th>
            <th class="col-sm-2">1. väliruoka</th>
            <th class="col-sm-2">Pääruoka</th>
            <th class="col-sm-2">2. väliruoka</th>
            <th class="col-sm-2">Jälkiruoka</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data->menut as $menu): ?>
            <tr>
                <td><a href='menut.php?nayta=<?php echo $menu->getId() ?>'><?php echo htmlspecialchars($menu->getNimi()) ?></a></td>
                <?php foreach ($menu->haeMenunReseptienNimet() as $rivi): ?>
                    <td><a href='reseptit.php?nayta=<?php echo $rivi[1]; ?>'><?php echo htmlspecialchars($rivi[2]); ?></a></td>
                <?php endforeach; ?>   
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<br>
<?php if (onkoMuokkaaja()): ?><a href="menut.php?uusi">Lisää uusi menu</a><?php endif; ?>