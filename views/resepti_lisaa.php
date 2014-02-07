<form class="form-horizontal">
    <fieldset>

        <!-- Form Name -->
        <legend>Lisää uusi resepti</legend>

        <!-- Text input-->
        <div class="control-group">
            <label class="control-label" for="nimi">Nimi</label>
            <div class="controls">
                <input id="nimi" name="nimi" type="text" placeholder="" class="input-xlarge">

            </div>
        </div>

        <!-- File Button --> 
        <div class="control-group">
            <label class="control-label" for="lisaa_kuva">Lisää kuva</label>
            <div class="controls">
                <input id="lisaa_kuva" name="lisaa_kuva" class="input-file" type="file">
            </div>
        </div>

        <!-- Select Basic -->
        <div class="control-group">
            <label class="control-label" for="raakaaine">Raakaaineet</label>
            <div class="controls">
                <select id="raakaaine" name="raakaaine" class="input-xlarge">
                </select>
            </div>
        </div>

        <!-- Text input-->
        <div class="control-group">
            <label class="control-label" for="määrä">Määrä</label>
            <div class="controls">
                <input id="määrä" name="määrä" type="text" placeholder="" class="input-mini">

            </div>
        </div>

        <!-- Select Basic -->
        <div class="control-group">
            <label class="control-label" for="yksikkö">Yksikkö</label>
            <div class="controls">
                <select id="yksikkö" name="yksikkö" class="input-mini">
                </select>
            </div>
        </div>

        <!-- Button -->
        <div class="control-group">
            <label class="control-label" for="singlebutton">Lisää raaka-aine</label>
            <div class="controls">
                <button id="singlebutton" name="singlebutton" class="btn btn-primary">Lisää</button>
            </div>
        </div>

        <!-- Textarea -->
        <div class="control-group">
            <label class="control-label" for="ohje">Valmistusohjeet</label>
            <div class="controls">                     
                <textarea id="ohje" name="ohje">default text</textarea>
            </div>
        </div>

    </fieldset>
</form>