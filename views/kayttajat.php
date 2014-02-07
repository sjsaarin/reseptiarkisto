<h1>Käyttäjien tiedot</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>id</th>
            <th>Nimi</th>
            <th>Käyttäjätunnus</th>
            <th>Rooli</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lista as $asia): ?>
            <tr>
                <td><?php echo $asia->getId(); ?></td>
                <td><?php echo $asia->getNimi(); ?></td>
                <td><?php echo $asia->getKayttajatunnus(); ?></td>
                <td><?php echo $asia->getRooli(); ?></td>
                <?php if (!empty($data->virhe)) {
                    
                } ?> 
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>                
