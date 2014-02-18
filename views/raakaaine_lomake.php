<?php if ($data->tila == 'lisaa'): ?>
<h1>Lisää raaka-aine</h1>
<?php endif; ?>
<?php if ($data->tila == 'muokkaa'): ?>
<h1>Muokkaa raaka-ainetta</h1>
<?php endif; ?>
<form class="form-horizontal" role="form" action="raakaaineet.php?<?php if ($data->tila === 'lisaa') { echo 'tallenna'; } ?><?php if ($data->tila === 'muokkaa') { echo 'paivita=' . $_SESSION['raakaaine']->getId(); } ?>" method="POST">
        <?php if (!empty($data->virheet['nimi'])): ?>
        <div class="form-group has-error">        
        <?php else: ?>
        <div class="form-group">
        <?php endif; ?> 
            <label class="col-md-2 control-label" for="inputNimi">Nimi</label>
            <div class="col-md-10">
                <input id="inputNimi" name="nimi" type="text" placeholder="nimi" value="<?php if (isset($data->raakaaine)){ echo htmlspecialchars($data->raakaaine->getNimi()); } ?>">
                <?php if (!empty($data->virheet['nimi'])): ?>
                <span class="help-inline"><?php echo $data->virheet['nimi']; ?></span>
                <?php endif; ?> 
            </div>    
        </div>
            
        <?php if (!empty($data->virheet['kalorit'])): ?>
        <div class="form-group has-error">        
        <?php else: ?>
        <div class="form-group">
        <?php endif; ?>
            <label class="col-md-2 control-label" for="inputKalorit">kcal / 100g</label>
            <div class="col-md-10">
                <input id="inputKalorit" name="kalorit" type="text" placeholder="0" value="<?php if (isset($data->raakaaine)) { echo $data->raakaaine->getKalorit(); } ?>">
                <?php if (!empty($data->virheet['kalorit'])): ?>
                <span class="help-inline"><?php echo $data->virheet['kalorit']; ?></span>
                <?php endif; ?> 
            </div>
        </div>

        <?php if (!empty($data->virheet['proteiinit'])): ?>
        <div class="form-group has-error">        
        <?php else: ?>
        <div class="form-group">
        <?php endif; ?>
            <label class="col-md-2 control-label" for="inputProteiinit">Proteiinit / 100g</label>
            <div class="col-md-10">
                <input id="inputProteiinit" name="proteiinit" type="text" placeholder="0" value="<?php if (isset($data->raakaaine)){ echo $data->raakaaine->getProteiinit(); } ?>">
                <?php if (!empty($data->virheet['proteiinit'])): ?>
                <span class="help-inline"><?php echo $data->virheet['proteiinit']; ?></span>
                <?php endif; ?> 
            </div>
        </div>

        <?php if (!empty($data->virheet['hiilarit'])): ?>
        <div class="form-group has-error">        
        <?php else: ?>
        <div class="form-group">
        <?php endif; ?>
            <label class="col-md-2 control-label" for="inputHiilarit">Hiilarit / 100g</label>
            <div class="col-md-10">
                <input id="inputHiilarit" name="hiilarit" type="text" placeholder="0" value="<?php if (isset($data->raakaaine)){ echo $data->raakaaine->getHiilarit(); } ?>">
                <?php if (!empty($data->virheet['hiilarit'])): ?>
                <span class="help-inline"><?php echo $data->virheet['hiilarit']; ?></span>
                <?php endif; ?> 
            </div>
        </div>

        <?php if (!empty($data->virheet['rasvat'])): ?>
        <div class="form-group has-error">        
        <?php else: ?>
        <div class="form-group">
        <?php endif; ?>
            <label class="col-md-2 control-label" for="inputRasvat">Rasvat / 100g</label>
            <div class="col-md-10">
                <input id="inputRasvat" name="rasvat" type="text" placeholder="0" value="<?php if (isset($data->raakaaine)){ echo $data->raakaaine->getRasvat(); } ?>">
                <?php if (!empty($data->virheet['rasvat'])): ?>
                <span class="help-inline"><?php echo $data->virheet['rasvat']; ?></span>
                <?php endif; ?> 
            </div>
        </div>

        <?php if (!empty($data->virheet['hinta'])): ?>
        <div class="form-group has-error">        
        <?php else: ?>
        <div class="form-group">
        <?php endif; ?>
            <label class="col-md-2 control-label" for="inputHinta">Hinta €/kg</label>
            <div class="col-md-10">
                <input id="inputHinta" name="hinta" type="text" placeholder="0" value="<?php if (isset($data->raakaaine)){ echo $data->raakaaine->getHinta(); } ?>">
                <?php if (!empty($data->virheet['hinta'])): ?>
                <span class="help-inline"><?php echo $data->virheet['hinta']; ?></span>
                <?php endif; ?> 
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-default">Tallenna</button>
            </div>
        </div>
</form>
