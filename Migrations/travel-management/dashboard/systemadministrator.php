<?php

class SystemAdministrator {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function createAdmin($name, $email, $password, $role) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO administrators (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);
        if ($stmt->execute()) {
            return "Admin created successfully!";
        } else {
            return "Error creating admin: " . $this->conn->error;
        }
    }

    public function deleteAdmin($adminID) {
        $stmt = $this->conn->prepare("DELETE FROM administrators WHERE adminID = ?");
        $stmt->bind_param("i", $adminID);
        if ($stmt->execute()) {
            return "Admin deleted successfully!";
        } else {
            return "Error deleting admin: " . $this->conn->error;
        }
    }

    public function updateAdmin($adminID, $name, $email, $role) {
        $stmt = $this->conn->prepare("UPDATE administrators SET name = ?, email = ?, role = ? WHERE adminID = ?");
        $stmt->bind_param("sssi", $name, $email, $role, $adminID);
        if ($stmt->execute()) {
            return "Admin updated successfully!";
        } else {
            return "Error updating admin: " . $this->conn->error;
        }
    }

    public function assignRole($adminID, $role) {
        $stmt = $this->conn->prepare("UPDATE administrators SET role = ? WHERE adminID = ?");
        $stmt->bind_param("si", $role, $adminID);
        if ($stmt->execute()) {
            return "Role assigned successfully!";
        } else {
            return "Error assigning role: " . $this->conn->error;
        }
    }

    public function manageUsers() {
        $query = "SELECT * FROM administrators";
        $result = $this->conn->query($query);
        if ($result) {
            $admins = [];
            while ($row = $result->fetch_assoc()) {
                $admins[] = $row;
            }
            return $admins;
        } else {
            return "Error retrieving administrators: " . $this->conn->error;
        }
    }

    public function viewLogs($adminID) {
        $stmt = $this->conn->prepare("SELECT * FROM logs WHERE adminID = ?");
        $stmt->bind_param("i", $adminID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $logs = [];
            while ($row = $result->fetch_assoc()) {
                $logs[] = $row;
            }
            return $logs;
        } else {
            return "Error retrieving logs: " . $this->conn->error;
        }
    }

    public function resetPassword($adminID, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("UPDATE administrators SET password = ? WHERE adminID = ?");
        $stmt->bind_param("si", $hashedPassword, $adminID);
        if ($stmt->execute()) {
            return "Password reset successfully!";
        } else {
            return "Error resetting password: " . $this->conn->error;
        }
    }
}

?>