<?php
//include 'globals.php';
//include CLASSES_PATH . '/class.Db.php';

define("HOST", "127.0.0.1");
define("DB",   "printquotes");
define("USER", "root");

if($_SERVER["SERVER_NAME"] == 'localhost') {
    define('PASS','');
} else {
    define('PASS','F4xm0d3m');
}

$charset = 'utf8';

define("DSN", "mysql:host=" . HOST . ";dbname=" . DB . ";charset=utf8");

$_POST['bin_id']      = '2';
$_POST['bin_binding'] = 'Loose Insert';

try {
    
    $pdo = new PDO(DSN, USER, PASS);

    $sql = "UPDATE bin_binding SET bin_binding = 'loosxe' WHERE bin_id = '2'";

    $stmt = $pdo->prepare($sql);
    
    //$stmt->bindParam(":bin_binding", "Loose Insert", PDO::PARAM_STR);
    
    /*foreach($_POST as $key => $value) {
        echo ":" . $key . "  " . $_POST[$key];
        $stmt->bindParam(":" . $key . "", $_POST[$key], PDO::PARAM_STR);
    }*/
    
    $stmt->execute(); 
    
} catch(PDOException $e) {
    
    echo $e->getMessage();
    
}
exit;

$query = new Query();

$table_name = "bin_bindings";

$query->update_record($table_name, $_POST, "WHERE bin_id='" . $_POST['bin_id'] . "'");

?>

