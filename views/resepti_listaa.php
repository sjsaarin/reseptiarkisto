<div class="container">
    <h1>Reseptit</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>Nimi</th>
                <!--th>Kategoria</th-->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->reseptit as $asia): ?>
                <tr>
                    <td><?php echo $asia->getId(); ?></td>
                    <td><?php echo $asia->getNimi(); ?></td>
                    <!--td><?#php echo $asia->getKategoria(); ?></td-->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p>Reseptejä yhteensä: <?php echo $data->lkm ?></p>
</div>