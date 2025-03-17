<?php

   if (!function_exists('send_mail')) {
    /**
     * Sends an email using the configured mail settings.
     *
     * This function checks the mail protocol configuration and adjusts SMTP settings accordingly 
     * before sending the email with the provided subject and message.
     *
     * @param string $to The recipient email address.
     * @param string $subject The subject of the email.
     * @param string $message The body content of the email.
     * @return bool Returns true if the email was sent successfully, false otherwise.
     */
      function send_mail(string $to, string $subject, string $message):bool {
         if (config('mail.protocol') == 'smtp') {
            ini_set('SMTP', config('mail.smtp_domain'));
            ini_set('smtp_port', config('mail.smtp_port'));
         }

         $headers = "MIME-Version: 1.0\r\n";
         $headers .= "Content-type: text/html;charset=UTF-8\r\n";
         $headers .= "From: ".config("mail.from_address")."\r\n";

         return mail($to, $subject, $message, $headers);
      }
   }

   // dd(send_mail(['rayan@example.com'], 'Hello from subject', '<h1>Hello From Body</h1>'));