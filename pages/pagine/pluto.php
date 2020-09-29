<p> pluto content. Woof!</p>
<?php
$data = $_POST;

$isFilledForm = isset($_POST['name']) && $_POST['name'] && isset($_GET['form']) && $_GET['form'] == 1;

if ( ! $isFilledForm) {
    ?>
    <form style="border: 1px solid black; padding: 30px; margin: 0 auto; display: block" method="POST" action="?form=1">
        <fieldset>
            <legend>Invia una richiesta a pluto</legend>
            <label>Nome</label>
            <input name="name"/><br/>
            <label>Cognome</label>
            <input name="surname"/><br/>
            <button type=submit>Invia</button>
        </fieldset>
    </form>
    <?php
} else {
    ?>
    Messaggio inviato a <strong><?php echo htmlspecialchars($_POST['name']) ?></strong><br/>
    <a href="<?php echo $_SERVER['REQUEST_URI'] ?>">Torna Indietro</a>
    <?php
}

$isFilledForm = isset($_POST['name']) && $_POST['name'] && isset($_GET['form']) && $_GET['form'] == 2;
if ( ! $isFilledForm) {
    ?>
    <form style="border: 1px solid black; padding: 30px; margin: 0 auto; display: block" method="POST" action="?form=2">
        <legend>Invia un'altra richiesta a pluto</legend>
        <label>Nome</label>
        <input name="name"/><br/>
        <button type=submit>Invia</button>
    </form>
    <?php
} else {
    ?>
    Messaggio inviato a <strong><?php echo htmlspecialchars($_POST['name']) ?></strong><br/>
    <a href="<?php echo $_SERVER['REQUEST_URI'] ?>">Torna Indietro</a>
    <?php
}

echo "<h2>GET DATA</h2>";
var_dump($_GET);
echo "<h2>POST DATA</h2>";
var_dump($_POST);
echo "<h3>SERVER DATA</h2>";
var_dump($_SERVER);
?>
