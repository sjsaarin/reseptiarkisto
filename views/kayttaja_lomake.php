<ol class="breadcrumb">
    <li><a href="kayttajat.php">Haku</a></li>
<?php if ($data->tila === 'lisaa'): ?>
    <li class="active">Lisää</li>
</ol>
<h2>Lisää uusi käyttäjä</h2>
<?php endif; ?>
<?php if ($data->tila === 'muokkaa'): ?>
    <li class="active">Muokkaa</li>
</ol>
<h2>Muokkaa käyttäjän tietoja</h2>
<?php endif; ?>
<br>
<form class="form-horizontal" role="form"  action="kayttajat.php?<?php if ($data->tila === 'lisaa') { echo 'lisaa'; } elseif ($data->tila === 'muokkaa'){ echo 'paivita=' . $data->kayttaja->getId(); } ?>" method="POST">
    <?php if ($data->tila === 'muokkaa'): ?>
    <div class="form-group">
        <label for="inputId" class="col-sm-2 control-label">Id</label>
        <div class="col-sm-1">
            <input type="text" class="form-control" id="inputId" disabled value="<?php echo $data->kayttaja->getId() ?>">
        </div>
    </div>
    <?php endif; ?>    
    <div class="form-group">
        <label for="inputEtunimi" class="col-sm-2 control-label">Etunimi</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="inputEtunimi" name="etunimi" placeholder="Etunimi" <?php if (isset($data->kayttaja)) : ?>value="<?php echo htmlspecialchars($data->kayttaja->getEtunimi()); ?>" <?php endif; ?>>
        </div>
    </div>
    <div class="form-group">
        <label for="inputSukunimi" class="col-sm-2 control-label">Sukunimi</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="inputSukunimi" name="sukunimi" placeholder="Sukunimi" <?php if (isset($data->kayttaja)) : ?>value="<?php echo htmlspecialchars($data->kayttaja->getSukunimi()); ?>" <?php endif; ?>>
        </div>
    </div>
    <br>
    <div class="form-group">
        <label for="selectRooli" class="col-sm-2 control-label">Rooli</label>
        <div class="col-sm-3">
            <select class="form-control" id="selectRooli" name="rooli">
                <option <?php if (isset($data->kayttaja) && ($data->kayttaja->getRooli() === 2)) { echo 'selected'; } ?> value="2">Selaaja</option>
                <option <?php if (isset($data->kayttaja) && ($data->kayttaja->getRooli() === 1)) { echo 'selected'; } ?> value="1">Muokkaaja</option>
                <option <?php if (isset($data->kayttaja) && ($data->kayttaja->getRooli() === 0)) { echo 'selected'; } ?> value="0">Ylläpitäjä</option>
            </select>    
        </div>
    </div>
    <br>
    <div class="form-group<?php if (isset($data->virheet['kayttajatunnus'])){ echo ' has-error'; } ?>">
        <label for="inputKayttajatunnus" class="col-sm-2 control-label">Käyttäjätunnus:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" id="inputKayttajatunnus" name="kayttajatunnus" placeholder="Kayttajatunnus" <?php if (isset($data->kayttaja)) : ?>value="<?php echo $data->kayttaja->getKayttajatunnus() ?>" <?php endif; ?>>
        </div>
        <?php if (isset($data->virheet['kayttajatunnus'])): ?><p class="help-block"><?php echo $data->virheet['kayttajatunnus']; ?></p><?php endif; ?>
    </div> 
    <div class="form-group<?php if (isset($data->virheet['salasana_uusi'])){ echo ' has-error'; } ?>">
        <label for="inputUusiSalasana1" class="col-sm-2 control-label">Salasana:</label>
        <div class="col-sm-4">
            <input type="password" class="form-control" id="inputUusiSalasana1" name="salasana1" placeholder="Salasana" >
        </div>
        <?php if (isset($data->virheet['salasana_uusi'])): ?><p class="help-block"><?php echo $data->virheet['salasana_uusi']; ?></p><?php endif; ?>
    </div> 
    <div class="form-group<?php if (isset($data->virheet['salasana_vahvistus'])){ echo ' has-error'; } ?>">
        <label for="inputUusiSalasana2" class="col-sm-2 control-label">Salasana uudelleen:</label>
        <div class="col-sm-4">    
            <input type="password" class="form-control" id="inputUusiSalasana2" name="salasana2" placeholder="Salasana">
        </div>
        <?php if (isset($data->virheet['salasana_vahvistus'])): ?><p class="help-block"><?php echo $data->virheet['salasana_vahvistus']; ?></p><?php endif; ?>
    </div>
    <br>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Tallenna</button>
        </div>
    </div>
</form>