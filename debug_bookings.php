<?php
include 'config/crud.php';

try {
    $sql = "SELECT * FROM dtl_pemesan";
    $result = $proses->con->query($sql);
    
    if (!$result) {
        echo "Query Failed!<br>";
        print_r($proses->con->errorInfo());
        exit;
    }

    echo "<h2>Data in dtl_pemesan:</h2><table border='1'><tr><th>ID</th><th>Kursi</th><th>Tiket</th><th>Date</th><th>Session</th></tr>";
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['id_dtl_pemesan'] . "</td>";
        echo "<td>" . $row['kursi'] . "</td>";
        echo "<td>" . $row['id_tiket'] . "</td>";
        // Check if keys exist (in case of schema changes)
        echo "<td>" . (isset($row['tgl_tayang']) ? $row['tgl_tayang'] : 'N/A') . "</td>";
        echo "<td>" . (isset($row['id_sesi']) ? $row['id_sesi'] : 'N/A') . "</td>";
        echo "</tr>";
    }
    echo "</table>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
