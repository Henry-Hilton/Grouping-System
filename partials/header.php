<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Grouping System</title>

  <?php
  $base_url = isset($path) ? $path : '../';

  $current_theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'light';
  ?>

  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="<?php echo ($current_theme === 'dark') ? 'dark-mode' : ''; ?>">

  <div class="app-container">
    <main class="main-content">

      <script>
        document.addEventListener("DOMContentLoaded", function () {
          const toggles = document.querySelectorAll('.theme-checkbox');
          const body = document.body;

          const isDarkMode = body.classList.contains('dark-mode');
          toggles.forEach(t => t.checked = isDarkMode);

          toggles.forEach(t => {
            t.addEventListener('change', function () {
              const newTheme = this.checked ? 'dark' : 'light';

              if (this.checked) {
                body.classList.add('dark-mode');
              } else {
                body.classList.remove('dark-mode');
              }

              toggles.forEach(other => { if (other !== this) other.checked = this.checked; });

              $.ajax({
                url: '<?php echo $base_url; ?>partials/save_theme.php',
                method: 'POST',
                data: { theme: newTheme }
              });
            });
          });
        });
      </script>