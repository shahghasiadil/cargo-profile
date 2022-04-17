<?php

define('TO_EMAIL', 'nevin609nevin@gmail.com');
define('FROM_EMAIL', $_POST['dzEmail']);
$MESSAGE = 'Hi Admin, <br/><br/>';
$MESSAGE .= 'You got an user query from CargoZone. User details and Message are noted bellow: <br/><br/>';
$MESSAGE .= 'Name : ' . $_POST['dzName'] . '<br/>';
$MESSAGE .= 'Email : ' . $_POST['dzEmail'] . '<br/>';


if (isset($_FILES['file'])) {

    //Get uploaded file data using $_FILES array
    $tmp_name = $_FILES['file']['tmp_name']; // get the temporary file name of the file on the server
    $name = $_FILES['file']['name']; // get the name of the file
    $size = $_FILES['file']['size']; // get size of the file for size validation
    $type = $_FILES['file']['type']; // get type of the file
    $error = $_FILES['file']['error']; // get the error (if any)

    //read from the uploaded file & base64_encode content
    $handle = fopen($tmp_name, "r"); // set the file handle only for reading the file
    $content = fread($handle, $size); // reading the file
    fclose($handle); // close upon completion

    $encoded_content = chunk_split(base64_encode($content));

    $boundary = md5("random"); // define boundary with a md5 hashed value

    //attachment
    $MESSAGE .= "--$boundary\r\n";
    $MESSAGE .= "Content-Type: $type; name=" . $name . "\r\n";
    $MESSAGE .= "Content-Disposition: attachment; filename=" . $name . "\r\n";
    $MESSAGE .= "Content-Transfer-Encoding: base64\r\n";
    $MESSAGE .= "X-Attachment-Id: " . rand(1000, 99999) . "\r\n\r\n";
    $MESSAGE .= $encoded_content; // Attaching the encoded file with email

} else {
    $MESSAGE .= 'Message : <br/>' . $form['dzMessage'] . '<br/><br/>';
    $MESSAGE .= 'Regards';
}

$HEADERS = "MIME-Version: 1.0" . "\r\n";
$HEADERS .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$HEADERS .= 'From: <' . FROM_EMAIL . '>' . "\r\n";

mail(TO_EMAIL,'Career Hiring' ,$MESSAGE, $HEADERS);
echo 1;
exit();
