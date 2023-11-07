<?php

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../')->load();

 // honeypot
if (isset($_POST['checkbox'])) {
  die();
}

// sanitise inputs
function sanitize($data){
  $data = htmlspecialchars($data);
  $data = strip_tags($data);
  $data = trim($data);
  return $data;
}

// send email if no errors
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = sanitize($_POST["name"]);
  $lastname = sanitize($_POST["lastname"]);
  $gender = $_POST["gender"];
  $email = sanitize($_POST["email"]);
  $country = sanitize($_POST["country"]);
  $subject = $_POST["subject"];
  $message = $_POST["message"];

  // Validate form data
  $errors = array();
  if (strlen($name) < 2 && strlen($name) > 50 ) {
    $errors[] = 'Name invalid';
  }
  if (strlen($lastname) < 2 && strlen($lastname) > 50) {
    $errors[] = 'Lastname invalid';
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) > 50 && strlen($email) < 2) {
    $errors[] = 'Email invalid';
  }
  if (strlen($country) < 2 && strlen($country) > 50) {
    $errors[] = 'Country invalid';
  }

  // If there are no errors, send the email
  if (empty($errors)) {
    
    try {
        //Server settings
        $mail = new PHPMailer();
        $mail->SMTPSecure = 'tls';
        $mail->Username = $_ENV["user"];
        $mail->Password = $_ENV["password"];
        $mail->AddAddress($email);
        $mail->FromName = "My Name";
        $mail->Subject = "My Subject";
        $mail->Body = $name . ", " .$lastname. ", " .$gender. ", " .$email. ", " .$country. ", " .$subject. ", " .$message;
        $mail->Host = "smtp-mail.outlook.com";
        $mail->Port = 587;
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->From = $mail->Username;
        $mail->Send();
    
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  
}
}



?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link href="/dist/output.css" rel="stylesheet">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Bellota&display=swap');
    </style>
    <title>Hackers Poulette</title>
