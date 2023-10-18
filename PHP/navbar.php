<?php
    if (!defined('ABSPATH'))
        die;
?>

<!-- <nav> -->
<!-- Application admin -->

<div class="container">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand fs-1" href="/index.php">Cinémathèque</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-5 px-5">
        <li class="nav-item">
          <a class="nav-link fs-5" href="films_populaires.php">Films populaires</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fs-5" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Recherche par Genre
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/index.php">Tous les genres</a></li>
            <?php
		        	$genres = query("SELECT * FROM Genre");
		        	  foreach($genres as $genre){
		        ?>
              <li><a class="dropdown-item" href="/index.php?genre_id=<?=$genre['id']?>"><?=$genre['nom']?></a></li>
            <?php
              }
		        ?>
          </ul>
        </li>
      </ul>
      <form class="d-flex" role="search" action="index.php" method="get">
        <input name = "acteur" class="form-control me-2" type="search" placeholder="Recherche par acteur" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Recherche</button>
      </form>


<?php if(isset($_SESSION['user'])) :?>
  <a class="btn btn-primary my-2 my-sm-1 mx-4" href="logout.php">Log out</a>
<?php else :?>
  <a class="btn btn-primary my-2 my-sm-1 mx-4" href="login.php">Connecter</a>
<?php endif?>
    </div>
  </div>
</nav>
</div>

