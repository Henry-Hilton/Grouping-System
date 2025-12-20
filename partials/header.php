<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Grouping System</title>
  <link rel="stylesheet" href="../assets/css/style.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    if (localStorage.getItem('theme') === 'dark') {
      document.body.classList.add('dark-mode');
    }
  </script>
</head>

<body>

  <div class="app-container">

    <div style="display: flex; justify-content: flex-end; padding: 10px 20px; background-color: transparent;">
      <button id="darkModeBtn" class="btn-cancel"
        style="padding: 5px 15px; font-size: 1.2rem; background: transparent; color: inherit; border: 1px solid #ccc;">

        <script>
          if (document.body.classList.contains('dark-mode')) {
            document.write('☀️');
          } else {
            document.write('🌙');
          }
        </script>
        <noscript>🌙</noscript>
      </button>
    </div>

    <main class="main-content"></main>