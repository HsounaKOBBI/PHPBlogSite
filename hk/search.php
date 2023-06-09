<?php
session_set_cookie_params(0);
session_start();
include('includes/config.php');
error_reporting(0);
$_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
$catname = $_POST['search'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Blog Posts</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/search.css">
    <link rel="stylesheet" href="assets/bootstrap/css/READ.css">
</head>

<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <header class="masthead" style="background-image:url('assets/img/home-bg.jpg');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-8 mx-auto">
                    <div class="site-heading">
                        <h1>IT Blog</h1><span class="subheading">An Informative Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header -->
    <div class="app-container">
  <div class="app-header">
      <div class=" float-right ">
        <form action="search.php" method="post"  name="form">
            <div class="search-wrapper">
                <input class="search-input" id="maRecherche" name="search" type="text" placeholder="Search">
                <button type="submit" name="submit">
                     <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-search" viewBox="0 0 24 24">
                        <defs></defs>
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="M21 21l-4.35-4.35"></path>
                     </svg>
                </button>
            </div>
        </form>
    </div>
 </div>

    <article id="tableau">
        <div class="container">
            <div class="row">
                <?php
                if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
                    $page_no = $_GET['page_no'];
                } else {
                    $page_no = 1;
                }
                
                $total_records_per_page = 3;
                $offset = ($page_no - 1) * $total_records_per_page;
                $previous_page = $page_no - 1;
                $next_page = $page_no + 1;
                $adjacents = "2";

                $sql10="SELECT * from categories where catname=:catname ";
                $query = $dbh->prepare($sql10);
                $query->bindParam(':catname', $catname, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                foreach ($results as $result){
                     $catid = $result->id; 
                }
                
                
                $sql1="SELECT * from posts where category=:catid and posts.status=1";
                $stm1 = $dbh->prepare($sql1);
                $stm1->bindParam(':catid', $catid, PDO::PARAM_STR);
                $stm1->execute();
                $total_records = $stm1->rowCount();

                $total_no_of_pages = ceil($total_records / $total_records_per_page);
                $second_last = $total_no_of_pages - 1;

                $s = 1;
                $sql = "SELECT posts.*,categories.catname FROM posts JOIN categories ON categories.id=posts.category WHERE posts.category=:catid and posts.status=1 ORDER BY posts.id DESC LIMIT $offset, $total_records_per_page";
                $query = $dbh->prepare($sql);
                $query->bindParam(':catid', $catid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                if ($query->rowCount() > 0) {
                    foreach ($results as $result) {
                        ?>
                        <div class="col-md-10 col-lg-12">
                            <div  class="post-preview">
                                <a href="post-details.php?id=<?php echo htmlentities($result->id); ?>">
                                    <h2 class="post-title"><?php echo htmlentities($result->title); ?>,
                                        <i><?php echo htmlentities($result->catname); ?></i></h2>
                                    <h3 class="post-subtitle"><?php echo htmlentities($result->grabber); ?></h3>
                                </a>

                                <p  class="post-meta">Posted by&nbsp;<?php echo htmlentities($result->username); ?> on <?php echo htmlentities($result->creationdate); ?>
                                    <a class=" float-right "  href="post-details.php?id=<?php echo htmlentities($result->id); ?>">
                                        <button class="custom-btn btn-12"><span>Click!</span><span>Read More</span></button>
                                    </a>
                                    <a id="kk"class=" float-right "  href="post-details.php?id=<?php echo htmlentities($result->id); ?>">
                                        <button class="custom-btn btn-12"><span><?php echo htmlentities($result->catname); ?></span><span>TAGS</span></button>
                                    </a>
                                </p>
                                <br><hr>
                            
                        </div>
                    </div>
                    <?php }
                } ?>

                <div style='padding: 10px 20px 0;'>
                    <strong>Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
                </div>

            </div>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li <?php if ($page_no <= 1) {
                        echo "class='page-item disabled'";
                    } ?>>
                        <a class="page-link" <?php if ($page_no > 1) {
                            echo "href='?page_no=$previous_page'";
                        } ?>>Previous</a>
                    </li>

                    <?php
                    if ($total_no_of_pages <= 10) {
                        for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                            if ($counter == $page_no) {
                                echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                            } else {
                                echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                            }
                        }
                    } elseif ($total_no_of_pages > 10) {
                        if ($page_no <= 4) {
                            for ($counter = 1; $counter < 8; $counter++) {
                                if ($counter == $page_no) {
                                    echo "<li class='page-item active'><a>$counter</a></li>";
                                } else {
                                    echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                }
                            }
                            echo "<li class='page-item'><a>...</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last'>$second_last</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                        } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                            echo "<li class='page-item'><a class='page-link' href='?page_no=1'>1</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='?page_no=2'>2</a></li>";
                            echo "<li class='page-item'><a>...</a></li>";
                            for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                                if ($counter == $page_no) {
                                    echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                } else {
                                    echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                }
                            }
                            echo "<li class='page-item'><a>...</a></li>";
                            echo "<li class='page-item'><a href='?page_no=$second_last'>$second_last</a></li>";
                            echo "<li class='page-item'><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                        } else {
                            echo "<li class='page-item'><a class='page-link' href='?page_no=1'>1</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='?page_no=2'>2</a></li>";
                            echo "<li class='page-item'><a>...</a></li>";
                            for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                if ($counter == $page_no) {
                                    echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                                } else {
                                    echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                                }
                            }
                        }
                    }
                    ?>

                    <li <?php if ($page_no >= $total_no_of_pages) {
                        echo "class='page-item disabled'";
                    } ?>>
                        <a class="page-link" <?php if ($page_no < $total_no_of_pages) {
                            echo "href='?page_no=$next_page'";
                        } ?>>Next</a>
                    </li>
                    <?php if ($page_no < $total_no_of_pages) {
                        echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                    } ?>
                </ul>
            </nav>
        </div>
    </article>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
    <script type="text/javascript">
function getXMLHttpRequest(){
    var xhr =null ;
try{
    xhr= new ActiveXObject("Microsoft.WMLHTTP");

}
catch(e){
    xhr= new XMLHttpRequest();
}
return xhr ;
}
function filtrer()
{
  var filtre, tableau,ligne,cellule,i,texte
  filtre= document.getElementById("maRecherche").value.toUpperCase();
  tableau= document.getElementById("tableau");
  ligne=tableau.getElementsByTagName("h2");
  for (i=0;i<ligne.length;i++){
    cellule=ligne[i].getElementsByTagName("i")[0];
    if (cellule){
        texte =cellule.innerText;
        if (texte.toUpperCase().indexOf(filtre)>-1){
           ligne[i].style.display="block";
        }
        else{
           ligne[i].style.display ="none";
        }
    }
  }
}
</script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/clean-blog.js"></script>
</body>

</html>