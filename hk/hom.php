<?php
/*connexion ama lezm naraw fazet cookies lin!!*/
session_start();
include('includes/config.php');
error_reporting(0);
$_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/READ.css">
    <link rel="stylesheet" href="assets/bootstrap/css/back.css">
</head>

<body>
    <!-- Header lezm nbedlou teswyra taa background -->
    <?php include 'includes/header.php'; ?>

    <sectio class="nav">
      
      <h3 class="span loader"><span class="m">B</span><span class="m">E</span><span class="m">N</span><span class="m">E</span><span class="m">F</span><span class="m">I</span><span class="m">T</span><span class="m">S</span><span class="m">&nbsp;</span><span class="m">o</span><span class="m">f</span><span class="m">&nbsp;</span><span class="m">T</span><span class="m">E</span><span class="m">C</span><span class="m">H</span><span class="m">N</span><span class="m">O</span><span class="m">L</span><span class="m">O</span><span class="m">G</span><span class="m">I</span><span class="m">E</span><span class="m">S</span></h3>
    </sectio>
    <canvas class="background"></canvas>
    <!-- Header -->

    <div class="container">
        <div class="row">
            <?php
            /*preparation des tableaux de BD des article qui ont une statuts 1*/
            $s = 1;
            $sql = "SELECT posts.*,categories.catname FROM posts JOIN categories ON categories.id=posts.category WHERE posts.status=:s ORDER BY posts.id DESC LIMIT 3";
            $query = $dbh->prepare($sql);
            $query->bindParam(':s', $s, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            $cnt = 1;
            /*affichage des articles de BD de tableau posts*/
            if ($query->rowCount() > 0) {
                foreach ($results as $result) {
                    ?>
                    <div class="col-md-10 col-lg-12">
                        <div class="post-preview">
                            <a href="post-details.php?id=<?php echo htmlentities($result->id); ?>">
                                <h2 class="post-title"><?php echo htmlentities($result->title); ?>,
                                    <i><?php echo htmlentities($result->catname); ?></i></h2>
                                <h3 class="post-subtitle"><?php echo htmlentities($result->grabber); ?></h3>
                            </a>

                            <p class="post-meta">Posted by&nbsp;<?php echo htmlentities($result->username); ?> on <?php echo htmlentities($result->creationdate); ?>
                                <a class=" float-right "  href="post-details.php?id=<?php echo htmlentities($result->id); ?>">
                                    <button class="custom-btn btn-12"><span>Click!</span><span>Read More</span></button>
                                </a>
                                <a class=" float-right "  href="post-details.php?id=<?php echo htmlentities($result->id); ?>">
                                    <button class="custom-btn btn-12"><span><?php echo htmlentities($result->catname); ?></span><span>TAGS</span></button>
                                </a>
                            </p>
                            
                            
                        </div>
                        <BR><hr>


                    </div>
                <?php }
            } ?>

        </div>
         <!-- button dérige vers la pages de toutes les articles -->
        <div class="row">
            <div class="col-md-10 col-lg-12">
                <div class="clearfix">
                    <a href="view-posts.php">
                        <button class="btn btn-primary float-right" type="button">Older Posts&nbsp;⇒</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/clean-blog.js"></script>
    <script src="assets/js/back.js"></script>
</body>

</html>
