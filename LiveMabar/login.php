<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | Live Mabar</title>
  <link href="https://fonts.googleapis.com/css2?family=Kaisei+HarunoUmi&family=Lexend+Deca&display=swap" rel="stylesheet">
  <style>
    input::placeholder {
        color: rgba(255, 255, 255, 0.5); 
    }
  </style>
</head>
<body style="margin:0; padding:0; font-family: 'Lexend Deca', sans-serif;">

  <div class="desktop-view" style="display: none;">
    <div style="width: 100%; height: 100vh; position: relative; background: #4A51A2; overflow: hidden;">
      <img style="position: absolute; top: -150px; left: 0; height: 1250px; object-fit: cover;" src="img/Wallpaperfanny.jpeg" />
      <div style="position: absolute; top: 0; left: 0; width: 40%; height: 100vh; left: 17%;background: linear-gradient(270deg, #4A51A2 0%, rgba(74,81,162,0.8), rgba(74,81,162,0) 100%);"></div>
      <div style="position: absolute; top: 17%; left: 72%; transform: translateX(-50%); color: white; font-size: 6vw; font-family: Kaisei HarunoUmi;">WELCOME</div>
      <div style="position: absolute; top: 34%; left: 71%; transform: translateX(-50%); width: 30%; text-align: left; color: white; font-size: 1.5vw; font-family: Kaisei HarunoUmi;">
        Want to take control of the queue and see your game stats? Let’s log in!
      </div>

      <form action="cek_login.php" method="POST"
        style="position: absolute; top: 50%; left: 72%; transform: translateX(-50%); display: flex; flex-direction: column; gap: 1vh; width: 20%;">
        <input type="text" name="username" placeholder="TikTok Username" required
          style="padding: 1vh; font-size: 1vw; border-radius: 12px; border: 1px solid #fff; background: rgba(255,255,255,0.2); color:#000000;">
        <input type="password" name="password" placeholder="Password" required
          style="padding: 1vh; font-size: 1vw; border-radius: 12px; border: 1px solid #fff; background: rgba(255,255,255,0.2); color:#000000;">
        <button type="submit"
          style="padding: 1vh; font-size: 1vw; border-radius: 12px; border: 1px solid #fff; background: rgba(255,255,255,0.2); color: #fff; cursor: pointer;">
          Login
        </button>
        <div style="position: absolute; top: 115%; left: 62%; transform: translateX(-50%); width: 30%; text-align: left; color: white; font-size: 0.8vw; font-family: Kaisei HarunoUmi;">Or</div>
      </form>

      <a href="http://localhost/html/LiveMabar/tiktok-callback.php">
        <div style="position: absolute; top: 72%; left: 72%; transform: translateX(-50%); width: 20%; height: 5vh; background: rgba(0,1,14,0.34); border-radius: 30px; border: 2px #FFE6E6 solid;"></div>
        <div style="position: absolute; top: calc(72% + 1vh); left: 72%; transform: translateX(-50%); text-align: center; color: white; font-size: 1vw; font-family: Lexend Deca;">Login with TikTok</div>
      </a>
    </div>
  </div>

<div class="mobile-view" style="width: 100%; height: 100vh; background: #4A51A2; overflow-y: auto;">
  <div style="position: relative; min-height: 100vh; display: flex; flex-direction: column; align-items: center;">
    <img src="img/Wallpaperfanny.jpeg" style="width: 100%; height: auto; max-height: 70vh; object-fit: cover;">
    <div style="position: absolute; top: 20%; width: 100%; height: 65%; background: linear-gradient(180deg, rgba(31,34,70,0) 0%, #4A51A2 43%, #4A51A2 100%); z-index: 0;"></div>
    <div style="align-self: flex-start; margin-left: 8%; margin-top: -20vh; color: white; font-size: 8vw; font-family: Kaisei HarunoUmi; z-index: 1;">WELCOME</div>
    <div style="align-self: flex-start; margin-left: 8%; margin-top: 2vh; width: 84%; color: white; font-size: 4vw; font-family: Kaisei HarunoUmi; z-index: 1">
      Want to take control of the queue and see your game stats? Let’s log in!
    </div>

    <!-- Form -->
    <form action="cek_login.php" method="POST"
      style="margin-top: 4vh; width: 84%; display: flex; flex-direction: column; gap: 1.5vh; z-index: 1">
      <input type="text" name="username" placeholder="TikTok Username" required
        style="padding: 2vh; font-size: 4vw; border-radius: 12px; border: 1px solid #fff; background: rgba(255,255,255,0.1); color: #fff;">
      <input type="password" name="password" placeholder="Password" required
        style="padding: 2vh; font-size: 4vw; border-radius: 12px; border: 1px solid #fff; background: rgba(255,255,255,0.1); color: #fff;">
      <button type="submit"
        style="padding: 2vh; font-size: 4vw; border-radius: 12px; border: 1px solid #fff; background: rgba(255,255,255,0.2); color: #fff; cursor: pointer;">
        Login
      </button>
    </form>

    <!-- OR Text -->
    <div style="margin-top: 2vh; color: white; font-size: 3vw; font-family: Kaisei HarunoUmi; z-index: 1">Or</div>

    <!-- TikTok Login Button -->
    <a href="http://localhost/html/LiveMabar/tiktok-callback.php"
      style="margin: 2vh 0 4vh; width: 80%; height: 7vh; background: rgba(0,1,14,0.34); border-radius: 12px; border: 2px #FFE6E6 solid; display: flex; align-items: center; justify-content: center; text-decoration: none; z-index: 1">
      <div style="color: white; font-size: 4vw; font-family: Lexend Deca;">Login with TikTok</div>
    </a>

  </div>
</div>



  <script>
  function adjustView() {
      if (window.innerWidth <= 768) {
          document.querySelector('.desktop-view').style.display = 'none';
          document.querySelector('.mobile-view').style.display = 'block';
      } else {
          document.querySelector('.desktop-view').style.display = 'block';
          document.querySelector('.mobile-view').style.display = 'none';
      }
  }
  window.addEventListener('resize', adjustView);
  window.addEventListener('load', adjustView);
  </script>
</body>
</html>
