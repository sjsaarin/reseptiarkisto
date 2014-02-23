<h2>Ostoslista</h2>
<br>
<?php if (isset($_SESSION['ostoslista'])): ?>
    <table class="table-condensed">
        <thead>
        <th class="col-md-4">Raaka-aine:</th>
        <th class="col-md-2">Määrä:</th>
        <th class="col-md-2">Kilohinta:</th>
    </thead>
    <tbody>
        <?php foreach ($_SESSION['ostoslista'] as $rivi): ?>
            <tr>
                <td><?php echo htmlspecialchars($rivi[0]); ?></td>
                <td><?php echo $rivi[1]; ?> <?php echo $rivi[2]; ?></td>
                <td><?php echo $rivi[3]; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
    <br>
    <a href="ostoslista.php?tyhjenna">Tyhjennä lista</a>
<?php endif;

