<?php
$__site_path = $_SERVER["DOCUMENT_ROOT"]."../demo_site.config.json";
$__site_config = file_get_contents($__site_path);
$__site_config = file_get_contents($__site_path);
function get_config($key)
{
    global $__site_config;
    $array = json_decode($__site_config, true);
    if (isset($array[$key])) //check whether the key is availble or not
        return $array["$key"]; //returns the value of the key
    else
        return false;
}
class database
{
    public static $conn = null;
    public static function connection()
    {
        $Server_name = get_config("db_host");
        $user = get_config("db_user");
        $password = get_config("db_password");
        $db_name = get_config("db_name");
        try {
            if (database::$conn != null)
                return database::$conn;
            else {
                $connection = new mysqli($Server_name, $user, $password, $db_name);
                if (!($connection->connect_error)) {
                    database::$conn = $connection;
                    return database::$conn;
                }
                throw new Exception("Connection error occured");
            }
        } catch (Exception $exp) {
            return false;
        }
    }
}
$conn = database::connection();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product Search - Vulnerable to SQL Injection</title>
</head>
<body>
    <h2>Search for a Product</h2>
    <form method="GET">
        Product Name: <input type="text" name="product_name">
        <input type="submit" value="Search">
    </form>

<?php
if (isset($_GET['product_name'])) {
    $product_name = $_GET['product_name'];

    // --- Vulnerable SQL Query: No input sanitization ---
    $sql = "SELECT * FROM products WHERE name = '$product_name'";
    echo "<p><strong>Executed Query:</strong> $sql</p>"; // For debugging/demo only

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<p><strong>Product:</strong> " . $row["name"] . " - " . $row["price"] . "</p>";
        }
    } else {
        echo "<p>No product found.</p>";
    }
}

$conn->close();
?>
</body>
</html>

<!--
Example of SQL Injection:
Enter the following in the form input:

    ' OR '1'='1

This transforms the SQL query to:

    SELECT * FROM products WHERE name = '' OR '1'='1'

This will return **all rows** from the products table regardless of the product name, demonstrating a SQL injection attack.

-->
