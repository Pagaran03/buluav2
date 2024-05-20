<?php
session_start();
include("action/redirect.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="./assets/css/login.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script> -->

</head>

<body>
  <div class="wrapper">
    <div class="container main">
      <div class="row">
        <div class="col-md-6 side-image">
          

        </div>
        <div class="col-md-6 right">
          <div class="input-box">
            <header>Login</header>
            <?php
            if (isset($_SESSION['login_error'])) {
              echo '<p style="color: red;">' . $_SESSION['login_error'] . '</p>';

              if (isset($_SESSION['ban_timestamp'])) {
                $remainingTime = max(0, 20 - (time() - $_SESSION['ban_timestamp']));
                echo '<p id="countdown" style="color: red;">Please try again in ' . $remainingTime . ' seconds.</p>';

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
              <div class="input-field">
                <input type="text" id="username" name="username" class="input" placeholder="Username" required>
              </div>
              <div class="input-field">
                <div class="input-group">
                  <input type="password" id="password" name="password" class="input" placeholder="Password" required>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="fas fa-eye-slash toggle-password" id="togglePassword"></i>
                    </span>
                  </div>
                </div>
              </div>
              <script>
                document.getElementById('togglePassword').addEventListener('click', function() {
                  const passwordInput = document.getElementById('password');
                  const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                  passwordInput.setAttribute('type', type);
                  this.classList.toggle('fa-eye-slash');
                  this.classList.toggle('fa-eye');
                });
              </script>
              <div class="input-field">
                <button type="submit" name="submit" class="submit">LOGIN</button>
              </div>
              <div class="signin">
                <span>Forgot your Password? <a href="forgot_password.php">Click Here</a></span>
              </div>
            </form>
          </div>
        </div>
      </div>
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
  document.addEventListener('DOMContentLoaded', function() {
    // Disable text selection
    disableTextSelection();
  });

  function disableTextSelection() {
    document.addEventListener('selectstart', function(e) {
      e.preventDefault();
    });
  }
</script>

</html>