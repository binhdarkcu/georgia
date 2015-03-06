<?php
    session_start();
    if(isset($_SESSION['user'])){
        $link = get_site_url().'/users';
        echo "<script>window.location.href = '$link'</script>";
    }
    $logged = false;
    $message = "";
    if(isset($_POST['email']))
    {
        global $wpdb;
        $email = $_POST['email'];
        $password = sha1($_POST['password']);
        
        $results = $wpdb->get_row("SELECT * FROM profile WHERE email = '$email' and password = '$password'");
        if($results){
            $data = array();
            foreach ($results as $key => $value) {
                $data[$key] = $value;
            }
            $logged = true;
            $message = "Login success";
            unset($data['password']);
            $_SESSION['user'] = $data;
            $link = get_site_url().'/users';
            echo "<script>setTimeout(function(){window.location.href = '$link';},1000);</script>";
        }
        else{
            $message = "Login failed";
        }
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
          <h2>Login</h2>
        </div>
        <form id="loginForm" method="post" class="form-horizontal" action="">
        <?php
            if($message != "")
            {
                $alert = $logged == true ? "alert-success" : "alert-danger";
                echo '<div class="alert '.$alert.'">'.$message.'</div>';
            }
        ?>
          <div class="alert alert-success" style="display: none;"></div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Email</label>
            <div class="col-lg-5">
              <input type="text" class="form-control" name="email" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Password</label>
            <div class="col-lg-5">
              <input type="password" class="form-control" name="password" />
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-9 col-lg-offset-3">
              <button type="submit" class="btn btn-primary">Login</button>
            </div>
          </div>
        </form>
      </div>
    </section>
    <!-- :form --> 
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#loginForm").validate({
    		rules: {
                'email': { 
                    required: true, 
                    email: true,
                },
                'password': { 
                    required: true, 
                    minlength: 6, 
                }
    		},
    		submitHandler: function(form) {
                form.submit();
    		},
    	});
    });
</script>
</body></html>