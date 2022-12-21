<?php
include("../includes/navbar.php");
$imageErr = "";

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $mbFileSize = $_FILES["fileToUpload"]["size"] / 1000000;
  if ($mbFileSize > 10) {
      $imageErr = "Your file is too large. Max file size is 10MB. Yours was $mbFileSize MB";
  }


    $businessName = clean_input($_POST["businessName"]);
    $businessDescription = clean_input($_POST["businessDescription"]);
    $businessLocation = clean_input($_POST["businessLocation"]);
    $typeOfBusiness = clean_input($_POST["typeOfBusiness"]);
    $ethnicities = clean_input($_POST["ethnicities"]);
    $imageAlt = clean_input($_POST["imageAlt"]);
    $businessImage = file_get_contents($_FILES['fileToUpload']['tmp_name']);  
    $imageTitle = htmlspecialchars($_FILES["fileToUpload"]["name"]);

    // $isPublished = false;
    // if (isset($_POST['publish'])) {
    //   $isPublished = true;
    // }
   
    if (!empty($businessName) && !empty($businessDescription)) {
      $authorId = $_SESSION['userid'];
      //$publishDate = date('Y-m-d');
   
      $businessInfo = array(
        "businessId" => "",
        "businessName" => $businessName,
        "businessDescription" => $businessDescription,
        "businessLocation" => $businessLocation,
        "typeOfBusiness" => $typeOfBusiness,
        "ethnicities" => $ethnicities,
        "businessImage" => $businessImage,
        "imageAlt" => $imageAlt
      );
   
      $business = new Businesses($conn, $businessInfo);
      $business->createBusiness(); // this method doesn't exist yet
      //header("Location: ArticlesListing.php");
    }
  }
  
?>
 
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10 col-lg-8 col-xl-7">
      <form enctype="multipart/form-data" method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
          <label for="businessName">Business Name</label>
          <span class="error">*<br>
          <input type="text" class="form-control" name="businessName" id="businessName" required>
        </div>
        <div class="form-group">
            <label for="fileToUpload">Select image to upload:</label>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <span class="error">* <?php echo $imageErr;?></span><br>
        </div>
        <div class="form-group">
          <label for="imageAlt">Description of image for those with disabilities</label>
          <span class="error">*<br>
          <input type="text" class="form-control" name="imageAlt" id="imageAlt">
        </div>
        <div class="form-group">
          <label for="businessDescription">Write a description or review of the business</label>
          <span class="error">*<br>
          <textarea rows="10" class="form-control" name="businessDescription" id="businessDescription" required></textarea>
        </div>
        <div class="form-group">
          <label for="businessLocation">Business address</label>
          <span class="error">*<br>
          <input type="text" class="form-control" name="businessLocation" id="businessLocation">
        </div>
        <div class="form-group">
          <label for="typeOfBusiness">Business type</label>
          <span class="error">*<br>
          <input type="text" class="form-control" name="typeOfBusiness" id="typeOfBusiness" required>
        </div>
        <div class="form-group">
          <label for="ethnicities">Histpanic/Latino</label>
          <input type="checkbox" id="ethnicities" name="ethnicities" value = "Hispanic/Latino">
        </div>
        <input type="submit" class="btn btn-primary" value="Submit">
    </form>    
    </div>
  </div>
</div>
