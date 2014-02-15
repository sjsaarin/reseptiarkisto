<h1><?php echo htmlspecialchars($data->resepti->getNimi()); ?></h1>
<br>
<table class="table">
    <tbody>
        <?php foreach ($data->raakaaineet as $asia): ?>
            <tr>
                <td><?php echo htmlspecialchars($asia[0]); ?> </td>
                <td><?php echo $asia[1]; ?> <?php echo $asia[2]; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<br>
<p>Annoksia: <?php echo $data->resepti->getAnnoksia(); ?></p>
<p>Juomasuositus: <?php echo $data->resepti->getJuomasuositus(); ?></p>
<pre><?php echo htmlspecialchars($data->resepti->getValmistusohje()); ?></pre>
<p>Lähde: <?php echo $data->resepti->getLahde(); ?></p>
