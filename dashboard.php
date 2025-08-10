<?php
require 'db_connect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$query = "SELECT * FROM anggota ORDER BY id DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('assets/b.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        .dashboard-container {
            max-width: 95%;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .top-menu {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .logout-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        .table-container {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: auto;
        }

        .data-table th, .data-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
            vertical-align: middle;
        }

        .data-table th {
            background-color: #f8f9fa;
            position: sticky;
            top: 0;
        }

        .data-table tr:hover {
            background-color: #f5f5f5;
        }

        .btn-group {
            display: flex;
            gap: 5px;
            justify-content: center;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 0.8em;
        }

        .btn-warning {
            background-color: #f39c12;
            color: white;
            border: none;
        }

        .btn-warning:hover {
            background-color: #d35400;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .text-ellipsis {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 10px;
            }

            .data-table th, .data-table td {
                padding: 6px;
                font-size: 0.85em;
            }

            .btn-group {
                flex-direction: column;
                gap: 3px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Dashboard Admin</h1>
        <div class="top-menu">
            <a href="tambah_anggota.php" class="btn btn-primary">+ Tambah Anggota</a>
            <a href="logout.php" class="btn logout-btn" onclick="return confirm('Yakin ingin logout?')">Logout</a>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>No. Registrasi</th>
                        <th>Alamat</th>
                        <th>Jenis Bantuan yang Diusulkan</th>
                        <th>Kelompok</th>
                        <th>Profesi</th>
                        <th>Status</th>
                        <th>Jenis Bantuan yang Sudah Diterima</th>
                        <th style="width: 150px;">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nik'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['nama_lengkap'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['nomor_registrasi'] ?? '') ?></td>
                        <td class="text-ellipsis" title="<?= htmlspecialchars($row['alamat'] ?? '') ?>">
                            <?= htmlspecialchars(strlen($row['alamat']) > 50 ? substr($row['alamat'], 0, 50) . '...' : $row['alamat']) ?>
                        </td>
                        <td><?= htmlspecialchars($row['jenis_bantuan_yang_diusulkan'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['kelompok'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['profesi'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['status'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['jenis_bantuan_yang_sudah_diterima'] ?? '') ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="edit_anggota.php?nik=<?= urlencode($row['nik']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="hapus.php?nik=<?= urlencode($row['nik']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>