<?php
include 'config/crud.php';

// Force error display
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    echo "<h3>Testing Insert into dtl_pemesan</h3>";
    
    // Dummy Logic
    $kursi = 99;
    $id_tiket = 'test_ticket';
    $id_pemesan = 'test_order';
    $tgl_tayang = '2026-01-01'; // Default test date
    $id_sesi = 'test_sesi';

    $sql = "INSERT INTO dtl_pemesan (id_dtl_pemesan, kursi, id_tiket, id_pemesan, tgl_tayang, id_sesi) 
            VALUES (NULL, '$kursi', '$id_tiket', '$id_pemesan', '$tgl_tayang', '$id_sesi')";
            
    echo "Executing: $sql <br>";
    
    $stmt = $proses->con->prepare($sql);
    if ($stmt->execute()) {
        echo "<strong>Success!</strong> Row inserted. ID: " . $proses->con->lastInsertId();
    } else {
        echo "<strong>Failed!</strong> Error: ";
        print_r($stmt->errorInfo());
    }

} catch (PDOException $e) {
    echo "<strong>Exception:</strong> " . $e->getMessage();
}
?>
