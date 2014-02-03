<div class="container">
    <h1>Raaka-aineet</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>Raaka-aine</th>
                <th>kcal</th>
                <th>H</th>
                <th>P</th>
                <th>R</th>
                <th>€/kg</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->raakaaineet as $asia): ?>
                <tr>
                    <td><?php echo $asia->getId(); ?></td>
                    <td><?php echo $asia->getNimi(); ?></td>
                    <td><?php echo $asia->getKalorit(); ?></td>
                    <td><?php echo $asia->getHiilarit(); ?></td>
                    <td><?php echo $asia->getProteiinit(); ?></td>
                    <td><?php echo $asia->getRasvat(); ?></td>
                    <td><?php echo $asia->getHinta(); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p>Raaka-aineita yhteensä: <?php echo $data->lkm ?></p>
</div>