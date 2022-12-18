<?php 
class Businesses {
    public $conn;
    public $businessId;
    public $businessOwnerId;
    public $businessName;
    public $businessLocation;
    public $typeOfBusiness;
    public $ethnicities;
    public $businessDescription;
    public $businessImage;
    public $imageAlt;

    function __construct($conn, $businessInfo) {
        $this->conn = $conn;
        $this->businessId = $businessInfo['businessId'];
        //$this->businessOwnerId = $businessInfo['businessOwnerId'];
        $this->businessName = $businessInfo['businessName'];
        $this->businessLocation = $businessInfo['businessLocation'];
        $this->typeOfBusiness = $businessInfo['typeOfBusiness'];
        $this->ethnicities = $businessInfo['ethnicities'];
        $this->businessDescription = $businessInfo['businessDescription'];
        $this->businessImage = $businessInfo['businessImage'];
        $this->imageAlt = $businessInfo['imageAlt'];
    }
    function __destruct() { }

    function createBusiness () {
        $insert = "INSERT INTO businesses (businessName, businessLocation, typeOfBusiness, ethnicities, businessDescription, businessImage, imageAlt, businessOwnerId) VALUES (:businessName, :businessLocation, :typeOfBusiness, :ethnicities, :businessDescription, :businessImage, :imageAlt, :businessOwnerId)";
        $stmt = $this->conn->prepare($insert);
        $stmt->bindParam(':businessName', $this->businessName);
        $stmt->bindParam(':businessLocation', $this->businessLocation);
        $stmt->bindParam(':typeOfBusiness', $this->typeOfBusiness);
        $stmt->bindParam(':ethnicities', $this->ethnicities);
        $stmt->bindParam(':businessDescription', $this->businessDescription);
        $stmt->bindParam(':businessImage', $this->businessImage);
        $stmt->bindParam(':imageAlt', $this->imageAlt);
        $stmt->bindParam(':businessOwnerId', $this->businessOwnerId, PDO::PARAM_INT);
        $stmt->execute();
    }

    static function getPostsFromDb($conn, $numPosts = 20) {
        $selectPosts = "SELECT businesses.*, users.fullName as author
        FROM businesses
        LEFT JOIN (users) ON users.userId=businesses.businessId
        WHERE businesses.businessId > 0
        ORDER BY businesses.businessId DESC
        LIMIT :numPosts";


        $stmt = $conn->prepare($selectPosts);
        $stmt->bindParam(':numPosts', $numPosts, PDO::PARAM_INT);
        $stmt->execute();

        $postList = array();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach($stmt->fetchAll() as $listRow) {
            $post = new Businesses($conn, $listRow);
            $postList[] = $post;
        }
        return $postList;
            }
}