<?php
function send_subcribe_thank_you($subcriber, $emailto,$code,$user_id){
				include	'xtemplate.class.php';
				$header   	= 'Content-type: text/html; charset=utf-8\r\n';
				
				$title = "You have subcribed at " . get_bloginfo('name');
				$contact_email = get_option('contact_email');
				if(!is_email($contact_email)) $contact_email = get_option('admin_email');
				$contact_name = get_option('contact_name');
				if(!$contact_name)$contact_name = get_bloginfo('name');
				
				$parseTemplate	=	new XTemplate('xtemplate-email-subscrib-thank-you.html');
				$parseTemplate->assign('subscriber',$subcriber);
				$parseTemplate->assign('link', get_bloginfo('home'));
				$parseTemplate->assign('website', get_bloginfo('name'));
				$parseTemplate->assign('title',$title);
				$parseTemplate->assign('code',$code);
				$parseTemplate->assign('user_id',$user_id);	
				$parseTemplate->assign('contact_email',$contact_email);	
				$parseTemplate->assign('contact_name',$contact_name);					
				$parseTemplate->parse('main');
				wp_mail($emailto, $title, $parseTemplate->text('main'), $header);
}
