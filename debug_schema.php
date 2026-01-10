<?php
include 'config/crud.php';

try {
    $sql = "DESCRIBE dtl_pemesan";
    $result = $proses->con->query($sql);
    
    echo "<h2>Columns in dtl_pemesan:</h2><ul>";
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>" . $row['Field'] . " (" . $row['Type'] . ")</li>";
    }
    echo "</ul>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
