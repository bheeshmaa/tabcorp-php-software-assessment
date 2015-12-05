<?php
// Question 1a

$DB_HOST = 'localhost';
$DB_NAME = 'test';
$DB_USER = 'test';
$DB_PASS = 'test';

// write your sql to get customer_data here
/**
 * Establishing a database connection
 * @params string database connection parameters
 * @return string databace connection intance
 */
$link = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);

/**
 * Selecting a database if MySQL connected
 */
if($link) {
    $db_selected = mysql_select_db($DB_NAME,$link);
}
else {
    die ("Error: Could not connect to MySQL - ".$DB_HOST);
}

/**
 * Query to get all customers and their occupation.
 */
$sql = "SELECT `customer`.*,`customer_occupation`.`occupation_name`"
        . " FROM `customer` LEFT JOIN `customer_occupation`"
        . " ON `customer`.`customer_occupation_id`=`customer_occupation`.`customer_occupation_id`"
        . " ORDER BY `customer`.`first_name`,`customer`.`last_name`";
$result = mysql_query($sql);

?>

<h2>Customer List</h2>
<?php if(!isset($_GET['occupation_name'])) { ?>
    <table>
            <tr>
                    <th>Customer ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Occupation</th>
            </tr>
            <?php
            while ($customer_data = mysql_fetch_assoc($result)) {
                echo "<tr>";
                    echo "<td>".$customer_data['customer_id']."</td>";
                    echo "<td>".$customer_data['first_name']."</td>";
                    echo "<td>".$customer_data['last_name']."</td>";
                    echo "<td>".$customer_data['occupation_name']."</td>";
                    if($data['occupation_name']!= " ") {
                        echo "<td>".$data['occupation_name']."</td>";
                    }
                    else {
                        echo "<td>un-employed</td>";
                    }
                echo "</tr>";
            }
            ?>

    </table>
<?php
} else { 
?>
<?php
/**
 * Access get query string is set
 * @param string $_GET occupation name query string
 */
    if(isset($_GET['occupation_name'])) {
        echo "Search Results for occupation name: '".$_GET['occupation_name']."'<br/><br/>";
        $sql_occupation_search = "SELECT `customer`.*,`customer_occupation`.`occupation_name`"
        . " FROM `customer` LEFT JOIN `customer_occupation`"
        . " ON `customer`.`customer_occupation_id`=`customer_occupation`.`customer_occupation_id`"
        . " WHERE `customer_occupation`.`occupation_name` LIKE '%".$_GET['occupation_name']."%'" 
        . " ORDER BY `customer`.`first_name`,`customer`.`last_name`";
        
        $result = mysql_query($sql_occupation_search);       
    }
    ?>

    <table>
            <tr>
                    <th>Customer ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Occupation</th>
            </tr>
            <?php
            while ($customer_data = mysql_fetch_assoc($result)) {
                echo "<tr>";
                    echo "<td>".$customer_data['customer_id']."</td>";
                    echo "<td>".$customer_data['first_name']."</td>";
                    echo "<td>".$customer_data['last_name']."</td>";
                    echo "<td>".$customer_data['occupation_name']."</td>";                    
                echo "</tr>";
            }
            ?>

    </table>
<?php
}
?>
<br/>
<form action="" method="GET">
    Search customers by occupation: <input type="text" name="occupation_name" size="25" id="occupation_name" value="">
    <input type="submit" name="search" value="search">
</form>