</head>
<body class="font-julius bg-white text-black">

    <div class="flex justify-center w-45 h-auto"> <img src="../assets/storage/hackers-poulette-logo.png" alt="hackers poulette logo" class="object-fill"></div>

    <div class="flex justify-center">
      <h1 class="font-semibold text-3xl m-5"> Contact Form </h1>
    </div>

    <form class="flex flex-col justify-center items-center" method="post" action="">

      <div class="flex flex-col justify-start my-1">
        <label for="name">Name:</label>
        <!-- <input type="text" id="name" class="bg-blue w-80 rounded-2xl px-3" name="name" placeholder="Name" value="Name" required> -->
        <?php
        if (isset($_POST["name"])){
          echo ("<input type='text' id='name' class='bg-blue w-80 rounded-2xl px-3' name='name' placeholder='Name' required>");
        }
        else{
            echo ("<input type='text' id='name' class='bg-blue w-80 rounded-2xl px-3' name='name' placeholder='Name' value='Name' required>");
        }

        if (isset($_POST['name'])) {
          $name = $_POST['name'];
          if (strlen($name) < 2) {
            echo "<p class='text-red-500 whitespace-pre-line'>Must be at least 2 characters long</p>";
          }
        }

        if (isset($_POST['name'])) {
          $name = $_POST['name'];
          if (strlen($name) > 50) {
            echo "<p class='text-red-500 whitespace-pre-line'>Can't be more than 50 characters long</p>";
          }
        }
        ?>
      </div>

      <div class="flex flex-col justify-start my-1">
        <label for="name">Lastname:</label>
        <!-- <input type="text" id="lastname" class="bg-blue w-80 rounded-2xl px-3" name="lastname" placeholder="Lastname" value="Lastname" required> -->
      <?php
        if (isset($_POST["name"])){
          echo ("<input type='text' id='lastname' class='bg-blue w-80 rounded-2xl px-3' name='lastname' placeholder='Lastname' required>");
        }
        else{
            echo ("<input type='text' id='lastname' class='bg-blue w-80 rounded-2xl px-3' name='lastname' placeholder='Lastname' value='Lastname' required>");
        }

        if (isset($_POST['lastname'])) {
          $lastname = $_POST['lastname'];
          if (strlen($lastname) < 2) {
            echo "<p class='text-red-500 whitespace-pre-line'>Must be at least 2 characters long</p>";
          }
        }

        if (isset($_POST['lastname'])) {
          $lastname = $_POST['lastname'];
          if (strlen($lastname) > 50) {
            echo "<p class='text-red-500 whitespace-pre-line'>Can't be more than 50 characters long</p>";
          }
        }
      ?>
      </div>
    
      <div class="flex flex-col justify-start my-1">
        <label for="gender">Gender:</label>
        <select id="gender" class="bg-blue w-80 rounded-2xl px-3" name="gender" required>
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
      </div>
    
      <div class="flex flex-col justify-start my-1">
        <label for="email">Email:</label>
        <!-- <input type="email" id="email" class="bg-blue w-80 rounded-2xl px-3" name="email" placeholder="example@gmail.com" value="elodieali.pro@gmail.com" required> -->
        <?php
          if (isset($_POST["email"])){
            echo ("<input type='email' id='email' class='bg-blue w-80 rounded-2xl px-3' name='email' placeholder='example@gmail.com' required>");
          }
          else{
              echo ("<input type='email' id='email' class='bg-blue w-80 rounded-2xl px-3' name='email' placeholder='example@gmail.com' value='elodieali.pro@gmail.com' required>");
          }

          if (isset($_POST['email'])) {
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              echo '<p class="text-red-500 whitespace-pre-line">Invalid email format</p>';
            }
          }

          if (isset($_POST['email'])) {
            $email = $_POST['email'];
            if (strlen($email) > 50) {
              echo "<p class='text-red-500 whitespace-pre-line'>Can't be more than 50 characters long</p>";
            }
          }
        ?>
      </div>
    
     <div class="flex flex-col justify-start my-1">
        <label for="country">Country:</label>
        <!-- <input type="text" id="country" class="bg-blue w-80 rounded-2xl px-3" name="country" placeholder="Country" value="Belgium" required> -->
        <?php
        if (isset($_POST["email"])){
          echo ("<input type='text' id='country' class='bg-blue w-80 rounded-2xl px-3' name='country' placeholder='Country' required>");
        }
        else{
            echo ("<input type='text' id='country' class='bg-blue w-80 rounded-2xl px-3' name='country' placeholder='Country' value='Belgium' required>");
        }

          if (isset($_POST['country'])) {
            $country = $_POST['country'];
            if (strlen($country) < 2) {
              echo '<p class="text-red-500 whitespace-pre-line">Must be at least 2 characters long</p>';
            }
          }

          if (isset($_POST['country'])) {
            $country = $_POST['country'];
            if (strlen($country) > 50) {
              echo "<p class='text-red-500 whitespace-pre-line'>Can't be more than 50 characters long</p>";
            }
          }
        ?>
     </div>
    
      <div class="flex flex-col justify-start my-1">
        <label for="subject">Subject:</label>
        <select id="subject" class="bg-blue w-80 rounded-2xl px-3" name="subject" required>
          <option value="sales">Sales</option>
          <option value="support">Support</option>
          <option value="other" selected="selected">Other</option>
        </select>
      </div>
    
      <div class="flex flex-col justify-start my-1">
        <label for="message">Message:</label>
        <!-- <textarea id="message" class="bg-blue w-80 rounded-2xl px-3" name="message" rows="5" placeholder="Type here your message">Type here your message</textarea> -->
        <?php
        if (isset($_POST["email"])){
          echo ("<textarea id='message' class='bg-blue w-80 rounded-2xl px-3' name='message' rows='3' placeholder='Type here your message'></textarea>");
        }
        else{
            echo ("<textarea id='message' class='bg-blue w-80 rounded-2xl px-3' name='message' rows='3' placeholder='Type here your message'>Type here your message</textarea>");
        }
        ?>
      </div>
    
      <div class="opacity-0">
        <input type="checkbox" id="checkbox" name="checkbox" value="checkbox">
      </div>

      <input type="submit" value="Submit" class="bg-blue px-5 py-2 font-semibold rounded-2xl cursor-pointer">
    </form>
</body>
</html>
