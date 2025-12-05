<?php
// config/database.php
/**
 * Database class - wrapper OOP untuk koneksi dan operasi dasar
 *
 * Methods:
 *  - __construct() : inisialisasi koneksi (mengambil config/config.php)
 *  - query($sql) : jalankan query mentah (mengembalikan mysqli_result atau false)
 *  - fetchAll($sql) : ambil semua baris sebagai array associative
 *  - fetch($sql) : ambil satu baris associative
 *  - insert($table, $data) : insert menggunakan array (mengembalikan inserted_id atau false)
 *  - update($table, $data, $where) : update menggunakan array
 *  - delete($table, $where) : delete
 *  - prepareAndExecute($sql, $types, $params) : helper for prepared statements
 *
 * Implementasi didasarkan pada contoh di Praktikum 10 namun diperbaiki agar aman.
 */

class Database {
    protected $conn;

    public function __construct()
    {
        // load config
        $cfg = [];
        include __DIR__ . '/config.php';
        if (!isset($config)) {
            throw new Exception("config not found");
        }

        $this->conn = new mysqli(
            $config['db_host'],
            $config['db_user'],
            $config['db_pass'],
            $config['db_name']
        );

        if ($this->conn->connect_error) {
            // Friendly dev message
            die("Connection failed: " . $this->conn->connect_error);
        }
        $this->conn->set_charset('utf8mb4');
    }

    // Jalankan query mentah
    public function query($sql)
    {
        return $this->conn->query($sql);
    }

    // Ambil semua baris (SELECT)
    public function fetchAll($sql)
    {
        $res = $this->query($sql);
        if (!$res) return false;
        $rows = [];
        while ($r = $res->fetch_assoc()) $rows[] = $r;
        return $rows;
    }

    // Ambil 1 baris
    public function fetch($sql)
    {
        $res = $this->query($sql);
        if (!$res) return false;
        return $res->fetch_assoc();
    }

    // Prepared + execute helper
    public function prepareAndExecute($sql, $types = '', $params = [])
    {
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        if ($types && !empty($params)) {
            // bind_param expects references
            $refs = [];
            foreach ($params as $k => $v) $refs[$k] = &$params[$k];
            array_unshift($refs, $types);
            call_user_func_array([$stmt, 'bind_param'], $refs);
        }
        if (!$stmt->execute()) {
            $stmt->close();
            return false;
        }
        $res = $stmt->get_result();
        // If query is SELECT, return result, else return stmt for last_id/affected_rows
        if ($res !== false) {
            $rows = [];
            while ($r = $res->fetch_assoc()) $rows[] = $r;
            $stmt->close();
            return $rows;
        } else {
            $ret = [
                'insert_id' => $this->conn->insert_id,
                'affected_rows' => $stmt->affected_rows
            ];
            $stmt->close();
            return $ret;
        }
    }

    // Insert (associative array)
    public function insert($table, $data)
    {
        $cols = array_keys($data);
        $placeholders = implode(',', array_fill(0, count($cols), '?'));
        $columns = implode(',', $cols);
        // types infer sederhana
        $types = '';
        $values = [];
        foreach ($data as $v) {
            if (is_int($v)) $types .= 'i';
            elseif (is_double($v) || is_float($v)) $types .= 'd';
            else $types .= 's';
            $values[] = $v;
        }
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $res = $this->prepareAndExecute($sql, $types, $values);
        if ($res === false) return false;
        return $this->conn->insert_id;
    }

    // Update (data = assoc array), $where = "id = 3" (string)
    public function update($table, $data, $where)
    {
        $sets = [];
        $types = '';
        $values = [];
        foreach ($data as $k => $v) {
            $sets[] = "{$k} = ?";
            if (is_int($v)) $types .= 'i';
            elseif (is_double($v) || is_float($v)) $types .= 'd';
            else $types .= 's';
            $values[] = $v;
        }
        $sql = "UPDATE {$table} SET " . implode(',', $sets) . " WHERE {$where}";
        $res = $this->prepareAndExecute($sql, $types, $values);
        if ($res === false) return false;
        return true;
    }

    // Delete
    public function delete($table, $where)
    {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $res = $this->query($sql);
        return ($res !== false);
    }

    // Close connection optional
    public function close()
    {
        $this->conn->close();
    }
}
