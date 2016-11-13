<?php header('Access-Control-Allow-Origin: *'); ?>


<?php

        $name = $_POST["contact_name"];
        $email = $_POST["contact_email"];
        $message = $_POST["contact_message"];

        $mail = "Name: $name\nEmail: $email\nMessage: $message";
        $headers = 'From: jana.stc@gmail.com' . "\r\n" .'Reply-To: ' . $email;
        return mail("jana.stc@gmail.com", $name. " via Personal Website", $mail, $headers);

    	exit;
?>