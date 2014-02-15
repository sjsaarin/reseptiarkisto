<h1>Lisää resepti</h1>
<form role="form" action="reseptit.php?tallenna" method="POST">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="inputNimi">Reseptin nimi</label>
            <input type="text" class="form-control" id="inputNimi" placeholder="Reseptin nimi" name="nimi">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <label for="inputKuva">Lisää kuva</label>
            <input type="file" id="inputKuva">
            <!--<p class="help-block">Example block-level help text here.</p>-->
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label for="selectKategoria">Kategoria</label>
            <select class="form-control" id="selectKategoria" name="kategoria">
                <?php foreach ($data->kategoriat as $asia): ?>
                    <option value="<?php echo $asia->getId(); ?>"><?php echo htmlspecialchars($asia->getNimi()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <label for="lisaaRaakaaine"><h3>Raaka-aineet:</h3></label>
    <div id="lisaaRaakaaine">
    <table class="table table-striped table-condensed">
    <thead>
        <tr>
            <th class="col-md-6">Nimi:</th>
            <th class="col-md-1">Määrä:</th>
            <th class="col-md-3">Yksikkö:</th>
            <th class="col-md-2">Pääraaka-aine:</th>
        </tr>
    </thead>
    <tbody>
    <?php for ($i=0; $i < 10; $i++): ?>
    <tr>
        <td>
        <div class="form-group">
            <select class="form-control" name="raakaaine[<?php echo $i; ?>]">
                <option value=""> </option>
                <?php foreach ($data->raakaaineet as $asia): ?>
                    <option value="<?php echo $asia->getId(); ?>"><?php echo htmlspecialchars($asia->getNimi()); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        </td>
        <td>
        <div class="form-group">
            <input type="number" class="form-control" id="inputMaara" name="maara[<?php echo $i; ?>]" placeholder="0.0">
        </div>
        </td>
        <td>
        <div class="form-group">
            <select class="form-control" id="selectYksikko" name="yksikko[<?php echo $i; ?>]">
                <option value=""> </option>
                <?php foreach ($data->yksikot as $yksikko): ?>
                    <option value="<?php echo $yksikko; ?>"><?php echo $yksikko; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        </td>
        <td>
        <div class="checkbox">
            <input type="radio" name="paaraakaaine" value="<?php echo $i; ?>">
        </div>
        </td>
    </tr>
    <?php endfor; ?>
    </tbody>
    </table>
    </div>
    <div class="row">
        <div class="form-group col-md-1">
            <label for="inputAnnoksia">Annoksia</label>
            <input type="number" class="form-control" id="inputAnnoksia" placeholder=1 name="annoksia">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-8">
            <label for="inputOhje">Valmistusohje</label>
            <textarea class="form-control" id="inputOhje" name="ohje" rows="10"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="inputJuomasuositus">Juomasuositus</label>
            <input type="text" class="form-control" id="inputJuomasuositus" name="juomasuositus" placeholder="Juomasuositus">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="inputLahde">Tekijä / Lähde</label>
            <input type="text" class="form-control" id="inputLahde" name="lahde" placeholder="Lähde">
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