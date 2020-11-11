<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
        include "/home/zablotskyi/www/ism.local/config/config.php";
        
        $result = $db_connection->query('SELECT * FROM Ism.products');

        while( $phones = $result->fetch(PDO::FETCH_ASSOC) ){
            
            echo ' ID: ' . $phones['Id'] . ', SKU: ' . $phones['SKU'] . ', Phone: ' . $phones['Name'] 
                    . ', price: ' . $phones['Price'] . ' , description: ' . $phones['Description'] . '<br>';
        }
        ?>
        
        <div class="image">
            <img src="media/images/iphone5.jpg" width="400px", alt=""> 
            <img src="media/images/iphone6.jpg" width="400px", alt="">
            <img src="media/images/iphone7.jpg" width="400px", alt="">
            <img src="media/images/iphone8.jpg" width="400px", alt="">
            <img src="media/images/iphoneX.jpg" width="400px", alt="">
         </div>   

    </body>
</html>

