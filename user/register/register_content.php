<?php
// header("Content-Security-Policy: default-src 'self';"); // Set Content Security Policy header to restrict resource loading
// header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type
header('X-Frame-Options: DENY'); // Prevent clickjacking attacks
header('Referrer-Policy: strict-origin-when-cross-origin'); // Control referrer information sent to other sites
header('X-XSS-Protection: 1; mode=block'); // Enable XSS (Cross-Site Scripting) protection

?>

<!-- Apply the background image styles directly to the img tag -->
<img src="../../assets/images/register.png" alt="Background Image" style="background: url('../../assets/images/register.png') no-repeat center center fixed; 
           background-size: cover; 
           width: 100vw; /* Set width to fill the viewport width */
           height: 90vh; /* Set height to fill the viewport height */">
<footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
        Anything you want
    </div>
    <strong>Brgy Health Center 2023</strong>
</footer>