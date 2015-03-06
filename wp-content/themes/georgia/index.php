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
        //$link = get_site_url().'/users';
        //echo "<script>window.location.href = '$link';</script>";
    }
    $logged = false;
    $message = "";
    if(isset($_POST['email']))
    {
        global $wpdb;
        $data['first_name'] = $_POST['first_name'];
        //$data['last_name'] = $_POST['last_name'];
        $data['email'] = $_POST['email'];
        //$data['password'] = sha1($_POST['password']);
        $data['company'] = $_POST['company'];
        //$data['street'] = $_POST['street'];
        //$data['nr'] = $_POST['nr'];
        //$data['city'] = $_POST['city'];
        //$data['postal_code'] = $_POST['postal_code'];
        $data['phone_number'] = $_POST['phone_number'];
        $data['created'] = date('Y-m-d h:i:s');
        $data['modified'] = date('Y-m-d h:i:s');
        
        $results = $wpdb->insert('profile', $data);
        if($results){
            $logged = true;
			$sendmail = register_email($data['first_name'],$data['company'], $data['email'],$data['phone_number'] );
			if($sendmail) 
			    $message = "Register success";
			else 
			    $message = 'Current can not register. Please try again.';

            unset($data['password']);
            $_SESSION['user'] = $data;
            //$link = get_site_url().'/users';
            //echo "<script>setTimeout(function(){window.location.href = '$link';},1000);</script>";
        }
        else{
            $message = "Register failed";
        }
    }
    
    
    
    

?>
<?php get_header();?>

    <div class="container">
        <div class="row">
            <!-- form: -->
            <section>
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="page-header">
                        <a href="<?php echo bloginfo('home');?>" class="logo">
                        	<img src="images/logo.png" alt="logo"/>
                        </a>
                        <p>
                        	Wilt u lid worden?<br/> 
							Vul dan hier uw gegevens in.
                        </p>
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
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="first_name" placeholder="Naam" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="company" placeholder="Bedrijf" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-5">
                                <input type="text" class="form-control" id="email" name="email" placeholder="E-mail" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-5">
                                <input type="text" class="form-control" name="phone_number" placeholder="telefoon nummer"/>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-3">
                                <button type="submit" class="btn btn-primary" name="signup" value="VERZENDEN">VERZENDEN</button>
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
			'company': {
				required: true
			},
            'email': { 
                required: true, 
                email: true,
                remote: {
                        url: "<?php echo  get_site_url();?>",
                        type: "post",
                        data: {
                            email: function() {
                                return $( "#email" ).val();
                            }
                        }
                    }
            },
            'phone_number': { 
                required: true, 
                minlength: 9, 
            }
		},
		messages: {
            "first_name": "",
            "company": "",
            "email":"",
            "phone_number":""
        },
		submitHandler: function(form) {
            form.submit();
		},
	});
});
</script>
<?php get_footer();?>