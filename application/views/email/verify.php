<p>Hello <?php echo $user->name; ?>,</p>

<p>Your account has been created in Lockmasters, Please click on the link below to verify your account before using it:</p>

<a href="<?php echo base_url(); ?>user/verify/<?php echo $param?>">Verify Your Email</a>
 
<p>If you did not make this request or need assistance, please ignore this email.</p>