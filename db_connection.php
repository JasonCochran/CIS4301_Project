<?php

/**
 * Created by PhpStorm.
 * User: JasonCochran
 * Date: 4/2/17
 * Time: 11:11 PM
 */
class db_connection
{
    public $connection;
    private $statement;

    public function __construct() {
        $this->connection = oci_connect($username = 'oracleusername',
            $password = 'oraclepassword',
            $connection_string = '//oracle.cise.ufl.edu/orcl');
    }

    public function runQuery($statement) {
        $this -> statement = oci_parse($connection, "SELECT * FROM flights WHERE ORIGINAIRPORT='MCO' ");
        oci_execute($statement);
    }

    public function getResults() {

    }

    public function __destruct()
    {
        oci_free_statement($statement);
        oci_close($connection);
    }

}