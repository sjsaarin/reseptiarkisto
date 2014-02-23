<ol class="breadcrumb">
  <li class="active">Haku</li>
</ol>
<h1>Raaka-aineet</h1>
<?php if (onkoMuokkaaja()): ?>
<a class="btn btn-success btn-xs" href="raakaaineet.php?uusi" role="button">Lisää uusi</a>
<?php endif; ?>
<br>
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
                <td><a href="raakaaineet.php?nayta=<?php echo $raakaaine->getId(); ?>"><?php echo htmlspecialchars($raakaaine->getNimi()); ?></a></td>
                <td><?php echo $raakaaine->getKalorit(); ?></td>
                <td><?php echo $raakaaine->getHiilarit(); ?></td>
                <td><?php echo $raakaaine->getProteiinit(); ?></td>
                <td><?php echo $raakaaine->getRasvat(); ?></td>
                <td><?php echo $raakaaine->getHinta(); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<ul class="pagination pagination-sm">
<?php if ($data->sivunro == 0): ?>
    <li class="disabled"><a href="#">&laquo;</a></li>
<?php else: ?>
    <li><a href="raakaaineet.php?sivu=<?php echo $data->sivunro-1; ?><?php if(!empty($data->nimi)){ echo "&hae=" . $data->nimi; } ?>">&laquo;</a></li>
<?php endif; ?>
<?php for($i=0; $i < $data->sivuja; $i++): ?>
    <li<?php if($i == $data->sivunro){ echo ' class=active'; } ?>><a href="raakaaineet.php?sivu=<?php echo $i ?><?php if(!empty($data->nimi)){ echo "&hae=" . $data->nimi; } ?>"><?php echo $i+1; ?></a></li>
<?php endfor; ?>
<?php if($data->sivunro == $data->sivuja-1): ?>    
    <li class="disabled"><a href="#">&raquo;</a></li>
<?php else: ?>
    <li><a href="raakaaineet.php?sivu=<?php echo $data->sivunro+1; ?><?php if(!empty($data->nimi)){ echo "&hae=" . $data->nimi; } ?>">&raquo;</a></li>
<?php endif; ?>
</ul>
