<?php
    //session_start();
    //echo session_id();
    function 	register_email($name, $company, $email, $phone){
                include_once	'xtemplate.class.php';
                $header   	= 'Content-type: text/html; charset=utf-8\r\n';				
                $title 		= 'User Register';
                $contact_email = get_option('admin_email');
                $contact_name = get_bloginfo('name');
				//echo $contact_email;
                $date = date('d-m-Y');
                $parseTemplate	=	new XTemplate('xtemplate.register.html');
                $parseTemplate->assign('Naam',$name);
                $parseTemplate->assign('date',$date);
                $parseTemplate->assign('Bedrijf',$company);                
                $parseTemplate->assign('Email',$email);	
                $parseTemplate->assign('Phone',$phone);
                $parseTemplate->parse('main');	
                return wp_mail($contact_email, $title, $parseTemplate->text('main'), $title);
            }
