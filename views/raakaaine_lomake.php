<ol class="breadcrumb">
    <li><a href="raakaaineet.php">Haku</a></li>
<?php if ($data->tila === 'lisaa'): ?>
    <li class="active">Lisäys</li>
</ol>
<h1>Lisää raaka-aine</h1>
<?php endif; ?>
<?php if ($data->tila === 'muokkaa'): ?>
    <li><a href="raakaaineet.php?nayta=<?php echo $data->raakaaine->getId(); ?>">Raaka-aine</a></li>
    <li class="active">Muokkaus</li>
</ol>
<h1>Muokkaa raaka-ainetta: <?php echo htmlspecialchars($data->raakaaine->getNimi()); ?></h1>
<?php endif; ?>
<form class="form-horizontal" role="form" action="raakaaineet.php?<?php if ($data->tila === 'lisaa') { echo 'tallenna'; } ?><?php if ($data->tila === 'muokkaa') { echo 'paivita=' . $_SESSION['raakaaine']->getId(); } ?>" method="POST">
        <?php if (!empty($data->virheet['nimi'])): ?>
        <div class="form-group has-error">        
        <?php else: ?>
        <div class="form-group">
        <?php endif; ?> 
            <label class="col-sm-2 control-label" for="inputNimi">Nimi</label>
            <div class="col-sm-3">
                <input id="inputNimi" class="form-control" name="nimi" type="text" placeholder="nimi" value="<?php if (isset($data->raakaaine)){ echo htmlspecialchars($data->raakaaine->getNimi()); } ?>"> 
            </div>
            <?php if (!empty($data->virheet['nimi'])): ?>
                <p class="help-block"><?php echo $data->virheet['nimi']; ?></p>
            <?php endif; ?>
        </div>
            
        <?php if (!empty($data->virheet['kalorit'])): ?>
        <div class="form-group has-error">        
        <?php else: ?>
        <div class="form-group">
        <?php endif; ?>
            <label class="col-sm-2 control-label" for="inputKalorit">kcal / 100g</label>
            <div class="col-sm-2">
                <input id="inputKalorit" class="form-control" name="kalorit" type="text" placeholder="0" value="<?php if (isset($data->raakaaine)) { echo $data->raakaaine->getKalorit(); } ?>"> 
            </div>
            <?php if (!empty($data->virheet['kalorit'])): ?>
                <p class="help-block"><?php echo $data->virheet['kalorit']; ?></p>
            <?php endif; ?>
        </div>

        <?php if (!empty($data->virheet['proteiinit'])): ?>
        <div class="form-group has-error">        
        <?php else: ?>
        <div class="form-group">
        <?php endif; ?>
            <label class="col-sm-2 control-label" for="inputProteiinit">Proteiinit / 100g</label>
            <div class="col-sm-2">
                <input id="inputProteiinit" class="form-control" name="proteiinit" type="text" placeholder="0" value="<?php if (isset($data->raakaaine)){ echo $data->raakaaine->getProteiinit(); } ?>">
            </div>
            <?php if (!empty($data->virheet['proteiinit'])): ?>
                <p class="help-block"><?php echo $data->virheet['proteiinit']; ?></p>
            <?php endif; ?>
        </div>

        <?php if (!empty($data->virheet['hiilarit'])): ?>
        <div class="form-group has-error">        
        <?php else: ?>
        <div class="form-group">
        <?php endif; ?>
            <label class="col-sm-2 control-label" for="inputHiilarit">Hiilarit / 100g</label>
            <div class="col-sm-2">
                <input id="inputHiilarit" class="form-control" name="hiilarit" type="text" placeholder="0" value="<?php if (isset($data->raakaaine)){ echo $data->raakaaine->getHiilarit(); } ?>"> 
            </div>
            <?php if (!empty($data->virheet['hiilarit'])): ?>
                <p class="help-block"><?php echo $data->virheet['hiilarit']; ?></p>
            <?php endif; ?>
        </div>

        <?php if (!empty($data->virheet['rasvat'])): ?>
        <div class="form-group has-error">        
        <?php else: ?>
        <div class="form-group">
        <?php endif; ?>
            <label class="col-sm-2 control-label" for="inputRasvat">Rasvat / 100g</label>
            <div class="col-sm-2">
                <input id="inputRasvat" class="form-control" name="rasvat" type="text" placeholder="0" value="<?php if (isset($data->raakaaine)){ echo $data->raakaaine->getRasvat(); } ?>">    
            </div>
            <?php if (!empty($data->virheet['rasvat'])): ?>
                <p class="help-block"><?php echo $data->virheet['rasvat']; ?></p>
            <?php endif; ?>
        </div>

        <?php if (!empty($data->virheet['hinta'])): ?>
        <div class="form-group has-error">        
        <?php else: ?>
        <div class="form-group">
        <?php endif; ?>
            <label class="col-sm-2 control-label" for="inputHinta">Hinta €/kg</label>
            <div class="col-sm-2">
                <input id="inputHinta" class="form-control" name="hinta" type="text" placeholder="0" value="<?php if (isset($data->raakaaine)){ echo $data->raakaaine->getHinta(); } ?>"> 
            </div>
            <?php if (!empty($data->virheet['hinta'])): ?>
                <p class="help-block"><?php echo $data->virheet['hinta']; ?></p>
            <?php endif; ?>
        </div>
            
        <?php if (!empty($data->virheet['tiheys'])): ?>
        <div class="form-group has-error">        
        <?php else: ?>
        <div class="form-group">
        <?php endif; ?>
            <label class="col-sm-2 control-label" for="inputHinta">Tiheys g/dl</label>
            <div class="col-sm-2">
                <input id="inputTiheys" class="form-control" name="tiheys" type="text" placeholder="0" value="<?php if (isset($data->raakaaine)){ echo $data->raakaaine->getTiheys(); } ?>"> 
            </div>
            <?php if (!empty($data->virheet['tiheys'])): ?>
                <p class="help-block"><?php echo $data->virheet['tiheys']; ?></p>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($data->virheet['kpl_paino'])): ?>
        <div class="form-group has-error">        
        <?php else: ?>
        <div class="form-group">
        <?php endif; ?>
            <label class="col-sm-2 control-label" for="inputKplPaino">Paino (g)/kpl</label>
            <div class="col-sm-2">
                <input id="inputKplPaino" class="form-control" name="kpl_paino" type="text" placeholder="0" value="<?php if (isset($data->raakaaine)){ echo $data->raakaaine->getKplPaino(); } else { echo 0; } ?>"> 
            </div>
            <?php if (!empty($data->virheet['kpl_paino'])): ?>
                <p class="help-block"><?php echo $data->virheet['kpl_paino']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-2">
                <button type="submit" class="btn btn-default">Tallenna</button>
            </div>
        </div>
</form>
