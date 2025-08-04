<?php
session_start();

if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

if (isset($_POST['addTask']) && !empty(trim($_POST['task']))) {
    $_SESSION['tasks'][] = [
        'text' => htmlspecialchars($_POST['task']),
        'done' => false
    ];
    header("Location: index.php");
    exit;
}

if (isset($_POST['delete'])) {
    $index = $_POST['delete'];
    unset($_SESSION['tasks'][$index]);
    $_SESSION['tasks'] = array_values($_SESSION['tasks']);
    header("Location: index.php");
    exit;
}

if (isset($_POST['toggle'])) {
    $index = $_POST['toggle'];
    $_SESSION['tasks'][$index]['done'] = !$_SESSION['tasks'][$index]['done'];
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Tugas Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background: linear-gradient(to right, #f7f8fc, #e0ecf7);
      font-family: 'Segoe UI', sans-serif;
      overflow-x: hidden;
    }

    .hero {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 2rem;
      margin-bottom: 2rem;
      background-color: #fff;
      border-radius: 1rem;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
      animation: slideIn 1s ease;
    }

    @keyframes slideIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .hero-text h1 {
      font-size: 2.5rem;
      font-weight: bold;
    }

    .task-card {
      transition: transform 0.3s;
    }

    .task-card:hover {
      transform: translateY(-3px);
    }

    .checked {
      text-decoration: line-through;
      color: #888;
    }

    .hero img {
      max-width: 200px;
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    .form-control::placeholder {
      font-style: italic;
    }

    footer {
      text-align: center;
      color: #777;
      margin-top: 3rem;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

<div class="container py-5">

  <div class="hero mb-4">
    <div class="hero-text">
      <h1><i class="bi bi-journal-check text-primary"></i> Aplikasi Tugas Mahasiswa</h1>
      <p class="lead">Catat, kelola, dan tandai tugas kuliahmu dengan mudah.</p>
    </div>
    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png" alt="Mahasiswa Belajar">
  </div>

  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <form method="POST" class="d-flex gap-2">
        <input type="text" name="task" class="form-control" placeholder="Contoh: Buat makalah bab 3...">
        <button type="submit" name="addTask" class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah</button>
      </form>
    </div>
  </div>

  <?php if (!empty($_SESSION['tasks'])): ?>
    <?php foreach ($_SESSION['tasks'] as $i => $task): ?>
      <div class="card mb-2 task-card shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
          <form method="POST" class="d-flex align-items-center gap-3 w-100">
            <input type="hidden" name="toggle" value="<?= $i ?>">
            <input type="checkbox" onChange="this.form.submit()" <?= $task['done'] ? 'checked' : '' ?>>
            <span class="flex-grow-1 <?= $task['done'] ? 'checked' : '' ?>">
              <?= $task['text'] ?>
            </span>
          </form>
          <form method="POST">
            <input type="hidden" name="delete" value="<?= $i ?>">
            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-info text-center">Belum ada tugas. Tambahkan yuk!</div>
  <?php endif; ?>

  <footer class="mt-5">
    &copy; <?= date('Y') ?> - Dibuat oleh Deni Darmawan ✨
  </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>