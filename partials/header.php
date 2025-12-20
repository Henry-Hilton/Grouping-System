<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Grouping System</title>
  <link rel="stylesheet" href="../assets/css/style.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

  <div class="app-container">

    <div style="display: flex; justify-content: flex-end; padding: 10px 20px; background-color: transparent;">
      <button id="theme-toggle" class="btn-cancel"
        style="padding: 5px 15px; font-size: 1.2rem; background: transparent; color: inherit; border: 1px solid #ccc;">
        🌙
      </button>
    </div>

    <main class="main-content">

      <script>
        $(document).ready(function () {
          $('#theme-toggle').click(function () {
            $('body').toggleClass('dark-mode');
            if ($('body').hasClass('dark-mode')) {
              $(this).text('☀️');
            } else {
              $(this).text('🌙');
            }
          });
        });
      </script>