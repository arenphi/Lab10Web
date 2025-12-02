<?php
// Konfigurasi Database (Sesuaikan jika nama DB atau kredensial berbeda)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'latihan1'); 

class Database
{
    private $conn;

    // Konstruktor: Otomatis menjalankan koneksi saat objek dibuat
    public function __construct()
    {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Cek koneksi
        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }
    
    // Method SELECT (untuk mengambil banyak baris data)
    public function select($sql)
    {
        $result = $this->conn->query($sql);
        if (!$result) return false;
        
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
    
    // Method GET_ROW (untuk mengambil satu baris data)
    public function get_row($sql)
    {
        $result = $this->conn->query($sql);
        if (!$result || $result->num_rows == 0) return false;
        
        return $result->fetch_assoc();
    }
    
    // Method INSERT data
    public function insert($table, $data)
    {
        $column = [];
        $value = [];
        
        foreach($data as $key => $val) {
            $column[] = $key;
            
            // Mengatasi nilai NULL
            if (is_null($val)) {
                $value[] = 'NULL'; 
            } else {
                $value[] = "'" . $this->conn->real_escape_string($val) . "'"; 
            }
        }
        
        $columns = implode(",", $column);
        $values = implode(",", $value);
        
        $sql = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $values . ")";
        
        return ($this->conn->query($sql) === TRUE);
    }

    // Method UPDATE data
    public function update($table, $data, $where)
    {
        $update_value = [];
        
        foreach($data as $key => $val) {
            if (is_null($val)) {
                $update_value[] = "$key=NULL";
            } else {
                $update_value[] = "$key='" . $this->conn->real_escape_string($val) . "'";
            }
        }
        
        $set_clause = implode(",", $update_value);
        
        $sql = "UPDATE " . $table . " SET " . $set_clause . " WHERE " . $where;
        
        return ($this->conn->query($sql) === TRUE);
    }

    // Method DELETE data
    public function delete($table, $where)
    {
        $sql = "DELETE FROM " . $table . " WHERE " . $where;
        return ($this->conn->query($sql) === TRUE);
    }
}
?>