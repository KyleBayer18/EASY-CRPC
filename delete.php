<?php
include "./header.php";

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(isset($_GET["id"])){
        $hash = $_GET["id"];
        
        $conn = db_connect();
        
        $sql = "SELECT * FROM users WHERE hash = '$hash'";
        
        $results = pg_query($conn, $sql);
        
        while($row = pg_fetch_assoc($results)){
            $email = $row["email"];
            
            $sql1 = "DELETE FROM users WHERE email = '$email'";
            $sql2 = "DELETE FROM measurements WHERE email = '$email'";
            $sql3 = "DELETE FROM week1 WHERE email = '$email'";
            $sql4 = "DELETE FROM week2 WHERE email = '$email'";
            
            $results = pg_query($conn, $sql1);
            $results = pg_query($conn, $sql2);
            $results = pg_query($conn, $sql3);
            $results = pg_query($conn, $sql4);
            
       
            $_SESSION["ERROR"] = "Your account has been deleted!";
            header("location:./logout.php");
            
        }
    }else{
        header("location:./index.php");
    }
}

?>