<?php
    //VALIDATE EMAIL
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
    {
        $email = $_POST['email'];
        $results = $wpdb->get_row("SELECT * FROM profile WHERE email = '$email'");
        if(!empty($results)){
            echo 'false';
            exit;
        }
        else{
            echo 'true';
            exit;
        }
    }

    session_start();
    if(isset($_SESSION['user'])){
        $link = get_site_url().'/users';
        echo "<script>window.location.href = '$link';</script>";
    }
    $logged = false;
    $message = "";
    if(isset($_POST['email']))
    {
        global $wpdb;
        $data['first_name'] = $_POST['first_name'];
        $data['last_name'] = $_POST['last_name'];
        $data['email'] = $_POST['email'];
        $data['password'] = sha1($_POST['password']);
        $data['company'] = $_POST['company'];
        $data['street'] = $_POST['street'];
        $data['nr'] = $_POST['nr'];
        $data['city'] = $_POST['city'];
        $data['postal_code'] = $_POST['postal_code'];
        $data['phone_number'] = $_POST['phone_number'];
        $data['created'] = date('Y-m-d h:i:s');
        $data['modified'] = date('Y-m-d h:i:s');
        
        $results = $wpdb->insert('profile', $data);
        if($results){
            $logged = true;
            $message = "Register success";
            unset($data['password']);
            $_SESSION['user'] = $data;
            $link = get_site_url().'/users';
            echo "<script>setTimeout(function(){window.location.href = '$link';},1000);</script>";
        }
        else{
            $message = "Register failed";
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
<body>
    <div class="container">
        <div class="row">
            <!-- form: -->
            <section>
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="page-header">
                        <h2>Sign up</h2>
                    </div>

                    <form id="registerForm" method="post" class="form-horizontal" action="">
                        <?php
                            if($message != "")
                            {
                                $alert = $logged == true ? "alert-success" : "alert-danger";
                                echo '<div class="alert '.$alert.'">'.$message.'</div>';
                            }
                                
                        ?>                       
                        <div class="form-group">
                            <label class="col-lg-3 control-label">First name</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="first_name" placeholder="First name" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Last name</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="last_name" placeholder="Last name" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" id="email" name="email" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Password</label>
                            <div class="col-lg-5">
                                <input type="password" class="form-control" id="password" name="password" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Re-enter password</label>
                            <div class="col-lg-5">
                                <input type="password" class="form-control" name="confirmPassword" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Company</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="company" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Street</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="street" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Nr</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="nr" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">City</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="city" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Postal code</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="postal_code" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Phone number</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="phone_number" />
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                <button type="submit" class="btn btn-primary" name="signup" value="Sign up">Sign up</button>
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
    $("#registerForm").validate({
		rules: {
			'first_name': {
				required: true
			},
			'last_name': {
				required: true
			},
            'email': { 
                required: true, 
                email: true,
                remote: {
                        url: "<?php echo  get_site_url().'/users/register' ?>",
                        type: "post",
                        data: {
                            email: function() {
                                return $( "#email" ).val();
                            }
                        }
                    }
            },
            'password': { 
                required: true, 
                minlength: 6, 
            }, 
            'confirmPassword': { 
                equalTo: "#password" 
            },
		},
		submitHandler: function(form) {
            form.submit();
		},
	});
});
</script>
</body>
</html>