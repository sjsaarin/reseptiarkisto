<h2>Käyttäjän tiedot</h2>
<table>
    <tr>
        <td><b>Nimi:</b></td>
        <td><?php echo htmlspecialchars($_SESSION['kayttaja']->getNimi()) ?></td>
    </tr>
    <tr>
        <td><b>Rooli:</b></td>
        <td><?php if ($_SESSION['kayttaja']->getRooli() === 1) { echo "ylläpitäjä"; } else { echo "käyttäjä";} ?></td>
    </tr>
</table>
<br>
<a href="kirjautuminen.php?logout">Kirjaudu ulos</a>
