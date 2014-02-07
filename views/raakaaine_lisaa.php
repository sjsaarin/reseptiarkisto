<form class="form-horizontal" role="form" action="raakaineenlisays.php" method="POST">
    <fieldset>

        <legend>Lisää raaka-aine</legend>

        <div class="control-group">
            <label class="control-label" for="nimi">Nimi</label>
            <div class="controls">
                <input id="nimi" name="nimi" type="text" placeholder="" class="input-xlarge">

            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="kalorit">kcal / 100g</label>
            <div class="controls">
                <input id="kalorit" name="kalorit" type="number" placeholder="" class="input-mini">

            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="proteiinit">Proteiinit / 100g</label>
            <div class="controls">
                <input id="proteiinit" name="proteiinit" type="number" placeholder="" class="input-mini">

            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="hiilarit">Hiilarit / 100g</label>
            <div class="controls">
                <input id="hiilarit" name="hiilarit" type="number" placeholder="" class="input-mini">

            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="rasvat">Rasvat / 100g</label>
            <div class="controls">
                <input id="rasvat" name="rasvat" type="number" placeholder="" class="input-mini">

            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="hinta">Hinta €/kg</label>
            <div class="controls">
                <input id="hinta" name="hinta" type="number" placeholder="" class="input-mini">

            </div>
        </div>
        
        <div class="control-group">
            <button type="submit" class="btn btn-default">Tallenna</button>
        </div>
       
    </fieldset>
</form>
<table>
    <tr><td>Nimi: </td><td><?php echo $data->virheet['nimi']; ?></td></tr>
    <tr><td>Kalorit: </td><td><?php echo $data->virheet['kalorit']; ?></td></tr>
    <tr><td>Proteiinit: </td><td><?php echo $data->virheet['proteiinit']; ?></td></tr>
    <tr><td>Rasvat: </td><td><?php echo $data->virheet['rasvat']; ?></td></tr>
    <tr><td>Hiilarit </td><td><?php echo $data->virheet['hiilarit']; ?></td>
    <tr><td>Hinta </td><td><?php echo $data->virheet['hinta']; ?></td></tr>
</table>