<?php

header('Content-Type: application/json');

$conn = mysqli_connect("127.0.0.1","root","","printing");

// Check connection
if (mysqli_connect_errno($conn))
{
    echo "Failed to connect to DataBase: " . mysqli_connect_error();
}else
{
    $data_points = array();
    
    $result = mysqli_query($conn, "SELECT transaction.itemNo, item.item_name, SUM(transaction.deduct_quantity) as deduct_quantity FROM item JOIN transaction ON item.itemNo = transaction.itemNo GROUP BY transaction.itemNo");

    while($row = mysqli_fetch_array($result))
    {        
        $point = array("label" => $row['item_name'] , "y" => $row['deduct_quantity']);
        
        array_push($data_points, $point);        
    }
    
    echo json_encode($data_points, JSON_NUMERIC_CHECK);
}
mysqli_close($conn);

?>