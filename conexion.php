<?php
   function conectarse($nsrv) {
      $srvr=$nsrv;
      if($srvr == "bqa"){
         $serverName = "25.72.56.241,2016";
         $connectionInfo = array( "Database"=>"softrestaurant95pro", "UID"=>"sa", "PWD"=>"National09");  
         $conn = sqlsrv_connect( $serverName, $connectionInfo);
         if( $conn === false ){  
           echo "Could not connect a bqa\n\n";  
           die( print_r( sqlsrv_errors(), true));  
         }else{
            return $conn;
         }
      }else if($srvr == "upt"){
         $serverName = "25.90.57.214,2015";
         $connectionInfo = array( "Database"=>"softrestaurant95pro", "UID"=>"sa", "PWD"=>"National09");  
         $conn = sqlsrv_connect( $serverName, $connectionInfo);
         if( $conn === false ){  
           echo "Could not connect a upt\n\n";  
           die( print_r( sqlsrv_errors(), true));  
         }else{
            return $conn;
         }
      }else if($srvr == "ubk"){
         $serverName = "25.112.202.99, 2016";
         $connectionInfo = array( "Database"=>"softrestaurant95pro", "UID"=>"sa", "PWD"=>"National09");  
         $con = sqlsrv_connect( $serverName, $connectionInfo);
         if( $con === false ){  
           echo "Could not connect a ubk\n\n";  
           die( print_r( sqlsrv_errors(), true));  
         }else{
            return $con;
         }
      }else if($srvr == "cds"){
         $serverName = "25.102.99.218,1989";
         $connectionInfo = array( "Database"=>"softrestaurant95pro_cedis", "UID"=>"sa", "PWD"=>"National09");  
         $conn = sqlsrv_connect( $serverName, $connectionInfo);
         if( $conn === false ){  
           echo "Could not connect a bqa\n\n";  
           die( print_r( sqlsrv_errors(), true));  
         }else{
            return $conn;
         }
      }else if($srvr == "brubk"){
         $serverName = "25.2.1.215,2018";
         $connectionInfo = array( "Database"=>"softrestaurant95pro", "UID"=>"sa", "PWD"=>"National09");  
         $conn = sqlsrv_connect( $serverName, $connectionInfo);
         if( $conn === false ){  
           echo "Could not connect a bqa\n\n";  
           die( print_r( sqlsrv_errors(), true));  
         }else{
            return $conn;
         }
      }else if($srvr == "bralm"){
         $serverName = "25.35.255.103,2018";
         $connectionInfo = array( "Database"=>"softrestaurant95pro", "UID"=>"sa", "PWD"=>"National09");  
         $conn = sqlsrv_connect( $serverName, $connectionInfo);
         if( $conn === false ){  
           echo "Could not connect a bqa\n\n";  
           die( print_r( sqlsrv_errors(), true));  
         }else{
            return $conn;
         }
      }else if($srvr == "bk"){
         $serverName = "25.3.200.188,1989";
         $connectionInfo = array( "Database"=>"softrestaurant95pro", "UID"=>"sa", "PWD"=>"National09");  
         $conn = sqlsrv_connect( $serverName, $connectionInfo);
         if( $conn === false ){  
           echo "Could not connect a bqa\n\n";  
           die( print_r( sqlsrv_errors(), true));  
         }else{
            return $conn;
         }
      }         
   }
?>