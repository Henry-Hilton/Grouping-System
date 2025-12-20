</main>
<footer>
  <p>&copy; 2025 Grouping System</p>
</footer>
</div>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/script.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('darkModeBtn');
    const body = document.body;

    if (localStorage.getItem('theme') === 'dark') {
      body.classList.add('dark-mode');
    }

    if (toggleBtn) {
      toggleBtn.addEventListener('click', function (e) {
        e.preventDefault();

        body.classList.toggle('dark-mode');

        if (body.classList.contains('dark-mode')) {
          localStorage.setItem('theme', 'dark');
        } else {
          localStorage.setItem('theme', 'light');
        }
      });
    }
  });
</script>
</body>

</html>