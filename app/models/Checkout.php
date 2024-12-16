<?php
declare(strict_types=1);

namespace models;
use core\Database;
use PDO;

class Checkout
{
    use Database;

    protected $table = 'orders';
    protected $allowedColumns = [
        'customer_id',
        'total_amount',
        'name',
        'surname',
        'email',
        'number',
        'country',
        'city',
        'address',
        'state',
        'zipcode',
        'note'
    ];

    public function selectOrder(string $order_id, string $customer_id)
    {
        $pdo = $this->get_connection();

        $query = "SELECT * FROM $this->table WHERE order_id = :order_id AND customer_id = :customer_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function addOrder($data)
    {
        $pdo = $this->get_connection();

        // Remove unwanted data.
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);

        $query = "INSERT INTO $this->table (" . implode(",", $keys) . ") VALUES (:" . implode(",:", $keys) . ")";
        $stmt = $pdo->prepare($query);

        foreach ($keys as $key) {
            $paramName = ':' . $key;
            $stmt->bindParam($paramName, $data[$key]);
        }

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}