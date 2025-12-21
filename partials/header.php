<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Grouping System</title>

  <?php
  $base_url = isset($path) ? $path : '../';
  ?>

  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
  <script>
    if (localStorage.getItem('theme') === 'dark') {
      document.body.classList.add('dark-mode');
    }
  </script>

  <div class="app-container">
    <main class="main-content">

      <script>
        document.addEventListener("DOMContentLoaded", function () {
          const toggles = document.querySelectorAll('.theme-checkbox');
          const theme = localStorage.getItem('theme');

          if (theme === 'dark') {
            toggles.forEach(t => t.checked = true);
          }

          toggles.forEach(t => {
            t.addEventListener('change', function () {
              if (this.checked) {
                document.body.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark');
                toggles.forEach(other => other.checked = true);
              } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
                toggles.forEach(other => other.checked = false);
              }
            });
          });
        });
      </script>