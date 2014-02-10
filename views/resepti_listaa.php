<div class="container">
    <h1>Reseptit</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nimi</th>
                <th>Kategoria</th>
                <th>Pääraaka-aine</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->reseptit as $asia): ?>
                <tr>
                    <td><a href="reseptit.php?nayta=<?php echo $asia->getId(); ?>"</a><?php echo htmlspecialchars($asia->getNimi()); ?></td>
                    <td><?php echo htmlspecialchars($asia->getKategoria()); ?></td>
                    <td><?php echo $asia->getPaaraakaaine(); ?></td-->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p>Reseptejä yhteensä: <?php echo $data->lkm ?></p>
</div>