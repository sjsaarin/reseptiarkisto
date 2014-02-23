<ol class="breadcrumb">
  <li class="active">Haku</li>
</ol>

<h1>Reseptit</h1>
<?php if (onkoMuokkaaja()): ?>
<a class="btn btn-success btn-xs" href="reseptit.php?uusi" role="button">Lisää uusi</a>
<?php endif; ?>
<br>
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
            <?php foreach ($data->kategoriat as $kategoria): ?>
                <option value="<?php echo $kategoria->getId(); ?>"><?php echo htmlspecialchars($kategoria->getNimi()); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <label for="paaraakaaineLista">Pääraaka-aine:</label>
    <div class="form-group" id="paaraakaaineLista">
        <select class="form-control" name="paaraakaaine">
            <option value="-1"> </option>
            <?php foreach ($data->paaraakaaineet as $raakaaine): ?>
                <option value="<?php echo $raakaaine[0] ?>"><?php echo htmlspecialchars($raakaaine[1]); ?></option>
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
        <?php foreach ($data->reseptit as $rivi): ?>
            <tr>
                <td><a href="reseptit.php?nayta=<?php echo $rivi[0]; ?>"</a><?php echo htmlspecialchars($rivi[1]); ?></td>
                <td><?php echo htmlspecialchars($rivi[2]); ?></td>
                <td><?php echo htmlspecialchars($rivi[3]); ?></td-->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<ul class="pagination pagination-sm">
<?php if ($data->sivunro == 0): ?>
    <li class="disabled"><a href="#">&laquo;</a></li>
<?php else: ?>
    <li><a href="reseptit.php?sivu=<?php echo $data->sivunro-1 . "&nimi=" . $data->hakusanat[0] . "&kategoria=" . $data->hakusanat[1] . "&paaraakaaine=" . $data->hakusanat[2]; ?>">&laquo;</a></li>
<?php endif; ?>
<?php for($i=0; $i < $data->sivuja; $i++): ?>
    <li<?php if($i == $data->sivunro){ echo ' class=active'; } ?>><a href="reseptit.php?sivu=<?php echo $i . "&nimi=" . $data->hakusanat[0] . "&kategoria=" . $data->hakusanat[1] . "&paaraakaaine=" . $data->hakusanat[2]; ?>"><?php echo $i+1; ?></a></li>
<?php endfor; ?>
<?php if($data->sivunro == $data->sivuja-1): ?>    
    <li class="disabled"><a href="#">&raquo;</a></li>
<?php else: ?>
    <li><a href="reseptit.php?sivu=<?php echo $data->sivunro+1 . "&nimi=" . $data->hakusanat[0] . "&kategoria=" . $data->hakusanat[1] . "&paaraakaaine=" . $data->hakusanat[2]; ?>">&raquo;</a></li>
<?php endif; ?>
</ul>