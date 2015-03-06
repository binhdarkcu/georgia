<?php   
    session_start();
    if(!isset($_SESSION['user'])){
        $link = get_site_url().'/users/login';
        echo "<script>window.location.href = '$link';</script>";
    }
    else{
        $data = $_SESSION['user'];
    }
    
    $changed = false;
    $message = "";
    if(isset($_POST['old-password']))
    {
        global $wpdb;
        $old_password = sha1($_POST['old-password']);
        $new_password = sha1($_POST['new-password']);
        
        
        $results = $wpdb->get_row("SELECT * FROM profile WHERE email = '{$data['email']}' and password = '$old_password'");
        if(!empty($results)){
            $data['password'] = $new_password;
            $data['modified'] = date('Y-m-d h:i:s');
            $results = $wpdb->update('profile', $data, array('id' => $data['id']));
            
            $changed = true;
            $message = "Change password success";
            $link = get_site_url().'/users';
            echo "<script>setTimeout(function(){window.location.href = '$link';},1000);</script>";
        }
        else{
            $message = "Change password failed";
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
          <h2>Change password</h2>
        </div>
        <form id="changePassForm" method="post" class="form-horizontal" action="">
        <?php
            if($message != "")
            {
                $alert = $changed == true ? "alert-success" : "alert-danger";
                echo '<div class="alert '.$alert.'">'.$message.'</div>';
            }
        ?>
          <div class="alert alert-success" style="display: none;"></div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Old password</label>
            <div class="col-lg-5">
              <input type="password" class="form-control" name="old-password" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">New password</label>
            <div class="col-lg-5">
              <input type="password" class="form-control" id="new-password" name="new-password" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Re-Enter password</label>
            <div class="col-lg-5">
              <input type="password" class="form-control" name="re-new-password" />
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-9 col-lg-offset-3">
              <button type="submit" class="btn btn-primary">Update</button>
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
        $("#changePassForm").validate({
    		rules: {
                'old-password': { 
                    required: true, 
                    minlength: 6, 
                },
                'new-password': { 
                    required: true, 
                    minlength: 6, 
                },
                're-new-password': { 
                    required: true, 
                    equalTo: "#new-password"  
                }
    		},
    		submitHandler: function(form) {
                form.submit();
    		},
    	});
    });
</script>
</body></html>