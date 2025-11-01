<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $pageTitle ?? 'Admin Panel - Ciraku' ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #0f0f0f;
      color: #fff;
      font-family: 'Poppins', sans-serif;
    }
    .sidebar {
      width: 240px;
      height: 100vh;
      background: #1a1a1a;
      position: fixed;
      left: 0;
      top: 0;
      padding: 20px;
    }
    .sidebar a {
      display: block;
      color: #bbb;
      text-decoration: none;
      padding: 10px 15px;
      margin: 5px 0;
      border-radius: 8px;
      transition: 0.3s;
    }
    .sidebar a.active, .sidebar a:hover {
      background-color: #fbbf24;
      color: #000;
    }
    .content {
      margin-left: 260px;
      padding: 30px;
    }
    .card {
      background: #1e1e1e;
      border: none;
      border-radius: 15px;
    }
    .table {
      color: #fff;
    }
    .table thead {
      background: #fbbf24;
      color: #000;
    }
    .btn-action {
      border-radius: 8px;
      padding: 4px 10px;
    }
  </style>
</head>
