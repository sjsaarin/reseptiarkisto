<ol class="breadcrumb">
  <li><a href="raakaaineet.php">Haku</a></li>
  <li class="active">Raaka-aine</li>
</ol>
<?php if (!$data->raakaaine == null): ?>
    <h2><?php echo htmlspecialchars($data->raakaaine->getNimi()); ?></h2>
    <br>
    <table>
        <thead>
            <th class="col-sm-3"></th>
            <th class="col-sm-2"></th>
            <th class="col-sm-2"></th>
        </thead>
        <tbody>
        <tr>
            <td><b>Energiaa: </b></td>
            <td><?php echo $data->raakaaine->getKalorit(); ?></td>
            <td>kcal / 100g</td>
        </tr>
        <tr>
            <td><b>Proteiineja: </b></td>
            <td><?php echo $data->raakaaine->getProteiinit(); ?> </td>
            <td>g / 100g</td>
        </tr>
        <tr>
            <td><b>Rasvoja: </b></td>
            <td><?php echo $data->raakaaine->getRasvat(); ?> </td>
            <td>g / 100g</td>
        </tr>
        <tr>
            <td><b>Hiilihydraatteja: </b></td>
            <td><?php echo $data->raakaaine->getHiilarit(); ?> </td>
            <td>g / 100g</td>
        </tr>
        <tr>
            <td><b>Hinta: </b></td>
            <td><?php echo $data->raakaaine->getHinta(); ?> </td>
            <td>€ / kg</td>
        </tr>
        </tbody>
    </table>
    <br>
<?php if (onkoMuokkaaja()): ?>
            <div class="row">
                <div class="col-md-2">
                    <form action='raakaaineet.php' method="get">
                        <input type="hidden" name="muokkaa" value="<?php echo $data->raakaaine->getId(); ?>">
                        <input type="submit" class="btn btn-info btn-sm" value="Muokkaa raaka-ainetta">
                    </form>
                </div>
                <div class="col-md-2">
                    <form action='raakaaineet.php?poista' method="post" onsubmit="return confirm('Oletko varma?')">
                        <input type="hidden" name="id" value="<?php echo $data->raakaaine->getId(); ?>">
                        <input type="submit" class="btn btn-danger btn-sm" value="Poista raaka-aine">
                    </form>
                </div>
            </div>
<?php endif; ?>
<?php endif;
