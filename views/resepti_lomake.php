<h1><?php if ($data->tila == 'lisays') echo 'Lisää resepti' ?><?php if ($data->tila == 'muokkaus') echo 'Muokkaa reseptiä: ' . $data->resepti->getNimi(); ?></h1>
<form role="form" action="reseptit.php?<?php if ($data->tila == 'lisays') echo 'tallenna' ?><?php if ($data->tila == 'muokkaus') echo 'paivita' ?>" method="POST">
    <div class="row">
        <?php if (!empty($data->virheet['nimi'])): ?>
            <div class="form-group col-md-6 has-error">        
        <?php else: ?>
            <div class="form-group col-md-6">
        <?php endif; ?>
            <label for="inputNimi">Reseptin nimi</label>
            <input type="text" class="form-control" id="inputNimi" placeholder="Reseptin nimi" name="nimi" value="<?php if(isset($data->resepti)) echo htmlspecialchars($data->resepti->getNimi()); ?>">
            <?php if (!empty($data->virheet['nimi'])): ?>
                <span class="help-inline alert-danger"><?php echo $data->virheet['nimi']; ?></span>
            <?php endif; ?>
        </div>
    </div>
    <!--
    <div class="row">
        <div class="form-group col-md-4">
            <label for="inputKuva">Lisää kuva</label>
            <input type="file" id="inputKuva">
            <!--<p class="help-block">Example block-level help text here.</p>--><!--
        </div>
    </div>
    -->
    <div class="row">
        <div class="form-group col-md-3">
            <label for="selectKategoria">Kategoria</label>
            <select class="form-control" id="selectKategoria" name="kategoria">
                <?php foreach ($data->kategoriat as $kategoria): ?>
                    <option value="<?php echo $kategoria->getId(); ?>" <?php if(isset($data->resepti) && $data->resepti->getKategoria() ==  $kategoria->getId()) echo 'selected'  ?>><?php echo htmlspecialchars($kategoria->getNimi()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <label for="lisaaRaakaaine"><h3>Raaka-aineet:</h3></label>
    <div id="lisaaRaakaaine">
    <table class="table-condensed">
    <thead>
        <tr>
            <th class="col-md-4">Nimi:</th>
            <th class="col-md-1">Määrä:</th>
            <th class="col-md-1">Yksikkö:</th>
            <th class="col-md-6"></th>
        </tr>
    </thead>
    <tbody>
    <?php for ($i=0; $i < 10; $i++): ?>
    <tr>
        <td>
        <div class="form-group">
            <select class="form-control" name="raakaaine[<?php echo $i; ?>]">
                <option value="-1"> </option>
                    <?php foreach ($data->raakaaineet as $raakaaine): ?>
                        <option value="<?php echo $raakaaine->getId(); ?>" <?php if (isset($data->asetetut_raakaaineet[$i]) && ($data->asetetut_raakaaineet[$i] == $raakaaine->getId())) echo 'selected' ; ?>><?php echo htmlspecialchars($raakaaine->getNimi()); ?></option>
                    <?php endforeach; ?>
            </select>
        </div>
        </td>
        <td>
        <div class="form-group">
            <input type="text" class="form-control" id="inputMaara" name="maara[<?php echo $i; ?>]" placeholder="0" value="<?php if (isset($data->asetetut_maarat[$i])): ?><?php echo $data->asetetut_maarat[$i]; ?><?php else: ?><?php echo 0; ?><?php endif; ?>" >
        </div>
        </td>
        <td>
        <div class="form-group">
            <select class="form-control" id="selectYksikko" name="yksikko[<?php echo $i; ?>]">
                <?php foreach ($data->yksikot as $yksikko => $arvo): ?>
                    <option value="<?php echo $yksikko; ?>" 
                    <?php if (isset($data->asetetut_raakaaineet[$i]) && isset($data->asetetut_yksikot[$i])): ?>
                        <?php if ($data->asetetut_yksikot[$i] == $yksikko) echo 'selected'; ?> 
                    <?php endif; ?>
                    ><?php echo $yksikko; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        </td>
        <td>
            <?php if($i==0 && empty($data->virheet['raakaaineet'][$i])) echo "<p>Pääraaka-aine</p>"; ?>
            <?php if (!empty($data->virheet['raakaaineet'][$i])): ?>
                <p class="alert-danger"><?php echo $data->virheet['raakaaineet'][$i] ?></p>
            <?php endif; ?>
        </td>
    </tr>
    <?php endfor; ?>
    </tbody>
    </table>
    </div>
    <div class="row">
        <div class="form-group col-md-1">
            <label for="inputAnnoksia">Annoksia</label>
            <input type="number" class="form-control" id="inputAnnoksia" placeholder=1 name="annoksia" value="<?php if (isset($data->resepti)) echo $data->resepti->getAnnoksia(); else echo 4 ?>">
            <?php if (!empty($data->virheet['annoksia'])): ?>
                <span class="help-inline alert-danger"><?php echo $data->virheet['annoksia']; ?></span>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-8">
            <label for="inputOhje">Valmistusohje</label>
            <textarea class="form-control" id="inputOhje" name="ohje" rows="10"><?php if (isset($data->resepti)) echo htmlspecialchars($data->resepti->getValmistusohje()); ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="inputJuomasuositus">Juomasuositus</label>
            <input type="text" class="form-control" id="inputJuomasuositus" name="juomasuositus" placeholder="Juomasuositus" value="<?php if (isset($data->resepti)) echo htmlspecialchars($data->resepti->getJuomasuositus()); ?>">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="inputLahde">Tekijä / Lähde</label>
            <input type="text" class="form-control" id="inputLahde" name="lahde" placeholder="Lähde" value="<?php if (isset($data->resepti)) echo htmlspecialchars($data->resepti->getLahde()); ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <button type="submit" class="btn btn-default">Tallenna</button>
        </div>
    </div>
</form>
<br>
<br>