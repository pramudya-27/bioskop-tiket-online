<?php
include 'config/crud.php';

try {
    $sql = "SELECT * FROM dtl_pemesan";
    $result = $proses->con->query($sql);
    
    echo "<pre>";
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
        echo "\n";
    }
    echo "</pre>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
