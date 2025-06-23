<?php
include 'config.php';

// Ambil The GOAT
$goat_query = mysqli_query($conn, "
  SELECT p.ID_Penonton, p.total_mvp, a.nickname, f.foto
  FROM penonton p
  JOIN akun_game a ON a.ID_Penonton = p.ID_Penonton
  LEFT JOIN foto_profile f ON a.foto_profile = f.id
  ORDER BY p.total_mvp DESC LIMIT 1
");
$goat = mysqli_fetch_assoc($goat_query);

// Ambil Rich Guy
$rich_query = mysqli_query($conn, "
  SELECT v.ID_Penonton, COUNT(*) as total_vip, a.nickname, f.foto
  FROM vip v
  JOIN akun_game a ON a.ID_Penonton = v.ID_Penonton
  LEFT JOIN foto_profile f ON a.foto_profile = f.id
  GROUP BY v.ID_Penonton
  ORDER BY total_vip DESC LIMIT 1
");
$rich = mysqli_fetch_assoc($rich_query);

// Ambil Riwayat pertandingan
$history_query = mysqli_query($conn, "
  SELECT sesi, tanggal
  FROM pertandingan
  ORDER BY tanggal DESC, sesi DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Top Viewers</title>
</head>
<body>
  <div style="width: 390px; height: 971px; position: relative; background: linear-gradient(180deg, #030208 0%, #4A51A2 100%); overflow: hidden">
    <div style="left: 80px; top: 149px; position: absolute; color: white; font-size: 32px; font-family: Kaisei HarunoUmi; font-weight: 400;">TOP VIEWERS</div>

    <!-- The GOAT -->
    <div style="left: 64px; top: 251px; position: absolute; color: white; font-size: 16px; font-family: Kaisei HarunoUmi;">The GOAT</div>
    <img style="width: 100px; height: 100px; left: 57px; top: 298px; position: absolute; border-radius: 9999px; border: 3px #DCA646 solid"
         src="img/<?php echo $goat['foto']; ?>" />
    <div style="left: 66px; top: 409px; position: absolute; color: white; font-size: 14px; font-family: Lexend Deca;"><?php echo $goat['nickname']; ?></div>
    <div style="left: 82px; top: 428px; position: absolute; color: rgba(255, 233, 196, 0.75); font-size: 12px; font-family: Lexend Deca;"><?php echo $goat['total_mvp']; ?> mvp</div>

    <!-- Rich Guy -->
    <div style="left: 248px; top: 251px; position: absolute; text-align: center; color: white; font-size: 16px; font-family: Kaisei HarunoUmi;">Rich Guy</div>
    <img style="width: 100px; height: 100px; left: 235px; top: 298px; position: absolute; border-radius: 9999px; border: 3px #DCA145 solid"
         src="img/<?php echo $rich['foto']; ?>" />
    <div style="left: 245px; top: 409px; position: absolute; color: white; font-size: 14px; font-family: Lexend Deca;"><?php echo $rich['nickname']; ?></div>
    <div style="left: 265px; top: 428px; position: absolute; color: rgba(255, 233, 196, 0.75); font-size: 12px; font-family: Lexend Deca;"><?php echo $rich['total_vip']; ?> vip</div>

    <!-- Game History -->
    <div style="left: 36px; top: 487px; position: absolute; color: white; font-size: 14px; font-family: Kaisei HarunoUmi;">game history</div>
    <div style="width: 227.01px; height: 0px; left: 135px; top: 500.62px; position: absolute; outline: 1px white solid;"></div>

    <?php
    $top_offset = 524;
    while ($row = mysqli_fetch_assoc($history_query)) {
        $tanggal = date('d/m/y', strtotime($row['tanggal']));
        $sesi = htmlspecialchars($row['sesi']);
    ?>
      <div style="width: 77px; height: 26px; left: 37px; top: <?php echo $top_offset; ?>px; position: absolute; background: rgba(93, 106, 199, 0.30); border-radius: 20px; border: 0.50px #F3CC8A solid"></div>
      <div style="left: 48px; top: <?php echo $top_offset + 5; ?>px; position: absolute; color: #F3CC8A; font-size: 12px; font-family: Lexend Deca;"><?php echo $tanggal; ?></div>
      <div style="width: 53px; height: 26px; left: 124px; top: <?php echo $top_offset; ?>px; position: absolute; background: rgba(93, 106, 199, 0.30); border-radius: 20px; border: 0.50px #F3CC8A solid"></div>
      <div style="left: 135px; top: <?php echo $top_offset + 5; ?>px; position: absolute; color: #F3CC8A; font-size: 12px; font-family: Lexend Deca;"><?php echo $sesi; ?></div>
    <?php
        $top_offset += 36; // spasi antar baris
    }
    ?>
  </div>
</body>
</html>
