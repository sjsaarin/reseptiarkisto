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
<form action='ostoslista.php' method="post">
    <input type="hidden" name="resepti" value="<?php echo $data->resepti->getId(); ?>">
    <input type="submit" class="btn btn-xs" value="Lisää raaka-aineet ostolistalle">
</form>
<br>
<p>Annoksia: <?php echo $data->resepti->getAnnoksia(); ?></p>
<h3>Valmistusohje:</h3>
<pre><?php echo htmlspecialchars($data->resepti->getValmistusohje()); ?></pre>
<p>Juomasuositus: <?php echo $data->resepti->getJuomasuositus(); ?></p>
<p>Lähde: <?php echo $data->resepti->getLahde(); ?></p>
<br>
<br>
<?php if(onkoAdmin()): ?>
<table>
    <tr>
        <td>
<form action='reseptit.php' method="post" onsubmit="return confirm('Oletko varma?')">
    <input type="hidden" name="id" value="<?php echo $data->resepti->getId(); ?>">
    <input type="submit" class="btn btn-danger btn-xs" value="Poista resepti">
</form>
        </td>
        <td>
            <form action='reseptit.php' method="get">
    <input type="hidden" name="muokkaa" value="<?php echo $data->resepti->getId(); ?>">
    <input type="submit" class="btn btn-primary btn-xs" value="Muokkaa reseptiä">
</form>
        </td>
    </tr>
<?php endif; ?>
