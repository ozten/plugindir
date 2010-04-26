From: changeme@gmail.com
Subject: Confirm email address change for <?php echo $login_name?>?

Someone (possibly you) has triggered an attempt to change the email address for 
a login named "<?=$login_name?>".  If you are that someone, follow this link to 
complete the process:

<?= 
url::full('verifyemail', false, array(
    'email_verification_token' => $email_verification_token
))
?>
