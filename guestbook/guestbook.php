<?php

// restituisce i dati dal file
function getRawData()
{
    global $dataFileName;
    $data = file_get_contents($dataFileName);
    $data = explode("\n", $data);

    return $data;
}

// aggiunge un nuovo dato nel file
function addData($name, $message)
{
    global $dataFileName;
    $data   = getRawData();
    $data[] = implode('|', [$name, $message]);
    $data   = implode("\r\n", $data);
    file_put_contents($dataFileName, $data);
}

// restituisce i dati pronti per essere renderizzati
function getRenderData()
{
    $data  = getRawData();
    $items = [];
    foreach ($data as $row) {
        $columns = explode('|', $row);
        if (count($columns) == 2) {
            $items[] = ['name' => $columns[0], 'message' => $columns[1]];
        }
    }

    return array_reverse($items);
}

// renderizza il form per l'inserimento di un dato
function renderForm()
{
    ?>
    <form method="POST">
        <label>Nome <input name="name" value="<?php echo $_POST['name'] ?? '' ?>"></label><br/>
        <label>Messaggio <input name="message" value="<?php echo $_POST['message'] ?? '' ?>"></label><br/>
        <input type="submit" value="Invia">
    </form>
    <?php
}

// renderizza un dato
function renderItem($item)
{
    $name = null;
    $message = null;
    extract($item);
    // $name = $item['name'];
    // $message = $item['message'];
    ?>
    <div style="border: 1px solid black">
        <strong><?php echo $name ?></strong><br/><br/>
        <?php echo $message ?>
    </div>
    <?php
}

// salva il form
function saveForm()
{
    $name    = $_POST['name'];
    $message = $_POST['message'];
    if (empty($name) || empty($message)) {
        echo "<p style=\"color: red\">compilare tutti i campi</p>";
    } else {
        echo "<p style=\"color: green\">messaggio salvato</p>";
        addData($name, $message);
    }
}

$dataFileName = 'data.txt';

if (isset($_POST['name'])) {
    saveForm();
}
renderForm();
?>
<div>
    <?php
    foreach (getRenderData() as $item) {
        renderItem($item);
    }
    ?>
</div>

