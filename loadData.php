<?php

if (isset($_POST['queryData'])) {

    $connection = oci_connect($username = 'username',
        $password = 'password',
        $connection_string = '//oracle.cise.ufl.edu/orcl');

    $statement = oci_parse($connection, " SELECT * FROM Country WHERE LIKE '%a' ");
    oci_execute($statement);

    echo "
    <table border=1>
    <tr>
    <th>CITYLAT</th>
    <th>CITYLON</th>
    </tr>";

// get data from table and format it on the table
    while (($row = oci_fetch_object($statement))) {
        echo "<tr>";
        echo "<td>" . $row->CITYLAT . "</td>";
        echo "<td>" . $row->CITYLON . "</td>";
        echo "</tr>";
    }

// finish table
    echo "</table>";

// close Oracle database connection and free statements
    oci_free_statement($statement);
    oci_close($connection);

}
?>