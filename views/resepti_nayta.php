<ol class="breadcrumb">
  <li><a href="reseptit.php">Haku</a></li>
  <li class="active">Resepti</li>
</ol>

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
<p>Juomasuositus: <?php echo htmlspecialchars($data->resepti->getJuomasuositus()); ?></p>
<p>Lähde: <?php echo htmlspecialchars($data->resepti->getLahde()); ?></p>
<br>
<br>
<?php if (onkoAdmin() || (onkoMuokkaaja() && ($data->resepti->getId() === $_SESSION['kayttajan_id']))): ?>
<div class="row">
    <div class="col-md-2">
        <form action='reseptit.php' method="get">
            <input type="hidden" name="muokkaa" value="<?php echo $data->resepti->getId(); ?>">
            <input type="submit" class="btn btn-info btn-sm" value="Muokkaa reseptiä">
        </form>
    </div>
    <div class="col-md-2">
        <form action='reseptit.php?poista' method="post" onsubmit="return confirm('Oletko varma?')">
            <input type="hidden" name="id" value="<?php echo $data->resepti->getId(); ?>">
            <input type="submit" class="btn btn-danger btn-sm" value="Poista resepti">
        </form>
    </div>
</div>
<?php endif; ?>
