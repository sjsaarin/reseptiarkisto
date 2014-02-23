<ol class="breadcrumb">
    <li><a href="menut.php">Haku</a></li>
<?php if ($data->tila === 'lisaa'): ?>
    <li class="active">Lisää</li>
</ol>    
<h1>Luo uusi menu</h1>
<?php endif; ?>
<?php if ($data->tila === 'muokkaa'): ?>
    <li><a href="menut.php?nayta=<?php echo $data->menu->getId(); ?>">Menu</a></li>
    <li class="active">Muokkaa</li>
</ol>
<h1>Muokkaa menuta: <?php echo htmlspecialchars($data->menu->getNimi()); ?></h1>
<?php endif; ?>
<form role="form" class="form-horizontal" action="menut.php?lisaa" method="POST">
    <br>
    <div class="form-group<?php if (isset($data->virheet['nimi'])){ echo ' has-error'; } ?>">
        <label class="col-sm-2 control-label" for="inputNimi">Nimi:</label>
        <div class="col-sm-3">
            <input class="form-control" type="text" name="nimi" id="inputNimi" <?php if (isset($data->menu)) { echo 'value="' . $data->menu->getNimi() .'"'; } ?>>
        </div>
        <?php if (isset($data->virheet['nimi'])): ?><p class="help-block"><?php echo $data->virheet['nimi']; ?></p><?php endif; ?>
    </div>
    <br>
    <!-- Reseptit -->
    <?php for($i=0; $i < count($data->menun_osat[0]); $i++): ?>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="select_<?php echo $data->menun_osat[0][$i]; ?>"><?php echo $data->menun_osat[1][$i]; ?>:</label>
        <div class="col-sm-3">
            <select class="form-control" id="select_<?php echo $data->menun_osat[0][$i]; ?>" name="<?php echo $data->menun_osat[0][$i]; ?>">
                <option value="-1"></option>
                <?php foreach ($data->reseptit as $resepti): ?>
                <option value="<?php echo $resepti->getId(); ?>" <?php if((!empty($data->menun_reseptit[$i][1])) && ($data->menun_reseptit[$i][1] === $resepti->getId())) { echo 'selected';} ?> ><?php echo htmlspecialchars($resepti->getNimi()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <?php endfor; ?>
    <br>
    <!-- -->
    <!-- Kuvaus -->
    <div class="form-group">
        <label class="control-label col-sm-2" for="textKuvaus">Menun kuvaus:</label>
        <div class="col-sm-6">
            <textarea class="form-control" id="textKuvaus" name="kuvaus" rows="6"><?php if (isset($data->menu)){ echo htmlspecialchars($data->menu->getKuvaus()); } ?></textarea>
        </div>
    </div>
    <br>
    <!-- -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-2">
            <button type="submit" class="btn btn-default">Tallenna</button>
        </div>
    </div>
</form>