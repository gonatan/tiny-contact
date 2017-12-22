<?php

/**
 * Model
 *
 * Die SQLite3-Erweiterung ist in PHP 5.3.0 standardmäßig aktiviert.
 * http://php.net/manual/de/book.sqlite3.php
 *
 * @author magna
 */
class Model
{
    /**
     * @var Base $f3
     */
    protected $f3;

    /**
     * @var SQLite3 $db
     */
    protected $db;

    /**
     * @param Base $f3 F3 base object
     */
    public function __construct(Base $f3)
    {
        $this->f3 = $f3;
        $this->f3->logger->addDebug(__METHOD__, func_get_args());
        if (extension_loaded('sqlite')) {
            throw new Exception("SQLite is not available");
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
    public function open($filename)
    {
        if (!is_readable($filename)) {
            throw new Exception("$filename is not readable");
        }
        $this->db = new SQLite3($filename, SQLITE3_OPEN_READWRITE);
    }

    /**
     */
    public function close()
    {
        $this->f3->logger->addDebug(__METHOD__, func_get_args());
        $this->db->close();
        $this->db = null;
    }
}
