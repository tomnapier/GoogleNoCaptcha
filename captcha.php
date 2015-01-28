<?php 

        //verify captcha
        $recaptcha_secret = "";
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
        $response = json_decode($response, true);
        if($response["success"] === true)
        {

            //create array of data to be posted
            $fields = array(
                'name' => urlencode($_POST['name']),
            );

            //traverse array and prepare data for posting (key1=value1)
            foreach($fields as $key=>$value) { $fields_string  .= $key.'='.$value.'&'; };
            rtrim($fields,'&');


            //create cURL connection
            $curl_connection = curl_init('http://www.domainname.com/target_url.php');

            //set options
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);

            //set data to be posted
            curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $fields);

            //perform our request
            $result = curl_exec($curl_connection);

            //show information regarding the request
            print_r($fields);
            print_r(curl_getinfo($curl_connection));
            echo curl_errno($curl_connection) . '-' . curl_error($curl_connection);

            //close the connection
            curl_close($curl_connection);
 
        }
        else
        {
            echo "You are a robot";
        }

?>
