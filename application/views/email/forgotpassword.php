<p>Hello <?php echo $user->name; ?>,</p>

<p>We received a request to reset your password. Click the link below to choose a new one:</p>

<a href="<?php echo base_url(); ?>user/resetpassword/<?php echo $param?>">Reset Your Password</a>
 
<p>If you did not make this request or need assistance, please ignore this email.</p>