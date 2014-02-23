<h2>Käyttäjän tiedot</h2>
<table class="table-condensed">
    <tr>
        <td><b>Nimi:</b></td>
        <td><?php echo htmlspecialchars($data->kayttaja->getNimi()) ?></td>
    </tr>
    <tr>
        <td><b>Rooli:</b></td>
        <td><?php if ($data->kayttaja->getRooli() === 0) { echo "ylläpitäjä"; } elseif ( $data->kayttaja->getRooli() === 1) { echo "muokkaaja"; } else { echo "selaaja"; } ?></td>
    </tr>
</table>
<br>
<h3>Salasanan vaihto</h3>
<form class="form-horizontal" role="form" action="kayttajat.php?salasana" method="POST">
    <div class="form-group<?php if (isset($data->virheet['salasana'])){ echo ' has-error'; } ?>">
        <label for="inputSalasana" class="col-sm-2 control-label">Nykyinen salasana:</label>
        <div class="col-sm-4">
            <input type="password" class="form-control" id="inputUusiSalasana1" name="salasana" placeholder="Salasana" >
        </div>
        <?php if (isset($data->virheet['salasana'])): ?><p class="help-block"><?php echo $data->virheet['salasana']; ?></p><?php endif; ?>
    </div>
    <div class="form-group<?php if (isset($data->virheet['salasana_uusi'])){ echo ' has-error'; } ?>">
        <label for="inputUusiSalasana1" class="col-sm-2 control-label">Uusi salasana:</label>
        <div class="col-sm-4">
            <input type="password" class="form-control" id="inputUusiSalasana1" name="salasana_uusi" placeholder="Uusi salasana" >
        </div>
        <?php if (isset($data->virheet['salasana_uusi'])): ?><p class="help-block"><?php echo $data->virheet['salasana_uusi']; ?></p><?php endif; ?>
    </div> 
    <div class="form-group<?php if (isset($data->virheet['salasana_vahvistus'])){ echo ' has-error'; } ?>">
        <label for="inputUusiSalasana2" class="col-sm-2 control-label">Uusi salasana uudelleen:</label>
        <div class="col-sm-4">    
            <input type="password" class="form-control" id="inputUusiSalasana2" name="salasana_vahvistus" placeholder="Uusi salasana">
        </div>
        <?php if (isset($data->virheet['uusisalasana2'])): ?><p class="help-block"><?php echo $data->virheet['salasana_vahvistus']; ?></p><?php endif; ?>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Vaihda salasana</button>
        </div>
    </div>
</form>
