<?php
// 9 - Per utilizzare le classi create le dobbiamo ora "importare"
require_once __DIR__ . "/Department.php";

// 15 - Inseriamo ora la connessione al server del db.
require_once __DIR__ . "/database-connection.php";

// define("DB_SERVERNAME", "localhost");
// define("DB_USERNAME", "root");
// define("DB_PASSWORD", "root");
// define("DB_NAME", "university_db");
// define("DB_PORT", 3306);

// $conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
// // 1 - Arrivati a questo punto, se tutto è andato bene, questa pagina risulterà bianca sul browser.

// // 2 - Vogliamo controllare come sono andate le cose:

// if ($conn && $conn->connect_error) {
//   echo "DB connection error" . $conn->connect_error;
//   die();
// }

// 3 - Creiamo una query
// $sql = "SELECT * FROM `departments`;";

// 8 - Arrivati a questo punto, in questa pagina in realtà ci servono soltanto name e id del dipartimento e non tutto come facevamo all'inizio. In questo modo la query sarà più leggera e non chiederemo dati che tanto non ci interessano per il momento...
$sql = "SELECT `id`, `name` FROM `departments`;";

// 4 - Poi creiamo la variabile che esegue questa query e che conterrà il risultato
$result = $conn->query($sql);
// var_dump($result);
// 5 - A questo punto col var dump potremo visualizzare in forma di oggetto le intestazioni delle colonne senza contenuti (che sono nascosti).

$departments = []; // questo array serve successivamente.

// 6 - In questo caso abbiamo dei risultati (num_rows => 12) ma non è detto che ci siano, quindi dobbiamo controllare anche questo:
if ($result && $result->num_rows > 0) {
    // 6.1 - questo significa che ci sono dei risultati, quindi li vogliamo mostrare: usiamo un metodo di $result che si chiama fetch_assoc(). Altrernativamente c'è anche fetch_object (che preleva un oggetto).
    while($row = $result->fetch_assoc()) {
        // var_dump($row);
        // 6.2 - con var dump otterremo un array associativo con tutti i dati della tabella. Al posto del var_dump possiamo salvare in una variabile creata appositamente, tutti i risultati:
        // $departments[] = $row;
        // 6.3 - var_dump($departments); // lo commentiamo perché in realtà lo visualizzeremo in seguito nell'html

        // 10 - Creiamo un nuovo oggetto Department per fare riferimento a quello corrente e lo assegniamo al department.
        $curr_department = new Department($row["id"], $row["name"]);
        $departments[] = $curr_department;
        // 11 - Prima questo era un insieme di array associativi (separati), adesso invece è un array di oggetti (ogni oggetto è un department). Per questo motivo è necessario cambiare l'html, per visualizzarli correttamente.
    }
} elseif ($result) {
    // la query ha funzionato, ma non abbiamo rislutati.
} else {
    // la query non ha funzionato, probabilmente c'è un errore di sintassi. 
    echo "Query error";
    die();
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
    <h1>Lista dei dipartimenti universitari</h1>
    <?php foreach($departments as $department) { ?>
    <div>
        <!-- <h2><?php // echo $department["name"] ?></h2> -->
        <!-- Dal punto 10 in poi questi sono oggetti, quindi è necessario cambiare sintassi con la seguente -->
        <h2><?php echo $department->name; ?></h2>
        <!-- 13 - Aggiungiamo il link alla pagina del dipartimento -->
        <a href="single-department.php?id=<?php echo $department->id ?>">Vedi informazioni</a>
    </div>
    <?php } ?>
</body>
</html>