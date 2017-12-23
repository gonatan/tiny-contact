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
     * @var Base
     */
    protected $f3;

    /**
     * @var DatabaseConnection
     */
    protected $conn;

    /**
     * @param Base $f3 F3 base object
     * @param DatabaseConnection $conn
     */
    public function __construct(Base $f3, DatabaseConnection $conn)
    {
        $this->f3 = $f3;
        $this->f3->logger->addDebug(__METHOD__, func_get_args());
        if (extension_loaded('sqlite')) {
            throw new Exception("SQLite is not available");
        }
        $this->conn = $conn;
    }
}
