<style>
    .primary-bg-color{
        background-color: #FFC857 ;
    }
    .primary-bg-color2{
        background-color: #5C3C92  ;
    }
    .primary-color{
        color: #FFC857 ;
    }
    .bg-f2{
        background-color: #2B2D42  ;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">App Logo Here</a>
 
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item <?php if ($activePage == 'home') { echo 'active'; } ?>">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <!-- <li class="nav-item <?php if ($activePage == 'categories') { echo 'active'; } ?>"> -->
        <!-- <a class="nav-link" href="categories.php">Categories</a> -->
      <!-- </li> -->
    </ul>
  </div>
  <span class="navbar-text" id="datetime"></span>
</nav>
<script>
function updateTime() {
  var now = new Date();
  var date = now.toLocaleDateString();
  var time = now.toLocaleTimeString();
  document.getElementById('datetime').textContent = date + ' ' + time;
}

setInterval(updateTime, 1000); // update every second

</script>