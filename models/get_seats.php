<?php
// Ensure no output before JSON
ob_start();

// Disable display errors to prevent HTML injection in JSON
ini_set('display_errors', 0);
ini_set('log_errors', 1);

try {
    // Determine path simply like s_dtl_pesan.php
    // Assuming this file is in models/
    include '../config/crud.php';

    if (!isset($proses)) {
        throw new Exception("Database connection failed (proses object missing).");
    }

    $id_tiket = isset($_POST['id_tiket']) ? $_POST['id_tiket'] : '';
    $tgl_tayang = isset($_POST['tgl_tayang']) ? $_POST['tgl_tayang'] : ''; // Corrected parameter
    $id_sesi = isset($_POST['id_sesi']) ? $_POST['id_sesi'] : '';

    $occupied_seats = [];

    if (!empty($id_tiket) && !empty($tgl_tayang) && !empty($id_sesi)) {
        $id_tiket = addslashes($id_tiket);
        $tgl_tayang = addslashes($tgl_tayang);
        $id_sesi = addslashes($id_sesi);

        $sql = "SELECT kursi FROM dtl_pemesan 
                WHERE id_tiket = '$id_tiket' 
                AND tgl_tayang = '$tgl_tayang' 
                AND id_sesi = '$id_sesi'
                ORDER BY kursi ASC";
        
        // Execute query
        $result = $proses->con->query($sql);
        
        if ($result) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $occupied_seats[] = (int)$row['kursi'];
            }
        } else {
             // Query failed
             $errorInfo = $proses->con->errorInfo();
             throw new Exception("Query failed: " . $errorInfo[2]);
        }
    }

    ob_clean();
    header('Content-Type: application/json');
    echo json_encode($occupied_seats);

} catch (Throwable $e) {
    ob_clean();
    // Return 200 but with error field to allow client parsing
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
