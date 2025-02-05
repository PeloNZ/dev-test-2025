<?php
// Write a SQL command to retrieve the top five products with the highest sales from a tabl
//
//named "sales."

// php pdo nice and easy,
$pdo = new PDO(
    'sqlite:./impactlab.sqlite'
);

// create the sales table
//
$sql = '
create table sales
(
    id           integer not null
        constraint sales_pk
            primary key autoincrement,
    amount       integer not null,
    quantity     integer not null,
    product_name TEXT    not null,
    product_id   integer not null
);
';

$pdo->exec($sql);

// make up some products
$products = [];
$salesCount = 100;
$inserted = 0;

while ($inserted < $salesCount) {
// make some sales $$$$
    $amount = random_int(1, 1000);
    $quantity = random_int(1, 1000);
    $productName = 'widget ' . substr(str_shuffle('abcdfghjklmnpqrstvwzyz'), 0, 3);
    $productId = random_int(1, 10);
    $sql = sprintf(
        "INSERT INTO sales (amount, quantity, product_name, product_id) VALUES (
        %s,%s,\"%s\",%s);",
        $amount,
        $quantity,
        $productName,
        $productId
    );

//    echo $sql;
    $pdo->exec($sql);

    $inserted++;
}

//$rows = $pdo->exec('SELECT * FROM sales');

// now fetch the sales data we want...
echo "top 5 selling widgets:\r\n";

$sql = 'SELECT product_id, product_name, SUM(amount) AS total_sales
FROM sales
GROUP BY product_id, product_name
ORDER BY total_sales DESC
LIMIT 5';

// expected output looks like this
// top 5 selling widgets:
//Product ID | Name | Sales
//3       widget fsk      980
//10      widget ldy      972
//4       widget frz      971
//1       widget wzq      969
//6       widget gsw      962

echo "Product ID | Name | Sales \r\n";
foreach ($pdo->query($sql) as $row) {
    print $row['product_id'] . "\t";
    print $row['product_name']. "\t";
    print $row['total_sales']. "\n";
}
