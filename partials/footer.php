</main>
<footer>
  <p>&copy; 2025 Grouping System</p>
</footer>
</div>

<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/script.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggleCheckbox = document.getElementById('darkModeToggle');
    const body = document.body;

    if (toggleCheckbox) {
      toggleCheckbox.addEventListener('change', function () {

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