<?php
// Data Fetching
// Total Users
$q_member = $proses->tampil("COUNT(*) as total", "member", "");
$total_member = $q_member->fetch()['total'];

// Total Movies
$q_film = $proses->tampil("COUNT(*) as total", "film", "");
$total_film = $q_film->fetch()['total'];

// Total Rooms
$q_ruang = $proses->tampil("COUNT(*) as total", "ruang", "");
$total_ruang = $q_ruang->fetch()['total'];

// Active Schedules (Total Jadwal)
$q_jadwal = $proses->tampil("COUNT(*) as total", "jadwal", "");
$total_jadwal = $q_jadwal->fetch()['total'];

// Tickets Sold (Paid Status = '2')
$q_tiket = $proses->tampil("COUNT(*) as total", "pemesan", "WHERE status = '2'");
$total_tiket = $q_tiket->fetch()['total'];

// Recent Users (Last 5)
$recent_users = $proses->tampil("*", "member", "ORDER BY id_member DESC LIMIT 5");
?>

<style>
    /* Light Theme Styling to match Project */
    
    /* Override .content width to fix the large gap (User Request) */
    .content {
        width: calc(100% - 280px) !important;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .dashboard-title {
        font-size: 24px;
        font-weight: 300; /* Matching common admin style */
        color: #444;
        font-family: 'Segoe UI', sans-serif; /* Matching back-end.css */
    }

    .user-info {
        text-align: right;
        color: #555;
    }
    .user-info .name {
        font-weight: 600;
        font-size: 14px;
    }
    
    /* Cards Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background-color: #fff;
        border-radius: 4px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        display: flex;
        align-items: center;
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        border-left: 4px solid #3c8dbc; /* Default accent */
    }

    .stat-card:hover {
        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
        transform: translateY(-2px);
    }

    .stat-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 24px;
        color: #fff;
    }

    .stat-content {
        flex: 1;
    }

    .stat-label {
        font-size: 12px;
        text-transform: uppercase;
        color: #777;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #333;
    }
    
    /* Specific Colors */
    .stat-card.users { border-left-color: #00c0ef; }
    .stat-card.users .stat-icon-wrapper { background-color: #00c0ef; }
    
    .stat-card.movies { border-left-color: #dd4b39; }
    .stat-card.movies .stat-icon-wrapper { background-color: #dd4b39; }
    
    .stat-card.rooms { border-left-color: #f39c12; }
    .stat-card.rooms .stat-icon-wrapper { background-color: #f39c12; }
    
    .stat-card.schedules { border-left-color: #00a65a; }
    .stat-card.schedules .stat-icon-wrapper { background-color: #00a65a; }
    
    .stat-card.tickets { border-left-color: #605ca8; }
    .stat-card.tickets .stat-icon-wrapper { background-color: #605ca8; }


    /* Recent Users Table */
    .section-title {
        font-size: 18px;
        font-weight: 400;
        color: #444;
        margin-bottom: 15px;
        border-bottom: 2px solid #3c8dbc;
        display: inline-block;
        padding-bottom: 5px;
    }

    .recent-users-container {
        background-color: #fff;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12);
        overflow: hidden;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .custom-table th {
        text-align: left;
        background-color: #f4f4f4;
        color: #333;
        padding: 12px 15px;
        font-weight: 600;
        border-bottom: 1px solid #ddd;
    }

    .custom-table td {
        padding: 12px 15px;
        color: #555;
        border-bottom: 1px solid #f0f0f0;
    }

    .custom-table tr:hover {
        background-color: #f9f9f9;
    }
    
    .user-badge {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .user-initial {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #eee;
        color: #555;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
    }
    
    .role-badge {
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 11px;
        color: #fff;
    }
    .role-member { background-color: #00a65a; }

    .action-btn {
        padding: 5px 10px;
        background-color: #3c8dbc;
        color: #fff;
        text-decoration: none;
        border-radius: 3px;
        font-size: 12px;
        transition: background-color 0.2s;
    }
    .action-btn:hover {
        background-color: #367fa9;
        color: #fff;
    }

</style>

<div class="dashboard-wrapper">
    <div class="dashboard-header">
        <div class="dashboard-title">Dashboard</div>
        <div class="user-info">
            Welcome, <span class="name"><?php echo isset($_SESSION['level']) ? $_SESSION['level'] : 'Admin'; ?></span>
        </div>
    </div>

    <div class="stats-grid">
        <!-- Total Users -->
        <div class="stat-card users">
            <div class="stat-icon-wrapper">👥</div>
            <div class="stat-content">
                <div class="stat-label">Total Users</div>
                <div class="stat-value"><?php echo $total_member; ?></div>
            </div>
        </div>

        <!-- Total Movies -->
        <div class="stat-card movies">
            <div class="stat-icon-wrapper">🎬</div>
            <div class="stat-content">
                <div class="stat-label">Total Movies</div>
                <div class="stat-value"><?php echo $total_film; ?></div>
            </div>
        </div>

        <!-- Total Rooms -->
        <div class="stat-card rooms">
            <div class="stat-icon-wrapper">🏢</div>
            <div class="stat-content">
                <div class="stat-label">Total Rooms</div>
                <div class="stat-value"><?php echo $total_ruang; ?></div>
            </div>
        </div>

        <!-- Active Schedules -->
        <div class="stat-card schedules">
            <div class="stat-icon-wrapper">📅</div>
            <div class="stat-content">
                <div class="stat-label">Total Jadwal</div>
                <div class="stat-value"><?php echo $total_jadwal; ?></div>
            </div>
        </div>

        <!-- Tickets Sold -->
        <div class="stat-card tickets">
            <div class="stat-icon-wrapper">🎫</div>
            <div class="stat-content">
                <div class="stat-label">Tiket Terjual</div>
                <div class="stat-value"><?php echo $total_tiket; ?></div>
            </div>
        </div>
    </div>

    <div class="section-title">New Users</div>
    <div class="recent-users-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_users as $user) { 
                    $role = "Member"; 
                    $initial = strtoupper(substr($user['nama'], 0, 1));
                    $raw_date = isset($user[5]) ? $user[5] : (isset($user['tgl_daftar']) ? $user['tgl_daftar'] : 'N/A');
                    $joined_date = ($raw_date != 'N/A') ? date("d M Y", strtotime($raw_date)) : '-';
                ?>
                <tr>
                    <td>
                        <div class="user-badge">
                            <div class="user-initial" style="background-color: <?php echo '#' . substr(md5($user['nama']), 0, 6); ?>; color: #fff;">
                                <?php echo $initial; ?>
                            </div>
                            <span><?php echo $user['nama']; ?></span>
                        </div>
                    </td>
                    <td><?php echo $user['email']; ?></td>
                    <td><span class="role-badge role-member"><?php echo $role; ?></span></td>
                    <td><?php echo $joined_date; ?></td>
                    <td><a href="?p=tmp_member" class="action-btn">Detail</a></td>
                </tr>
                <?php } ?>
                
                <?php if ($recent_users->rowCount() == 0) { ?>
                <tr>
                    <td colspan="5" style="text-align:center; color:#777; padding: 20px;">No users found.</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
