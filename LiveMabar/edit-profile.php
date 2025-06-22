<?php
include 'config.php';
$id_penonton = 123; // Ganti dengan session user login nantinya

// Proses form simpan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nickname = mysqli_real_escape_string($conn, $_POST['nickname']);
  $foto_id = intval($_POST['foto_profile']);

  mysqli_query($conn, "UPDATE akun_game SET nickname = '$nickname', foto_profile = '$foto_id' WHERE ID_Penonton = '$id_penonton'");
  header("Location: profile.php");
  exit;
}

// Ambil data user
$query = "SELECT a.nickname, p.ID_Penonton, a.foto_profile, f.foto 
          FROM akun_game a
          JOIN penonton p ON a.ID_Penonton = p.ID_Penonton
          LEFT JOIN foto_profile f ON a.foto_profile = f.id
          WHERE a.ID_Penonton = '$id_penonton'";
$data = mysqli_fetch_assoc(mysqli_query($conn, $query));

// Ambil semua gambar untuk pilihan foto
$fotos = mysqli_query($conn, "SELECT * FROM foto_profile");

// Ambil semua role user
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
    }
    .container {
      width: 390px;
      height: 844px;
      margin: auto;
      padding: 20px;
      position: relative;
      background: linear-gradient(180deg, #030208 0%, #4A51A2 100%);
    }
    .profile-img-preview {
      width: 150px;
      height: 150px;
      object-fit: cover;
      display: block;
      margin: 32px auto 16px;
    }
    .foto-options {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: flex-start;
    }
    .foto-options img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border: 2px solid transparent;
      cursor: pointer;
    }
    .foto-options img.selected {
      border-color: #F3CC8A;
    }
    .info-label {
      font-size: 14px;
      font-weight: 600;
      margin-top: 16px;
    }
    .info-value {
      font-size: 13px;
      margin-top: 4px;
      padding: 6px 10px;
      border-radius: 4px;
      border: none;
      background: transparent;
      color: white;
    }
    .role-display {
      display: flex;
      gap: 8px;
      margin-top: 8px;
    }
    .role-display img {
      width: 35px;
      height: 35px;
    }
    .save-btn {
      margin: 40px auto 0;
      display: block;
      width: 140px;
      text-align: center;
      background: rgba(0, 1, 14, 0.34);
      border: 1px solid #FFE6E6;
      border-radius: 30px;
      padding: 8px 0;
      font-size: 14px;
      color: white;
      cursor: pointer;
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

    <!-- Nickname -->
    <div class="info-label">Nickname</div>
    <input type="text" name="nickname" value="<?php echo htmlspecialchars($data['nickname']); ?>" class="info-value" required>

    <!-- ID -->
    <div class="info-label">ID</div>
    <div class="info-value"><?php echo $data['ID_Penonton']; ?></div>

    <!-- Role -->
    <div class="info-label">Role</div>
    <div class="role-display">
      <?php while ($role = mysqli_fetch_assoc($roles)) { ?>
        <img src="img/<?php echo $role['icon']; ?>">
      <?php } ?>
    </div>

    <!-- Tombol Simpan -->
    <button type="submit" class="save-btn">Save</button>
  </form>

  <script>
    // JS untuk memilih gambar profil
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
  </script>
</body>
</html>
