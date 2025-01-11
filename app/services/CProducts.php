<?php 

class CProducts{

    public $pdo;

    public function __construct(){
        $this->pdo = new PDO('mysql:host=localhost;dbname=testovoe_db','root','akramatik');
    }

    public function getProducts($limit = 10)
    {
        $sql = "SELECT * FROM Products ORDER BY DATE_CREATE DESC LIMIT $limit";

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $products;

    }

    public function hideProduct($id) {
        $sql = "UPDATE Products SET IS_HIDDEN = true WHERE ID = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        
        return ['success' => true];
    }


    public function increaseQuantity($id){
        $sql = "UPDATE Products SET PRODUCT_QUANTITY = PRODUCT_QUANTITY + 1 WHERE ID = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();

        return ['success' => true];
    } 

    public function decreaseQuantity($id){
        $sql = "UPDATE Products SET PRODUCT_QUANTITY = PRODUCT_QUANTITY - 1 WHERE ID = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();

        return ['success' => true];
    }

    

}

if (isset($_GET['id']) && isset($_GET['type'])) {
    $product = new CProducts();
    if ($_GET['type'] === 'plus') {
        // var_dump($_GET['id'] . " " . $_GET['type']);die;
        $product->increaseQuantity($_GET['id']);
        echo json_encode($result);
        exit;
    }else if ($_GET['type'] === 'minus'){
        $product->decreaseQuantity($_GET['id']);
        echo json_encode($result);
        exit;
    }else{
        $result = "Something went wrong";
        echo json_encode($result);
        exit;
    }
}

if (isset($_GET['id'])) {
    $product = new CProducts();
    $result = $product->hideProduct($_GET['id']);
    echo json_encode($result);
    exit;
}
