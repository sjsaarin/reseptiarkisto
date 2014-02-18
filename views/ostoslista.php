<h2>Ostoslista</h2>
<br>
<br>
<?php if (isset($_SESSION['ostoslista'])): ?>
<table>
    <thead>
    <th>Raaka-aine:</th>
    <th>Määrä:</th>
    <th>Kilohinta:</th>
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
<?php endif; ?>

