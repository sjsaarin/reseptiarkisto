<ol class="breadcrumb">
  <li class="active">Haku</li>
</ol>
<h1>Menut</h1>
<?php if (onkoMuokkaaja()): ?>
<a class="btn btn-success btn-xs" href="menut.php?uusi" role="button">Lisää uusi</a>
<?php endif; ?>
<br>
<br>
<form class="form-inline" role="form" action="menut.php" method="GET">
    <div class="form-group">
        <label class="sr-only" for="inputHakusana">Hae menua: </label>
        <input type="text" class="form-control" id="inputHakusana" name="hae" placeholder="hakusana">
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
<ul class="pagination pagination-sm">
<?php if ($data->sivunro == 0): ?>
    <li class="disabled"><a href="#">&laquo;</a></li>
<?php else: ?>
    <li><a href="menut.php?sivu=<?php echo $data->sivunro-1; ?><?php if(!empty($data->nimi)){ echo "&hae=" . $data->nimi; } ?>">&laquo;</a></li>
<?php endif; ?>
<?php for($i=0; $i < $data->sivuja; $i++): ?>
    <li<?php if($i == $data->sivunro){ echo ' class=active'; } ?>><a href="menut.php?sivu=<?php echo $i ?><?php if(!empty($data->nimi)){ echo "&hae=" . $data->nimi; } ?>"><?php echo $i+1; ?></a></li>
<?php endfor; ?>
<?php if($data->sivunro == $data->sivuja-1): ?>    
    <li class="disabled"><a href="#">&raquo;</a></li>
<?php else: ?>
    <li><a href="menut.php?sivu=<?php echo $data->sivunro+1; ?><?php if(!empty($data->nimi)){ echo "&hae=" . $data->nimi; } ?>">&raquo;</a></li>
<?php endif; ?>
</ul>