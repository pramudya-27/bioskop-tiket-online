<?php
include 'config/crud.php';

try {
    $sql = "SHOW CREATE TABLE pemesan";
    $result = $proses->con->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo "<pre>" . print_r($row, true) . "</pre>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
