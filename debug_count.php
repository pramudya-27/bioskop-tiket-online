<?php
include 'config/crud.php';

try {
    $sql = "SELECT COUNT(*) as cnt FROM dtl_pemesan";
    $result = $proses->con->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo "Total Rows: " . $row['cnt'];
    
    echo "<br>Last Insert ID Test Check: ";
    // Insert another dummy to see if it increments
    $proses->con->exec("INSERT INTO dtl_pemesan (kursi) VALUES (999)"); 
    // This will fail because of other NOT NULL cols, but we want to see error
    print_r($proses->con->errorInfo());

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
