<?php
// Connexion à la base de données
$servername = "localhost"; // Remplacez par le nom de votre serveur de base de données
$username = "root"; // Remplacez par votre nom d'utilisateur de base de données
$password = ""; // Remplacez par votre mot de passe de base de données
$database = "Biblio"; // Remplacez par le nom de votre base de données

// Créez la connexion à la base de données
$conn = new mysqli($servername, $username, $password, $database);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}
// Initialiser la session
session_start();
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if(!isset($_SESSION["username"])){
  header("Location: ../pages_cnx/login.php");
  exit(); 
}

?>
<?php

// Requête pour récupérer les données des tables
$sql = "SELECT livre.id, livre.nom, livre.infos, auteur.nom as nom_auteur, editeur.nom as nom_editeur, genre.nom as nom_genre, langue.nom as nom_langue FROM livre
        INNER JOIN auteur ON livre.idauteur = auteur.id
        INNER JOIN editeur ON livre.idediteur = editeur.id
        INNER JOIN genre ON livre.idgenre = genre.id
        INNER JOIN langue ON livre.idlangue = langue.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque</title>
    <!-- Bootstrap core CSS -->
    <link href="../lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--external css-->
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="../css/style.css" rel="stylesheet">
  <link href="../css/style-responsive.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/cf0cc41982.js" crossorigin="anonymous"></script>
    <style>
        /* Styles CSS pour la représentation visuelle des livres */

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;

        }
        h1 {
            text-align: center;
            margin-top: 5%;
            color: #333;
        }
        form {
            text-align: center;
            margin-bottom: 30px;
        }
        label {
            font-size: 18px;
            margin-right: 10px;
        }
        input[type="text"], input[type="submit"] {
            padding: 10px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #555;
        }
        .container-2 {
            width: 80%;
            margin: 0 auto;

            padding: 20px;

            border-radius: 5px;
            padding-left: 150px;
        }
        .books {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        .book {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .book img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .book h2 {
            font-size: 16px;
            margin-top: 10px;
            color: #333;
        }
        .book p {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        .book a {
            color: #0066cc;
            text-decoration: none;
        }
        .book a:hover {
            text-decoration: underline;
        }
    </style>
</head>


<body>
  <section id="container">
      <!-- **********************************************************************************************************************************************************
          TOP BAR CONTENT & NOTIFICATIONS
          *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
        <!--logo start-->
        <a href="index.php" class="logo"><b><?php echo $_SESSION['username']; ?></span></b></a>
        <!--logo end-->
        <div class="nav notify-row text-center" id="top_menu">
          <!--  Categories start -->
          <ul class="nav top-menu">
            <!-- Ajout Livre Boutton start -->
            <li id="header_Editer_metadonnees_bar" class="dropdown">
              <a data-toggle="dropdown" class="dropdown-toggle" href="index.php#">
                Editer les metadonnées
                <i class="fa-solid fa-file-pen"></i>
                  </a>
                  <ul class="dropdown-menu extended notification">
                  <div class="notify-arrow notify-arrow-green"></div>
                  <li>
                    <a href="index.html#">
                      <span class="label label-success"><i class="fa fa-pen"></i></span>
                      Editer les métadonnées d'un livre
                      </a>
                  </li>
                </ul>
            </li>
            <li id="header_convertir_livre_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="index.php#">
                Convertir
                <i class="fa-solid fa-repeat"></i>
                  </a>
                <ul class="dropdown-menu extended notification">
                  <div class="notify-arrow notify-arrow-green"></div>
                  <li>
                    <a href="index.html#">
                      <span class="label label-warning"><i class="fa fa-arrow-right"></i></span>
                      Convertir le format d'un livre
                      </a>
                  </li>
                </ul>
            </li>

              <li id="header_convertir_livre_bar" class="dropdown">
                  <a data-toggle="dropdown" class="dropdown-toggle" href="results.php">
                      Rechercher un livre
                      <i class="fa-solid fa-repeat"></i>
                  </a>
                  <ul class="dropdown-menu extended notification">
                      <div class="notify-arrow notify-arrow-green"></div>
                      <li>
                          <a href="php/pages/results.php">
                              <span class="label label-warning"><i class="fa fa-arrow-right"></i></span>
                              Rechercher un livre
                          </a>
                      </li>
                  </ul>
              </li>

            <li id="header_convertir_livre_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="index.php#">
              Recupération des actualités
                <i class="fa-solid fa-newspaper"></i>
                  </a>
                <ul class="dropdown-menu extended notification">
                  <div class="notify-arrow notify-arrow-green"></div>
                  <li>
                    <a href="index.html#">
                      <span class="label label-danger"><i class="fa fa-calendar"></i></span>
                      Planifier le dl des actualités
                      </a>
                  </li>
                </ul>
            </li>
          </ul>
          <!-- notification end -->
        </div>
        <div class="top-menu">
          <ul class="nav pull-right top-menu">
            <li><a class="logout" href="logout.php">Déconnexion</a></li>
          </ul>
        </div>
      </header>
      <!--header end-->
      <!-- **********************************************************************************************************************************************************
          MAIN SIDEBAR MENU
          *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
        <div id="sidebar" class="nav-collapse ">
          <!-- sidebar menu start-->
          <ul class="sidebar-menu" id="nav-accordion">
          <li class="Formats">
              <a href="../index.php">
                <i class="fa fa-book"></i>
                <span>Bibliothèque</span>
                </a>
            </li>
            <li class="Livres">
              <a href="index.php">
                <i class="fa fa-book-open"></i>
                <span>Livres</span>
                </a>
            </li>
            <li class="auteur">
              <a href="index.php">
                <i class="fa fa-user-tie"></i>
                <span>Auteur</span>
                </a>
            </li>
            <li class="editeur">
              <a href="index.php">
                <i class="fa fa-feather"></i>
                <span>Editeur</span>
                </a>
            </li>
            <li class="Genres">
              <a href="index.php">
                <i class="fa fa-tags"></i>
                <span>Genres</span>
                </a>
            </li>
          </ul>
          <!-- sidebar menu end-->
        </div>
      </aside>
      <!--sidebar end-->


      <div class="container-2">
          <h1>Recherche de Livres</h1>

          <form method="GET">
              <label for="recherche">Rechercher :</label>
              <input type="text" id="recherche" name="recherche">
              <input type="submit" value="Rechercher">
          </form>

          <?php


          if (isset($_GET['recherche']) && !empty($_GET['recherche'])) {
              $searchTerm = $_GET['recherche'];
              $recherche = urlencode($searchTerm);
              // Récupérer la date du 1er janvier de cette année
              $date = date('Y') . "-01-01";
              $api_url = "https://www.googleapis.com/books/v1/volumes?q=intitle:$recherche&langRestrict=fr&orderBy=newest&printType=books&filter=partial&projection=lite&publishedDate=$date";

              $response = file_get_contents($api_url);

              if ($response === false) {
                  echo "Erreur lors de la récupération des données.";
              } else {
                  $data = json_decode($response, true);

                  if (isset($data['items'])) {
                      echo "<p>Résultats pour la recherche : '$searchTerm'</p>";

                      $books = $data['items'];
                      echo "<div class='books'>";
                      $printedTitles = []; // Tableau pour stocker les titres déjà imprimés
                      foreach ($books as $item) {
                          $volumeInfo = $item['volumeInfo'];
                          // Vérifier si le titre a déjà été imprimé
                          if (!in_array($volumeInfo['title'], $printedTitles, true)) {
                              echo "<div class='book'>";
                              if (isset($volumeInfo['imageLinks']) && isset($volumeInfo['imageLinks']['thumbnail'])) {
                                  echo "<img src='" . $volumeInfo['imageLinks']['thumbnail'] . "' alt='Couverture Livre'>";
                              } else {
                                  echo "<img src='https://via.placeholder.com/150x200' alt='Couverture Livre'>";
                              }
                              echo "<h2>" . $volumeInfo['title'] . "</h2>";
                              if (isset($volumeInfo['authors'])) {
                                  echo "<p>Auteur(s): " . implode(", ", $volumeInfo['authors']) . "</p>";
                              }
                              if (isset($volumeInfo['publishedDate'])) {
                                  $date = date("d-m-Y", strtotime($volumeInfo['publishedDate']));
                                  echo "<p>Date de publication: " . $date . "</p>";
                              }
                              if (isset($volumeInfo['previewLink'])) {
                                  echo "<p><a href='" . $volumeInfo['previewLink'] . "' target='_blank'>Voir sur Google Books</a></p>";
                              }
                              if (isset($item['saleInfo']['buyLink'])) {
                                  echo "<h3>Où acheter:</h3> <a href='" . $item['saleInfo']['buyLink'] . "'><img src='logo google.png' alt='Google Logo'></a> ";


                                  if (isset($item['saleInfo']['listPrice']['amount']) && isset($item['saleInfo']['listPrice']['currencyCode'])) {
                                      echo "<h3>".$item['saleInfo']['listPrice']['amount'] . " " .  $item['saleInfo']['listPrice']['currencyCode']. "<h3>" . "<br>";
                                  } else {
                                      echo "Prix non disponible<br>";
                                  }
                              } else {
                                  echo "<h3>Non disponible à l'achat dans la bibliothèque ebook Google.</h3>";
                                  echo "<br>";
                              }


                              echo "</div>";
                              $printedTitles[] = $volumeInfo['title']; // Ajouter le titre à la liste des titres imprimés
                          }
                      }
                      echo "</div>";
                  } else {
                      echo "Aucun livre trouvé pour la recherche : '$searchTerm'";
                  }
              }
          } elseif (empty($_GET['recherche']) && isset($_SESSION['previousResults'])) {
              unset($_SESSION['previousResults']);
          }
          ?>
      </div>
    
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var pseudoElement = document.querySelector('.container::before');
        if (pseudoElement) {
          pseudoElement.remove();
        }
      });

      const bookList = document.getElementById('book-list');
      const addBookButton = document.getElementById('add-book');
      const fileInput = document.getElementById('file-input');

      const bookDetails = document.getElementById('book-details');
      const titleInput = document.getElementById('title');
      const authorInput = document.getElementById('author');
      const saveDetailsButton = document.getElementById('save-details');
      const closeDetailsButton = document.getElementById('close-details');

      addBookButton.addEventListener('click', () => {
        fileInput.click();
      });

      fileInput.addEventListener('change', (event) => {
        const files = event.target.files;
        if (files.length > 0) {
          const newBookItem = document.createElement('li');
          newBookItem.classList.add('book-item');

          newBookItem.innerHTML = `
            <div class="col-md-2 col-sm-5 mb">
              <div class="darkblue-panel pn">
                <div class="darkblue-header">
                  <p style="color : white;">${files[0].name}</p>
                </div>
                <p>Auteur : Aucun</p>
                <footer>
                  <div class="pull-left">
                    <h5><i class="fa fa-hdd-o"></i></h5>
                  </div>
                  <div class="pull-right">
                    <h5>Format : Ebup</h5>
                  </div>
                </footer>
              </div>
            </div>
          `;

          bookList.appendChild(newBookItem);
        }
      });

      bookList.addEventListener('click', (event) => {
        if (event.target.classList.contains('edit-button')) {
          bookDetails.style.display = 'block';
          const bookItem = event.target.closest('.book-item');
          const titleElement = bookItem.querySelector('h3');
          const authorElement = bookItem.querySelector('p:nth-of-type(2)');
          titleInput.value = titleElement.textContent;
          authorInput.value = authorElement.textContent.split(':')[1].trim();
        }

        if (event.target.classList.contains('delete-button')) {
          const bookItem = event.target.closest('.book-item');
          bookList.removeChild(bookItem);
        }
      });

      saveDetailsButton.addEventListener('click', () => {
        const selectedBook = document.querySelector('.book-item .edit-button:focus');
        if (selectedBook) {
          const titleElement = selectedBook.querySelector('h3');
          const authorElement = selectedBook.querySelector('p:nth-of-type(2)');
          titleElement.textContent = titleInput.value;
          authorElement.textContent = `Auteur : ${authorInput.value}`;
          bookDetails.style.display = 'none';
        }
      });

      closeDetailsButton.addEventListener('click', () => {
        bookDetails.style.display = 'none';
      });

      

    </script>

      <!-- js placed at the end of the document so the pages load faster -->
      <script src="lib/jquery/jquery.min.js"></script>

      <script src="lib/bootstrap/js/bootstrap.min.js"></script>
      <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
      <script src="lib/jquery.scrollTo.min.js"></script>
      <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
      <script src="lib/jquery.sparkline.js"></script>
      <!--common script for all pages-->
      <script src="lib/common-scripts.js"></script>
      <script type="text/javascript" src="lib/gritter/js/jquery.gritter.js"></script>
      <script type="text/javascript" src="lib/gritter-conf.js"></script>
      <!--script for this page-->
      <script src="lib/sparkline-chart.js"></script>
      <script src="lib/zabuto_calendar.js"></script>
</body>
</html>