<?php
include 'config.php';
$id_penonton = 123; // pakai session nanti

$query = "SELECT p.Username, p.ID_Penonton, p.total_MVP, f.foto
          FROM penonton p
          LEFT JOIN akun_game a ON p.ID_Penonton = a.ID_Penonton
          LEFT JOIN foto_profile f ON a.foto_profile = f.id
          WHERE p.ID_Penonton = '$id_penonton'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

$stat_query = "SELECT 
    COUNT(*) AS match_count,
    SUM(CASE WHEN is_win = 1 THEN 1 ELSE 0 END) AS win_count,
    ROUND(SUM(CASE WHEN is_win = 1 THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 1) AS winrate
    FROM pertandingan
    WHERE ID_Penonton = '$id_penonton'";
$stat_result = mysqli_query($conn, $stat_query);
$stat = mysqli_fetch_assoc($stat_result);

$role_query = "SELECT r.icon FROM user_role ur
               JOIN role r ON ur.id_role = r.id
               WHERE ur.ID_Penonton = '$id_penonton'";
$role_result = mysqli_query($conn, $role_query);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
  <div class="halaman-input">
    <div class="div">
      <div class="overlap">
        <div class="overlap-group">
          <div class="rectangle"></div>
          <img class="PP" src="img/<?php echo $data['foto']; ?>" />
        </div>
        <div class="username-container">
          <div id="usernameDisplay" class="text-wrapper"><?php echo htmlspecialchars($data['Username']); ?></div>
          <button class="pen-to-square" id="editBtn">
            <i class="bi bi-pencil-square"></i>
          </button>
        </div>
        <div class="text-wrapper-2">ID: <?php echo $data['ID_Penonton']; ?></div>
      </div>

      <div class="overlap-2">
        <?php while ($role = mysqli_fetch_assoc($role_result)) { ?>
          <div class="group-role" style="background-image: url('img/<?php echo $role['icon']; ?>');"></div>
        <?php } ?>
      </div>

      <div class="text-wrapper-3">statistic</div> 

      <div class="overlap-3">
        <div class="text-wrapper-4"><?php echo $stat['match_count']; ?></div>
        <div class="text-wrapper-5">match</div>
      </div>

      <div class="overlap-4">
        <div class="text-wrapper-6"><?php echo $stat['winrate']; ?>%</div>
        <div class="text-wrapper-7">win rate</div>
      </div>

      <div class="overlap-5">
        <div class="text-wrapper-8"><?php echo $data['mvp_count']; ?></div>
        <div class="text-wrapper-9">mvp</div>
      </div>

      <img class="frame" src="img/frame-2.svg" />
    </div>
  </div>
  <script>
    const editBtn = document.getElementById('editBtn');
    const editForm = document.getElementById('editForm');
    const usernameDisplay = document.getElementById('usernameDisplay');

    editBtn.addEventListener('click', function () {
      editForm.style.display = 'flex';
      usernameDisplay.style.display = 'none';
      editBtn.style.display = 'none';
    });
  </script>
</body>
</html>
