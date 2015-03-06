<?php
    session_start();
    if(!isset($_SESSION['user'])){
        $link = get_site_url().'/users/login';
        echo "<script>window.location.href = '$link'</script>";
    }
    else{
        $data = $_SESSION['user'];
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php the_title() ?></title>
	<base href="<?php echo get_template_directory_uri() ?>/" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css"/>
    <script type="text/javascript" src="vendor/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <style>input.error{border:1px solid red} label.error{color:red; font-weight: normal;}</style>
</head>


<div class="container">
  <div class="row"> 
    <!-- form: -->
    <section>
      <div class="col-lg-8 col-lg-offset-2">
        <div class="page-header">
          <h2>Users</h2>
          <a href="<?php echo get_site_url().'/users/edit' ?>">Edit</a>
        </div>
        <div class="col-lg-9">
            <label class="col-lg-3 control-label">First name</label>
            <div class="col-lg-5"><?php echo $data['first_name'] ?></div>
        </div>
        <div class="col-lg-9">
            <label class="col-lg-3 control-label">Last name</label>
            <div class="col-lg-5"><?php echo $data['last_name'] ?></div>
        </div>
        <div class="col-lg-9">
            <label class="col-lg-3 control-label">Email</label>
            <div class="col-lg-5"><?php echo $data['email'] ?></div>
        </div>
        <div class="col-lg-9">
            <label class="col-lg-3 control-label">Password</label>
            <div class="col-lg-5"><a href="<?php echo get_site_url().'/users/change-password' ?>">Change password</a></div>
        </div>
        <div class="col-lg-9">
            <label class="col-lg-3 control-label">Company</label>
            <div class="col-lg-5"><?php echo $data['company'] ?></div>
        </div>
        <div class="col-lg-9">
            <label class="col-lg-3 control-label">Street</label>
            <div class="col-lg-5"><?php echo $data['street'] ?></div>
        </div>
        <div class="col-lg-9">
            <label class="col-lg-3 control-label">Nr</label>
            <div class="col-lg-5"><?php echo $data['nr'] ?></div>
        </div>
        <div class="col-lg-9">
            <label class="col-lg-3 control-label">City</label>
            <div class="col-lg-5"><?php echo $data['city'] ?></div>
        </div>
        <div class="col-lg-9">
            <label class="col-lg-3 control-label">Postal code</label>
            <div class="col-lg-5"><?php echo $data['postal_code'] ?></div>
        </div>
        <div class="col-lg-9">
            <label class="col-lg-3 control-label">Phone number</label>
            <div class="col-lg-5"><?php echo $data['phone_number'] ?></div>
        </div>
      </div>
    </section>
    <!-- :form --> 
  </div>
</div>
</body></html>