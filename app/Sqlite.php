<?php

/**
 * Description of Sqlite
 *
 * @author magna
 */
class Sqlite implements DatabaseConnection
{
    /**
     * @var Base
     */
    protected $f3;

    /**
     * @var SQLite3
     */
    public $db;

    /**
     */
    public function __construct(Base $f3, $filename)
    {
        $f3->logger->addDebug(__METHOD__, func_get_args());
        $this->f3 = $f3;
        if (is_file($filename)) {
            $this->db = new SQLite3($filename, SQLITE3_OPEN_READWRITE);
        } else {
            $this->db = new SQLite3($filename, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
            $this->setup();
        }
    }

    /**
     */
    public function __destruct()
    {
        $this->f3->logger->addDebug(__METHOD__, func_get_args());
        $this->close();
    }

    /**
     */
    public function close()
    {
        $this->f3->logger->addDebug(__METHOD__, func_get_args());
        $this->db->close();
        $this->db = null;
    }

    /**
     */
    public function setup()
    {
        $this->f3->logger->addDebug(__METHOD__, func_get_args());
        $query = "CREATE TABLE `contact` (
            `id`	INTEGER,
            `lastname`	TEXT,
            `firstname`	TEXT,
            `email`	TEXT,
            `phone`	TEXT,
            `mobile`	TEXT,
            `street`	TEXT,
            `city`	TEXT,
            `zip`	TEXT,
            PRIMARY KEY(`id`)
        );";
        $this->db->exec($query);
    }
}
