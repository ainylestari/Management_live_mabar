<?php
include 'config.php';
session_start();

if (!isset($_SESSION['ID_Penonton'])) {
    header("Location: login.php");
    exit;
}

$id_penonton = $_SESSION['ID_Penonton'];

$query = "
    SELECT a.nickname, p.ID_Penonton, p.total_MVP, f.foto
    FROM penonton p
    LEFT JOIN akun_game a ON p.ID_Penonton = a.ID_Penonton
    LEFT JOIN foto_profile f ON a.foto_profile = f.id
    WHERE p.ID_Penonton = '$id_penonton'
";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

$nickname = $data['nickname'] ?? 'Unknown';
$foto = !empty($data['foto']) ? "img/{$data['foto']}" : "img/default.png";
$total_mvp = $data['total_MVP'] ?? 0;

$stat_query = "
    SELECT 
        COUNT(*) AS match_count,
        SUM(CASE WHEN is_win = 1 THEN 1 ELSE 0 END) AS win_count,
        ROUND(SUM(CASE WHEN is_win = 1 THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 1) AS winrate
    FROM pertandingan
    WHERE ID_Penonton = '$id_penonton'
";
$stat_result = mysqli_query($conn, $stat_query);
$stat = mysqli_fetch_assoc($stat_result);

$match_count = $stat['match_count'] ?? 0;
$winrate = $stat['winrate'] ?? 0;

$role_query = "
    SELECT r.icon 
    FROM user_role ur
    JOIN role r ON ur.id_role = r.id
    WHERE ur.ID_Penonton = '$id_penonton'
";
$role_result = mysqli_query($conn, $role_query);
$badges = [];
while ($row = mysqli_fetch_assoc($role_result)) {
    $badges[] = $row['icon'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
    }
  </style>

</head>
<body>
  <div style="width: 100%; height: 100vh; position: relative; background: linear-gradient(180deg, #030208 0%, #4A51A2 100%); overflow: hidden">
    <div style="width: 100%; height: 20.6%; top: 5.5%; left: 0; position: absolute; background: #5457A8"></div>
    <img style="width: 38.5%; aspect-ratio: 1 / 1; left: 56.4%; top: 17.4%; position: absolute; object-fit: cover; border: 2px solid #F3CC8A;"
        src="<?php echo htmlspecialchars($foto); ?>" />
    <div style="left: 7%; top: 28.1%; position: absolute; color: white; font-size: 6vw; font-family: Lexend Deca; font-weight: 600; word-wrap: break-word">
        <?php echo htmlspecialchars($nickname); ?>
    </div>
    <div style="left: 7%; top: 33%; position: absolute; color: white; font-size: 3.5vw; font-family: Lexend Deca; font-weight: 300; word-wrap: break-word">
        ID: <?php echo htmlspecialchars($id_penonton); ?>
    </div>

    <?php
    $badge_positions = [
        ['left' => '82.7%', 'top' => '36.7%'],
        ['left' => '73.9%', 'top' => '36.4%'],
        ['left' => '65.9%', 'top' => '36.4%']
    ];
    foreach ($badges as $index => $badge) {
        if ($index >= 3) break;
        $pos = $badge_positions[$index];
        echo "<img style='width: 9.7%; height: auto; max-height: 4.5%; left: {$pos['left']}; top: {$pos['top']}; position: absolute; border-radius: 6px; object-fit: cover; border: 1px solid #F3CC8A;'
                  src='img/{$badge}' />";
    }
    ?>

    <div style="left: 7%; top: 43.5%; position: absolute; color: white; font-size: 4.1vw; font-family: Kaisei HarunoUmi; font-weight: 400; word-wrap: break-word">statistic</div>
    <div style="width: 68%; height: 0; left: 25%; top: 45.2%; position: absolute; outline: 1px white solid; outline-offset: -0.5px"></div>

    <?php
    $box_width = '25.6%';
    $box_height = '11.8%';
    $box_top = '49.7%';
    ?>

    <div style="width: <?php echo $box_width; ?>; height: <?php echo $box_height; ?>; left: 7%; top: <?php echo $box_top; ?>; position: absolute; background: #4A51A2; border-radius: 10px; border: 0.5px white solid"></div>
    <div style="width: <?php echo $box_width; ?>; height: <?php echo $box_height; ?>; left: 37.2%; top: <?php echo $box_top; ?>; position: absolute; background: #4A51A2; border-radius: 10px; border: 0.5px white solid"></div>
    <div style="width: <?php echo $box_width; ?>; height: <?php echo $box_height; ?>; left: 67.4%; top: <?php echo $box_top; ?>; position: absolute; background: #4A51A2; border-radius: 10px; border: 0.5px white solid"></div>

    <div style="left: 16.7%; top: 53.5%; position: absolute; color: white; font-size: 4.1vw; font-family: Inter; font-weight: 700; word-wrap: break-word">
        <?php echo $match_count; ?>
    </div>
    <div style="left: 15%; top: 56%; position: absolute; color: white; font-size: 3.1vw; font-family: Inter; font-weight: 500; word-wrap: break-word">match</div>

    <div style="left: 46.2%; top: 53.5%; position: absolute; color: white; font-size: 4.1vw; font-family: Inter; font-weight: 700; word-wrap: break-word">
        <?php echo $winrate; ?>%
    </div>
    <div style="left: 44.7%; top: 56%; position: absolute; color: white; font-size: 3.1vw; font-family: Inter; font-weight: 500; word-wrap: break-word">win rate</div>

    <div style="left: 79.2%; top: 53.5%; position: absolute; color: white; font-size: 4.1vw; font-family: Inter; font-weight: 700; word-wrap: break-word">
        <?php echo $total_mvp; ?>
    </div>
    <div style="left: 77.5%; top: 56%; position: absolute; color: white; font-size: 3.1vw; font-family: Inter; font-weight: 500; word-wrap: break-word">mvp</div>

    <div style="width: 4.1%; height: auto; max-height: 4.1%; left: 40.2%; top: 28.5%; position: absolute;">
      <a class="pen-to-square" href="edit-profile.php">
        <i class="bi bi-pencil-square" style="color: white;"></i>
      </a>
    </div>

    <div data-property-1="1" style="width: 10.2%; aspect-ratio: 1 / 1; left: 7%; top: 8.2%; position: absolute; background: rgba(74, 81, 162, 0.30); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); overflow: hidden; border-radius: 50%; outline: 0.5px #F3CC8A solid; outline-offset: -0.5px">
      <img style="width: 100%; height: 100%; border: 1px #F3CC8A solid; border-radius: 50%;" src="<?php echo htmlspecialchars($foto); ?>" />
    </div>
  </div>
</body>
</html>
