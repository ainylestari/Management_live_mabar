<?php
include 'config.php';

// Ambil data antrean berdasarkan urutan, status, dan join ke akun
$query = "
    SELECT 
        a.urutan,
        a.status,
        p.ID_Penonton,
        ag.nickname,
        p.Username,
        f.foto AS foto_profile
    FROM antrian a
    JOIN akun_game ag ON a.ID_Penonton = ag.ID_Penonton
    JOIN penonton p ON a.ID_Penonton = p.ID_Penonton
    LEFT JOIN foto_profile f ON ag.foto_profile = f.id
    ORDER BY a.urutan ASC
";
$result = mysqli_query($conn, $query);

// Ambil semua role
$roles_query = "
    SELECT ur.ID_Penonton, r.icon 
    FROM user_role ur
    JOIN role r ON ur.id_role = r.id
";
$roles_result = mysqli_query($conn, $roles_query);

$roles_map = [];
while ($row = mysqli_fetch_assoc($roles_result)) {
    $roles_map[$row['ID_Penonton']][] = $row['icon'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <title>Next Up</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
  <div style="width: 390px; height: 971px; position: relative; background: linear-gradient(180deg, #030208 0%, #4A51A2 100%); overflow: hidden">
    <div style="left: 122px; top: 149px; position: absolute; color: white; font-size: 32px; font-family: Kaisei HarunoUmi; font-weight: 400;">NEXT UP</div>

    <?php
    $top = 276;
    while ($data = mysqli_fetch_assoc($result)) {
        $urutan = $data['urutan'];
        $status = $data['status'];
        $nickname = htmlspecialchars($data['nickname']);
        $id = $data['ID_Penonton'];
        $id_tiktok = htmlspecialchars($data['id_tiktok']);
        $username = htmlspecialchars($data['username_tiktok']);
        $foto = !empty($data['foto_profile']) ? "img/{$data['foto_profile']}" : "img/default.png";

        // Warna box tergantung status
        $boxStyle = match($status) {
            'ready' => "background: linear-gradient(90deg, #FFCB73 0%, #FFE9C5 100%);",
            'not_ready', 'no_ready' => "background: rgba(0, 1, 14, 0.34);",
            'no_respond' => "background: rgba(0, 1, 14, 0.34);",
            default => "background: rgba(0, 1, 14, 0.34);",
        };

        echo <<<HTML
        <div style="width: 315px; height: 47px; left: 47px; top: {$top}px; position: absolute; {$boxStyle} border-radius: 30px; border: 0.5px #FFE6E6 solid;"></div>
        <img style="width: 40px; height: 40px; left: 54px; top: ".($top + 3)."px; position: absolute; border-radius: 9999px; border: 1px #F3CC8A solid;" src="{$foto}" />
        <div style="width: 36px; height: 21px; left: 27px; top: ".($top - 6)."px; position: absolute; background: #5D6AC7; border-radius: 10px;"></div>
        <div style="left: 41px; top: ".($top - 6)."px; position: absolute; color: white; font-size: 12px; font-family: Kaisei HarunoUmi;">{$urutan}</div>
        <div style="left: 105px; top: ".($top + 10)."px; position: absolute; color: white; font-size: 12px; font-family: Lexend Deca;">{$nickname}</div>
        <div style="left: 105px; top: ".($top + 25)."px; position: absolute; color: rgba(255, 255, 255, 0.78); font-size: 11px; font-family: Lexend Deca;">{$id_tiktok} - {$username}</div>
HTML;

        // Role icon
        if (isset($roles_map[$id])) {
            $left = 280;
            foreach ($roles_map[$id] as $icon) {
                echo "<img style='width: 25px; height: 25px; left: {$left}px; top: ".($top + 11)."px; position: absolute' src='img/{$icon}' />";
                $left -= 20;
            }
        }

        $top += 59; // spacing antar blok
    }
    ?>
  </div>
</body>
</html>
