<?php include "template.php";
/** @var $conn */

if (!authorisedAccess(false, false, true)) {
    header("Location:index.php");
}
if (isset($_GET["UserID"])) {
    if ($_SESSION['access_level'] == 3) {
        $userid = $_GET["UserID"];
    } else {
        $_SESSION["flash_message"] = "Access denied!";
        $userid = $_SESSION["user_id"] ;
    }
} else {
    $userid = $_SESSION["user_id"] ;
}
?>

<title>Admin Reset Password</title>

<h1 class='text-primary'>Reset Password</h1>
<form action="userProfile.php?UserID=<?=$userid?>" method="post" enctype="multipart/form-data">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2>Account Details</h2>
                <p>Please enter new password:</p>

                <p>Password<input type="password" name="password" class="form-control" required="required"></p>

            </div>
        </div>
    </div>
    <input type="submit" name="formSubmit" value="Submit">
</form>



<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $password = sanitise_data($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $accessLevel = 1;
    //$hashed_password;


    $sql = "UPDATE Users SET HashedPassword = :newPassword WHERE UserID='$userid'";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':newPassword', $hashed_password);
    $stmt->execute();
    $_SESSION["flash_message"] = "Password Reset!";
    header("Location:index.php");


}
?>

