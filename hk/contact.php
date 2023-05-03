<?php
session_set_cookie_params(0);
session_start();
error_reporting(0);
include('includes/config.php');
error_reporting(0);
$_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
if (isset($_POST['send'])) {
    $uname = $_POST['uname'];
    
    $email = $_POST['email'];
    
    $contact = $_POST['contact'];
    
    $message = $_POST['description'];

    $to = $_POST['to'];

    
    $sql7 = "SELECT * FROM users WHERE  id=:to";
    $query = $dbh->prepare($sql7);
    $query->bindParam(':to', $to, PDO::PARAM_STR);
    $query->execute();
    $results7 = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        foreach ($results7 as $result7) {
            $emailTo=$result7->email;

        }}
    
    
   
    
    $status='1';
    $sql = "INSERT INTO contactusquery(`uname`,`email`,`emailTo`,`contact`,`message`,`status`) VALUES(:uname,:email,:emailTo,:contact,:message,:status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':uname', $uname, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':emailTo', $emailTo, PDO::PARAM_STR);
    $query->bindParam(':contact', $contact, PDO::PARAM_STR);
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        echo "<script>alert('Form successfully submitted. We\'ll contact you soon')</script>";
    } else {
        echo "<script>alert('An error occurred. Try again')</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Contact us</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
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
                        <h1>IT Blog</h1><span class="subheading">Contact Us</span></div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header -->

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-lg-8 mx-auto">
                <h2 class="post-title">Contact Us</h2>
                <form id="contactForm" name="sentMessage" method="post">
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls"><label for="name">Name</label><input
                                    class="form-control" type="text" id="name" required="" placeholder="Name" name="uname"><small
                                    class="form-text text-danger help-block"></small></div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls"><label for="email">Email Address</label><input
                                    class="form-control" type="email" id="email" required=""
                                    placeholder="Email Address" name="email"><small class="form-text text-danger help-block"></small>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="form-group floating-label-form-group controls"><label for="phone">Phone Number</label><input
                                    class="form-control" type="tel" id="phone" required=""
                                    placeholder="Phone Number" name="contact"><small class="form-text text-danger help-block"></small>
                        </div>
                    </div>
                    <div class="control-group">
                            <div class="form-group floating-label-form-group controls mb-3"><label for="message">Message</label><input
                                        type="text" class="form-control" id="message"
                                        data-validation-required-message="Please enter a message." required=""
                                        placeholder="Message" rows="5" name="description"><small
                                        class="form-text text-danger help-block"></small>
                            </div>
                    </div>
                    
                    <div class="control-group">
                    <select name="to" class="form-control form-control-lg" aria-label=".form-select-sm example">
                        
                        <option selected>Open this select menu</option>
                        <?php
                        
                        $sts = 1;
                        $sql3 = "SELECT * FROM users WHERE  status=:sts";
                        $query = $dbh->prepare($sql3);
                        $query->bindParam(':sts', $sts, PDO::PARAM_STR);
                        $query->execute();
                        $results3 = $query->fetchAll(PDO::FETCH_OBJ);
                        if ($query->rowCount() > 0) {
                            foreach ($results3 as $result3) {
                                ?>
                        <option value="<?php echo htmlentities($result3->id);?>"> <?php echo htmlentities($result3->fname.$result3->lname); ?></option>
                        <?php }}?>  
                        <option > admin </option>
                    </select>
                    </div>
                    
                    <br>
                    <div id="success"></div>
                    <div class="form-group">
                        <button class="btn btn-primary float-right" id="sendMessageButton" type="submit" name="send">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <hr>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/clean-blog.js"></script>
</body>

</html>