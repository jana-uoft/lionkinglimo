<?php header('Access-Control-Allow-Origin: *'); ?>


<?php
        $name = $_POST["contact_name"];
        $email = $_POST["contact_email"];
        $message = $_POST["contact_message"];

        $mail = "Name: $name\nEmail: $email\nMessage: $message";
        return mail("jana.stc@gmail.com", $name. " via Personal Website", $mail);

    	exit;
?>