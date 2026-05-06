<?php
class Order {
    private $conn;
    private $table_name = "orders";

    public $id;
    public $customer_id;
    public $user_id;
    public $product_name;
    public $quantity;
    public $amount;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET customer_id=:customer_id, user_id=:user_id, product_name=:product_name, 
                      quantity=:quantity, amount=:amount, status=:status";
        
        $stmt = $this->conn->prepare($query);
        
        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":product_name", $this->product_name);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":status", $this->status);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readAllWithRelations() {
        $query = "SELECT o.id, o.product_name, o.quantity, o.amount, o.status, o.created_at,
                         c.name as customer_name, c.email as customer_email,
                         u.name as created_by
                  FROM " . $this->table_name . " o
                  LEFT JOIN customers c ON o.customer_id = c.id
                  LEFT JOIN users u ON o.user_id = u.id
                  ORDER BY o.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET customer_id=:customer_id, product_name=:product_name, 
                      quantity=:quantity, amount=:amount, status=:status 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":product_name", $this->product_name);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function count() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function totalSales() {
        $query = "SELECT SUM(amount) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ? $row['total'] : 0;
    }
}
?>