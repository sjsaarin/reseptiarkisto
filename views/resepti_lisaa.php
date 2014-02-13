<h1>Lisää resepti</h1>
<form role="form">
  <div class="form-group">
    <label for="inputNimi">Reseptin nimi</label>
    <input type="text" class="form-control" id="inputNimi" placeholder="Reseptin nimi">
  </div>
  <div class="form-group">
    <label for="inputKuva">Lisää kuva</label>
    <input type="file" id="inputKuva">
    <!--<p class="help-block">Example block-level help text here.</p>-->
  </div>
  <div class="form-group">
    <label for="selectKategoria">Kategoria</label>
    <select class="form-control" id="selectKategoria">
        <?php foreach ($data->kategoriat as $asia): ?>
        <option value="<?php echo $asia->getId(); ?>"><?php echo htmlspecialchars($asia->getNimi()); ?></option>
        <?php endforeach; ?>
    </select>
  </div>
    <h3>Lisää raaka-aine</h3>
    <ul>
        <li>raaka-aine1 10dl</li>
        <li>raaka-aine2 20g</li>
    </ul>
    
  <div class="form-group">
    <label for="selectRaakaine">Nimi:</label>
    <select class="form-control" id="selectRaakaine">
        <?php foreach ($data->raakaaineet as $asia): ?>
        <option value="<?php echo $asia->getId(); ?>"><?php echo htmlspecialchars($asia->getNimi()); ?></option>
        <?php endforeach; ?>
    </select>
    <label for="inputMaara">Määrä:</label>
    <input type="number" class="form-control" id="inputMaara" placeholder="0.0">
    <label for="selectYksikkö">Yksikkö:</label>
    <select class="form-control" id="selectYksikko">
        <?php foreach ($data->yksikot as $yksikko): ?>
        <option value="<?php echo $yksikko; ?>"><?php echo $yksikko; ?></option>
        <?php endforeach; ?>
    </select>
    <label>
        <input type="checkbox"> Pääraaka-aine
    </label>
    <button type="button" class="btn btn-default btn-xs">Lisää raaka-aine</button>
  </div>
  <div class="form-group">
    <label for="inputOhje">Valmistusohje</label>
    <textarea class="form-control" id="inputOhje" rows="10"></textarea>
  </div>
  <div class="form-group">
    <label for="inputJuomasuositus">Juomasuositus</label>
    <input type="text" class="form-control" id="inputJuomasuositus" placeholder="Juomasuositus">
  </div>
  <div class="form-group">
    <label for="inputLahde">Tekijä / Lähde</label>
    <input type="text" class="form-control" id="inputLahde" placeholder="Lähde">
  </div>  
  <!--
  <div class="checkbox">
    <label>
      <input type="checkbox"> Check me out
    </label>
  </div>
  -->
  <button type="submit" class="btn btn-default">Tallenna</button>
</form>