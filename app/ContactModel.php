<?php

/**
 * Model
 *
 * Die SQLite3-Erweiterung ist in PHP 5.3.0 standardmäßig aktiviert.
 * http://php.net/manual/de/book.sqlite3.php
 *
 * @author magna
 */
class ContactModel extends Model
{
    /**
     * @param Base $f3 F3 base object
     * @param DatabaseConnection $database
     */
    public function __construct(Base $f3, DatabaseConnection $database)
    {
        parent::__construct($f3, $database);
    }

    /**
     */
    public function build()
    {
        return [
            'id' => 0,
            'lastname' => '',
            'firstname' => '',
            'email' => '',
            'phone' => '',
            'mobile' => '',
            'street' => '',
            'city' => '',
            'zip' => '',
        ];
    }

    /**
     * @param array $row
     * @return bool
     */
    public function insert(array $row)
    {
        $this->f3->logger->addDebug(__METHOD__, func_get_args());
        $keys = [];
        $values = [];
        unset($row['id']);
        foreach ($row as $key => $value) {
            $keys[] = "`$key`";
            $values[] = "\"$value\"";
        }
        $keys = implode(', ', $keys);
        $values = implode(', ', $values);
        $query = "insert into adressen ($keys) values ($values)";
        $this->f3->logger->addDebug($query);
        return $this->db->exec($query);
    }

    /**
     * @param array $row
     * @return bool
     */
    public function update(array $row)
    {
        $this->f3->logger->addDebug(__METHOD__, func_get_args());
        $set = [];
        foreach ($row as $key => $value) {
            $set[] = "`$key` = \"$value\"";
        }
        $set = implode(', ', $set);
        $id = $row['id'];
        $query = "update adressen set $set where id = $id";
        return $this->db->exec($query);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $this->f3->logger->addDebug(__METHOD__, func_get_args());
        $query = "delete from adressen where id = $id";
        return $this->db->exec($query);
    }

    /**
     *
     * @return array
     */
    public function findAll()
    {
        $this->f3->logger->addDebug(__METHOD__, func_get_args());
        $query = 'select * from adressen order by lastname';
        $result = $this->db->query($query);
        $rows = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * @param array $filter
     * @return array
     */
    public function findByFilter(array $filter)
    {
        $this->f3->logger->addDebug(__METHOD__, func_get_args());
        // not yet implemented
        return $this->findAll();
    }

    /**
     * @param int $id
     * @return array
     */
    public function findById($id)
    {
        $this->f3->logger->addDebug(__METHOD__, func_get_args());
        $query = "select * from adressen where id = $id";
        return $this->db->querySingle($query, true);
    }
}
