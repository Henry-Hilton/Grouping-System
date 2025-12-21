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

  <script>
    (function () {
      const theme = localStorage.getItem('theme');
      if (theme === 'dark') {
        document.documentElement.classList.add('dark-mode-loading');
      }
    })();
  </script>

  <style>
    html.dark-mode-loading body {
      background-color: #121212;
      color: #e0e0e0;
    }
  </style>
</head>

<body>
  <div class="app-container">
    <main class="main-content">

      <script>
        document.addEventListener("DOMContentLoaded", function () {
          const toggles = document.querySelectorAll('.theme-checkbox');
          const body = document.body;

          const savedTheme = localStorage.getItem('theme');

          document.documentElement.classList.remove('dark-mode-loading');

          if (savedTheme === 'dark') {
            body.classList.add('dark-mode');
            toggles.forEach(t => t.checked = true);
          } else {
            body.classList.remove('dark-mode');
            toggles.forEach(t => t.checked = false);
          }

          toggles.forEach(t => {
            t.addEventListener('change', function () {
              if (this.checked) {
                body.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark');
                toggles.forEach(other => { if (other !== this) other.checked = true; });
              } else {
                body.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
                toggles.forEach(other => { if (other !== this) other.checked = false; });
              }
            });
          });
        });
      </script>