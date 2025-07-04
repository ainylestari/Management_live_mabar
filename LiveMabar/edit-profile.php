<?php
include 'config.php';
session_start();

if (!isset($_SESSION['ID_Penonton'])) {
    header("Location: login.php");
    exit;
}

$id_penonton = $_SESSION['ID_Penonton'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = mysqli_real_escape_string($conn, $_POST['nickname']);
    $foto_id = intval($_POST['foto_profile']);

    // Validasi foto_id
    $valid_foto_query = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM foto_profile WHERE id = '$foto_id'");
    $valid_foto = mysqli_fetch_assoc($valid_foto_query);

    if ($valid_foto['cnt'] > 0) {
        // Cek apakah akun_game sudah ada
        $check_query = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM akun_game WHERE ID_Penonton = '$id_penonton'");
        $check = mysqli_fetch_assoc($check_query);

        if ($check['cnt'] > 0) {
            // Sudah ada, lakukan update
            mysqli_query($conn, "UPDATE akun_game SET nickname = '$nickname', foto_profile = '$foto_id' WHERE ID_Penonton = '$id_penonton'");
        } else {
            // Belum ada, lakukan insert
            mysqli_query($conn, "INSERT INTO akun_game (ID_Penonton, nickname, foto_profile) VALUES ('$id_penonton', '$nickname', '$foto_id')");
        }
    }
    header("Location: akun.php");
    exit;
}

$query = "SELECT a.nickname, p.ID_Penonton, a.foto_profile, f.foto 
          FROM penonton p
          LEFT JOIN akun_game a ON p.ID_Penonton = a.ID_Penonton
          LEFT JOIN foto_profile f ON a.foto_profile = f.id
          WHERE p.ID_Penonton = '$id_penonton'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

$nickname = !empty($data['nickname']) ? $data['nickname'] : 'Unknown';
$foto = !empty($data['foto']) ? "img/{$data['foto']}" : "img/default.png";
$foto_profile_id = !empty($data['foto_profile']) ? $data['foto_profile'] : 0;

$fotos = mysqli_query($conn, "SELECT * FROM foto_profile");
$roles = mysqli_query($conn, "SELECT r.icon FROM user_role ur JOIN role r ON ur.id_role = r.id WHERE ur.ID_Penonton = '$id_penonton'");
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      color: white;
      background: linear-gradient(180deg, #030208 0%, #4A51A2 100%);
    }
    input::placeholder {
      color: rgba(255, 255, 255, 0.5);
    }
    .container {
      max-width: 420px;
      height: 100vh;
      padding: 25% 7%;
      margin: auto;
      overflow-y: auto;
      box-sizing: border-box;
    }
    .profile-img-preview {
      width: 38%;
      aspect-ratio: 1 / 1;
      object-fit: cover;
      display: block;
      margin: 16px auto;
      border: 2px solid #F3CC8A;
    }
    .foto-options {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      justify-content: flex-start;
      margin-top: 12px;
    }
    .foto-options img {
      width: 20%;
      aspect-ratio: 1 / 1;
      object-fit: cover;
      border: 2px solid transparent;
      cursor: pointer;
    }
    .foto-options img.selected {
      border-color: #F3CC8A;
    }
    .label-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 10px;
      margin-top: 16px;
    }
    .info-label {
      font-size: 4vw;
      font-weight: 600;
      flex: 1;
    }
    .info-value, .info-input {
      font-size: 3.5vw;
      padding: 6px 10px;
      border-radius: 6px;
      border: none;
      background: rgba(255, 255, 255, 0.1);
      color: white;
      flex: 2;
      box-sizing: border-box;
      text-align: left;
    }
    .role-display {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      margin-top: 8px;
    }
    .role-display img {
      width: 16%;
      aspect-ratio: 1 / 1;
      object-fit: cover;
      border-radius: 6px;
      border: 1px solid #F3CC8A;
    }
    .save-btn {
      display: block;
      width: 60%;
      margin: 20% auto 0;
      padding: 10px 0;
      background: rgba(0, 1, 14, 0.34);
      border: 1px solid #FFE6E6;
      border-radius: 30px;
      font-size: 4vw;
      color: white;
      cursor: pointer;
      text-align: center;
    }
    .save-btn:hover {
      background: rgba(255, 255, 255, 0.1);
    }
  </style>
</head>
<body>

<form method="POST" class="container">
  <!-- Foto profil preview -->
  <img id="preview" src="img/<?php echo $data['foto']; ?>" class="profile-img-preview">

  <!-- Pilih foto -->
  <div class="info-label">Foto Profil</div>
  <div class="foto-options">
    <?php while ($foto = mysqli_fetch_assoc($fotos)) { ?>
      <img src="img/<?php echo $foto['foto']; ?>"
           data-id="<?php echo $foto['id']; ?>"
           class="foto-option<?php echo $foto['id'] == $data['foto_profile'] ? ' selected' : ''; ?>">
    <?php } ?>
  </div>
  <input type="hidden" name="foto_profile" id="fotoInput" value="<?php echo $data['foto_profile']; ?>">

  <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-top: 10%;">
    <div style="flex-basis: 40%;">
        <div style="font-size: 4vw; font-weight: 600;">Nickname</div>
        <div id="nicknameDiv" contenteditable="true" style="font-size: 3.5vw; padding: 2px;">
            <?php echo htmlspecialchars($data['nickname']); ?>
        </div>
    </div>
    <div style="flex-basis: 40%;">
        <div style="font-size: 4vw; font-weight: 600;">ID</div>
        <div style="font-size: 3.5vw;"><?php echo $data['ID_Penonton']; ?></div>
    </div>
  </div>
  <input type="hidden" name="nickname" id="nicknameInput">



  <div class="info-label" style="margin-top: 10%;">Role</div>
  <div class="role-display">
    <?php while ($role = mysqli_fetch_assoc($roles)) { ?>
      <img src="img/<?php echo $role['icon']; ?>">
    <?php } ?>
  </div>

  <button type="submit" class="save-btn">Save</button>
</form>

    <div data-property-1="1" style="width: 10.2%; aspect-ratio: 1 / 1; left: 7%; top: 8.2%; position: absolute; background: rgba(74, 81, 162, 0.30); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); overflow: hidden; border-radius: 50%; outline: 0.5px #F3CC8A solid; outline-offset: -0.5px">
      <img style="width: 100%; height: 100%; border: 1px #F3CC8A solid; border-radius: 50%;" src="img/<?php echo htmlspecialchars($data['foto']); ?>" />
    </div>

<script>
  const options = document.querySelectorAll('.foto-option');
  const input = document.getElementById('fotoInput');
  const preview = document.getElementById('preview');

  options.forEach(option => {
    option.addEventListener('click', () => {
      options.forEach(o => o.classList.remove('selected'));
      option.classList.add('selected');
      input.value = option.getAttribute('data-id');
      preview.src = option.src;
    });
  });

  document.querySelector("form").addEventListener("submit", function() {
    document.getElementById("nicknameInput").value = document.getElementById("nicknameDiv").innerText.trim();
  });
</script>

</body>
</html>
