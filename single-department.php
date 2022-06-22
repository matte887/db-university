<!-- 12 - Creiamo ora questa pagina che sarà la pagina relativa ad un singolo dipartimento. Andiamo quindi nell'index ed inseriamo il link a questa pagina nell'anchor tag. -->
<?php
// 14 - Le informazioni del singolo dipartimento si prelevano dal db qui. Per farlo ci serve la connessiona al db anche qui: anzi che rifare la chiamata si sposta tutta la chiamata in un file a parte. Importiamo ora quel file (nell'html va aggiunto anche l'id dinamico).
require_once __DIR__ . "/database-connection.php";
// 19 - Si importa la classe Department...
require_once __DIR__ . "/Department.php";

// 15 - Facciamo la query per richiedere le informazioni del dipartimento. Per questo serve GET.
// $id = $_GET["id"];
// $sql = "SELECT * FROM `departments` WHERE `id`=$id;";
// 16 - Poi estraiamo il risultato
// $result = $conn->query($sql);
// 28 - Passando l'id in questo modo, rende il sistema suscettibile a sql injections, per questo, lo sostituiamo con:
$stmt = $conn->prepare("SELECT * FROM `departments` WHERE `id`=?");
$stmt->bind_param("d", $id); // In questo modo questa funzione passerà solo un numero, se venisse passato manualmente altro, verrebbe troncato...
$id = $_GET["id"];
$stmt->execute();
$result = $stmt->get_result();

// 17 - Adesso aggiungendo manualmente all'URL "?id=1", col var_dump visualizzeremo il risultato, composto da una sola riga (num_rows = 1) perché abbiamo specificato l'id che ci interessava con WHERE.
// var_dump($result);


// 18 - Nostante sia solo un risultato si predispone un array per raccogliere i risultati.
$departments = [];

// 20 - Si prosegue a controllare e gestire il risultato della query.
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $curr_department = new Department($row["id"], $row["name"]);
        // 21 - Se volessi tutti gli altri valori, è utile creare una funzione nel Department.php...
        // 23 - Uso la funzione appena creata
        $curr_department->setContactData($row["address"], $row["phone"], $row["email"], $row["website"]);
        $curr_department->head_of_department = $row["head_of_department"];
        $departments[] = $curr_department;
    }
    // var_dump($departments);
} elseif ($result) {
    echo "Il dipartimento non è stato trovato";
} else {
    echo "Errore nella query";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- 24 - Ora con un foreach mostro i risultati -->
    <?php foreach ($departments as $department) { ?>
        <h1><?php echo $department->name; ?></h1>
        <p><?php echo $department->head_of_department; ?></p>

        <!-- 25 - Per facilitare la stampa dei contatti creo una funzione in Department... -->
        <!-- 27 ed uso questa funzione -->
        <h2></h2>
        <ul>
            <?php foreach ($department->getContactsAsArray() as $key => $value) { ?>
                <li><?php echo "$key: $value" ?></li>
            <?php } ?>
        </ul>
    <?php } ?>
</body>

</html>