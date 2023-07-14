<?php  //Game plan, I am going to set up the objects for the database, after that I am going to set up the sign up, later the log in, and then I will allow for users to upload something. Then I will have a page that shows what they upload. 
include("../includes/navbar.php");
$fullName = $username = $password = "";
$passwordErr = $usernameErr = "";
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = clean_input($_POST["fullName"]);
    $username = clean_input($_POST["username"]);
    $password1 = clean_input($_POST["password1"]);
    $password2 = clean_input($_POST["password2"]);
 
    if ($password1 !== $password2) {
      $password = "";
      $passwordErr = "Passwords must match";
    } else {
      $password = password_hash($password1, PASSWORD_DEFAULT);
    }
 
    $usernameErr = checkUsernameIsUnique($username);

    if (empty($passwordErr) && empty ($usernameErr)) {
      addUser($fullName, $username, $password);
      login($username);
    }
}

function checkUsernameIsUnique($username) {
    $conn = connect_to_db("finalProjectLeviDiaz");
    $selectUser = "SELECT username FROM users WHERE username=:username";
    $stmt = $conn->prepare($selectUser);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return empty($stmt->fetchAll()) ? "": "Username is already taken";
}
 
function addUser($fullName, $username, $password) {
    $conn = connect_to_db("finalProjectLeviDiaz");
    $insert = "INSERT INTO users (fullName, username, userPassword)
    VALUES (:fullName, :username, :password)";
    $stmt = $conn->prepare($insert);
    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
}

function login($username) {
    $_SESSION['username'] = $username;
    $_SESSION['userid'] = getUserId($username);
    header("Location: viewPosts.php");
}

?>

<style> 
    .error {color: #FF0000;}
</style>
<div class='userLoginForm container'>
    <div class="row">
        <div class="col-12 col-lg-6 offset-lg-3">
            <form method="post" action="<?php
            htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" name="fullName" id="fullName" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <span class="error">* <?php echo $usernameErr;?></span><br>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label for="password1">Password</label>
                    <span class="error">* <?php echo $passwordErr;?></span><br>
                    <input type="password" class="form-control" name="password1" id="password1" required>
                </div>
                <div class="form-group">
                    <label for="password2">Repeat Password</label>
                    <span class="error">* <?php echo $passwordErr;?></span><br>
                    <input type="password" class="form-control" name="password2" id="password2" required>
                </div>
                <input type="submit" class="btn btn-primary" value="Submit">
            </form>
        </div>
    </div>
</div>
