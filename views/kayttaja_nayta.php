<h2>Käyttäjän tiedot</h2>
<table class="table-condensed">
    <tr>
        <td><b>Nimi:</b></td>
        <td><?php echo htmlspecialchars($data->kayttaja->getNimi()) ?></td>
    </tr>
    <tr>
        <td><b>Rooli:</b></td>
        <td><?php if ($data->kayttaja->getRooli() === 0) { echo "ylläpitäjä"; } elseif ( $data->kayttaja->getRooli() === 1) { echo "muokkaaja"; } else { echo "käyttäjä"; } ?></td>
    </tr>
</table>
<br>
<h3>Salasanan vaihto</h3>
<form class="form-horizontal" role="form" action="kayttajat.php?salasana" method="POST">
    <div class="form-group ">
        <label for="inputSalasana" class="col-sm-2 control-label">Nykyinen salasana:</label>
        <div class="col-sm-4">
            <input type="password" class="form-control" id="inputUusiSalasana1" name="uusisalasana1" placeholder="Salasana" >
        </div>
    </div>
    <div class="form-group">
        <label for="inputUusiSalasana1" class="col-sm-2 control-label">Uusi salasana:</label>
        <div class="col-sm-4">
            <input type="password" class="form-control" id="inputUusiSalasana1" name="uusisalasana1" placeholder="Uusi salasana" >
        </div>
    </div> 
    <div class="form-group">
        <label for="inputUusiSalasana2" class="col-sm-2 control-label">Uusi salasana uudelleen:</label>
        <div class="col-sm-4">    
            <input type="password" class="form-control" id="inputUusiSalasana2" name="uusisalasana2" placeholder="Uusi salasana">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Vaihda salasana</button>
        </div>
    </div>
</form>

