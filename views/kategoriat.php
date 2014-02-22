<h1>Kategoriat</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nimi</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data->kategoriat as $kategoria): ?>
            <tr>
                <td><?php echo htmlspecialchars($kategoria->getNimi()); ?></a></td>
                <td>
                    <form action='kategoriat.php' method="post" onsubmit="return confirm('Oletko varma?')">
                        <input type="hidden" name="id" value="<?php echo $kategoria->getId(); ?>">
                        <input type="submit" class="btn btn-danger btn-xs" value="Poista">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="col-md-6">
<h3>Lisää kategoria:</h3>
<form role="form" action="kategoriat.php?lisaa" method="POST">
  <?php if (!empty($data->virheet['nimi'])): ?>
  <div class="form-group has-error">        
  <?php else: ?>
  <div class="form-group">
  <?php endif; ?> 
    <!--label for="inputNimi">Kategorian nimi</label-->
    <input type="text" class="form-control" id="inputNimi" name="nimi" placeholder="Kategorian nimi" value="<?php if (isset($data->kategoria)){ echo $data->kategoria->getNimi(); }; ?>">
    <?php if (!empty($data->virheet['nimi'])): ?>
        <span class="help-inline"><?php echo $data->virheet['nimi']; ?></span>
    <?php endif; ?> 
  </div>
  <div class="form-group">
    <button type="submit" class="btn btn-default">Lisää</button>
  </div>
</form>
</div>