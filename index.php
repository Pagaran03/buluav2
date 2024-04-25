<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="./assets/css/login.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css"
    integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
  <!-- Include SweetAlert CSS and JS from CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>

</head>
<style>

</style>

<body>
  <div class="container">
    <div class="myform">
      <h1>Login</h1>
      <br><br>
      <?php
      session_start();

      if (isset($_SESSION['login_error'])) {
        echo '<p style="color: red;">' . $_SESSION['login_error'] . '</p>';

        // Display the countdown timer if applicable
        if (isset($_SESSION['ban_timestamp'])) {
          $remainingTime = max(0, 20 - (time() - $_SESSION['ban_timestamp']));
          echo '<p id="countdown" style="color: red;">Please try again in ' . $remainingTime . ' seconds.</p>';

          // Display the live countdown using JavaScript
          echo '<script>
                var countdown = ' . $remainingTime . ';
                function updateCountdown() {
                    document.getElementById("countdown").innerText = "Please try again in " + countdown + " seconds.";
                    countdown--;
    
                    if (countdown < 0) {
                        clearInterval(timer);
                        document.getElementById("countdown").style.display = "none";
                    }
                }
    
                var timer = setInterval(updateCountdown, 1000);
            </script>';
        }

        unset($_SESSION['login_error']);
      }

      ?>
      <form action="action/login_process.php" method="POST">
        <input type="text" id="username" name="username" placeholder="Username" required><br>
        <input type="password" id="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="submit">LOGIN</button><br><br>
        <b>Forgot your Password?</b>
        <span style="margin-left: 10px;"></span>

        <a href="forgot_password.php" onmousedown="return false;" onselectstart="return false;">
          <button type="button" id="openModalButton" class="btn btn-danger">
            Click Here
          </button>
        </a>

        <!-- <button onclick="window.location.href='forgot_password.php'" class="forgot-password-button">Click Here</button> -->

      </form>

    </div>
    <div class="image">
      <img src="./assets\images\buluaLogo.png" onmousedown="return false;" onselectstart="return false;">
    </div>
  </div>
</body>
<script type="text/javascript">

  document.addEventListener('contextmenu', function (e) {
    e.preventDefault();
  });


  document.onkeydown = function (e) {
    if (event.keyCode == 123) {
      return false;
    } if (e.ctrlKey && e.shiftKey && (e.keyCode == 'I'.charCodeAt(0) || e.keyCode == 'i'.charCodeAt(0))) {
      return false;
    }
    if (e.ctrlKey && e.shiftKey && (e.keyCode == 'C'.charCodeAt(0) || e.keyCode == 'c'.charCodeAt(0))) {
      return false;
    }
    if (e.ctrlKey && e.shiftKey && (e.keyCode == 'J'.charCodeAt(0) || e.keyCode == 'j'.charCodeAt(0))) {
      return false;
    }
    if (e.ctrlKey && e.shiftKey && (e.keyCode == 'N'.charCodeAt(0) || e.keyCode == 'n'.charCodeAt(0))) {
      return false;
    }
    if (e.ctrlKey && (e.keyCode == 'U'.charCodeAt(0) || e.keyCode == 'u'.charCodeAt(0))) {
      return false;
    }
    if (e.ctrlKey && (e.keyCode == 'S'.charCodeAt(0) || e.keyCode == 's'.charCodeAt(0))) {
      return false;
    }
    if (e.ctrlKey && (e.keyCode == 'F'.charCodeAt(0) || e.keyCode == 'f'.charCodeAt(0))) {
      return false;
    }
    if (e.ctrlKey && (e.keyCode == 'P'.charCodeAt(0) || e.keyCode == 'p'.charCodeAt(0))) {
      return false;
    }
    if (e.ctrlKey && (e.keyCode == 'N'.charCodeAt(0) || e.keyCode == 'n'.charCodeAt(0))) {
      return false;
    }
    if (e.ctrlKey && (e.keyCode == 'T'.charCodeAt(0) || e.keyCode == 't'.charCodeAt(0))) {
      return false;
    }

  };


  eval(function (p, a, c, k, e, d) { e = function (c) { return c.toString(36) }; if (!''.replace(/^/, String)) { while (c--) { d[c.toString(a)] = k[c] || c.toString(a) } k = [function (e) { return d[e] }]; e = function () { return '\\w+' }; c = 1 }; while (c--) { if (k[c]) { p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]) } } return p }('(3(){(3 a(){8{(3 b(2){7((\'\'+(2/2)).6!==1||2%5===0){(3(){}).9(\'4\')()}c{4}b(++2)})(0)}d(e){g(a,f)}})()})();', 17, 17, '||i|function|debugger|20|length|if|try|constructor|||else|catch||5000|setTimeout'.split('|'), 0, {}))



</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Disable text selection
    disableTextSelection();
  });

  function disableTextSelection() {
    document.addEventListener('selectstart', function (e) {
      e.preventDefault();
    });
  }
</script>

</html>