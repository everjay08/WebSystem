<?php
class User {
    private $conn;

    // Constructor for database connection
    public function __construct($host, $user, $pass, $db) {
        $this->conn = new mysqli($host, $user, $pass, $db);
        if ($this->conn->connect_error) {
            die("Database Connection Failed: " . $this->conn->connect_error);
        }
    }

    // Register new user
    public function register($fullname, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fullname, $email, $hashedPassword);
        
        if ($stmt->execute()) {
            return "Registration Successful!";
        } else {
            return "Error: " . $this->conn->error;
        }
    }

    // User login
    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = $user['fullname'];
                return "Login Successful!";
            } else {
                return "Incorrect Password!";
            }
        } else {
            return "No account found with that email.";
        }
    }
}
?>
