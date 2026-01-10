<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "Starting Test...<br>";

if (file_exists('config/crud.php')) {
    include 'config/crud.php';
    echo "Included crud.php<br>";
} else {
    die("crud.php not found");
}

if (isset($proses)) {
    echo "Proses object exists.<br>";
} else {
    die("Proses object missing");
}

if ($proses->con) {
    echo "Connection object exists.<br>";
} else {
    die("Connection object missing");
}

try {
    $sql = "INSERT INTO dtl_pemesan (id_dtl_pemesan, kursi, id_tiket, id_pemesan, tgl_tayang, id_sesi) VALUES (NULL, 999, 'TEST', 'TEST_ORD', '2026-01-01', 'TEST_SESI')";
    echo "Query: $sql <br>";

    $count = $proses->con->exec($sql);
    
    if ($count === false) {
        echo "Exec failed.<br>";
        print_r($proses->con->errorInfo());
    } else {
        echo "Exec success. Rows affected: $count. ID: " . $proses->con->lastInsertId() . "<br>";
    }

} catch (Exception $e) {
    echo "Exception: " . $e->getMessage();
}
echo "End Test.<br>";
?>
