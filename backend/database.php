<?php

class Database {
    private $servername = "";
    private $username = "";
    private $password = "";
    private $dbname = "";
    private $mysqli;
    private $result = [];

    public function __construct() {
        $this->mysqli = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }
    }

    public function insert($table, $params = []) {
        if ($this->tableExists($table)) {
            $table_columns = implode(', ', array_keys($params));
            $table_values = implode("', '", $params);

            $sql = "INSERT INTO $table ($table_columns) VALUES ('$table_values')";

            if ($this->mysqli->query($sql)) {
                $this->result = $this->mysqli->insert_id;
                return true;
            } else {
                $this->result = $this->mysqli->error;
                return false;
            }
        }
        return false;
    }

    public function getResult() {
        $val = $this->result;
        $this->result = [];
        return $val;
    }

    public function select($table, $columns = "*", $where = null, $join = null, $order = null, $limit = null) {
        if ($this->tableExists($table)) {
            $sql = "SELECT $columns FROM $table";

            if ($join != null) {
                $sql .= " $join";
            }

            if ($where != null) {
                $sql .= " WHERE $where";
            }

            if ($order != null) {
                $sql .= " ORDER BY $order";
            }

            if ($limit != null) {
                $sql .= " LIMIT $limit";
            }

            $query = $this->mysqli->query($sql);
            if ($query) {
                $this->result = $query->fetch_all(MYSQLI_ASSOC);
                return true;
            } else {
                $this->result = $this->mysqli->error;
                return false;
            }
        }
        return false;
    }

    public function update($table, $params = [], $where = null) {
        if ($this->tableExists($table)) {
            $set = [];
            foreach ($params as $key => $value) {
                $set[] = "$key = '$value'";
            }
            $sql = "UPDATE $table SET " . implode(', ', $set);

            if ($where != null) {
                $sql .= " WHERE $where";
            }

            if ($this->mysqli->query($sql)) {
                $this->result = $this->mysqli->affected_rows;
                return true;
            } else {
                $this->result = $this->mysqli->error;
                return false;
            }
        }
        return false;
    }

    public function delete($table, $where = null) {
        if ($this->tableExists($table)) {
            $sql = "DELETE FROM $table";
            if ($where != null) {
                $sql .= " WHERE $where";
            }

            if ($this->mysqli->query($sql)) {
                $this->result = $this->mysqli->affected_rows;
                return true;
            } else {
                $this->result = $this->mysqli->error;
                return false;
            }
        }
        return false;
    }

    private function tableExists($table) {
        $sql = "SHOW TABLES FROM $this->dbname LIKE '$table'";
        $tableExists = $this->mysqli->query($sql);
        if ($tableExists && $tableExists->num_rows == 1) {
            return true;
        } else {
            $this->result = "$table doesn't exist";
            return false;
        }
    }

    public function __destruct() {
        $this->mysqli->close();
    }
}

?>
