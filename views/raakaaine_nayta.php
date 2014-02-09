<?php if (!$data->raakaaine == null): ?>
    <h2><?php echo htmlspecialchars($data->raakaaine->getNimi()); ?></h2>
    <table>
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
    </table>
    <br>
    <?php if (onkoAdmin()): ?>
    <p><a href="raakaaineet.php?muokkaa=<?php echo $data->raakaaine->getId(); ?>">Muokkaa</a> | <a href="raakaaineet.php?poista=<?php echo $data->raakaaine->getId(); ?>">Poista</a><a</p>
    <?php endif; ?>
<?php else: ?>
    <a href="raakaaineet.php">Takaisin listaukseen</a>
<?php endif; ?>

