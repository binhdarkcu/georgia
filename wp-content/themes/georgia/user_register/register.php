<?php
  add_action('admin_menu', 'bt_user_register');
    function bt_user_register(){   
        add_menu_page( 'User register', 'User register', 'edit_posts', 'user-register', 'bt_select_register', get_bloginfo('template_url') . '/images/newsletter-icon.png', 10 );
    }
 function bt_select_register(){
	 global $wpdb;
	 $table_name='profile';
	 if(isset($_GET['ID']))
	 {
	 	$term_id=$_GET['ID'];
	 	$wpdb->get_results( "DELETE FROM {$table_name} where ID={$term_id}");
	 }	
?>
<style>
.bang_audit table
{
width:98%;
}
.bang_audit table tr.hang
{
 background-color: #F1F1F1;
 
	 font-size: 14px;
    line-height: 1.3em;
	font-family: Georgia,"Times New Roman","Bitstream Charter",Times,serif;
}
.bang_audit table tr td
{
line-height:30px;
border-bottom:1px solid #666666;
text-indent:5px;
}
</style>
	<div class="bang_audit">
		<h3>User register</h3>
		<table cellpadding="0" cellspacing="0">
			<tr class="hang">
				<td></td>	
				<td>Naam</td>
				<td>Bedrijf</td>
				<td>E-mail</td>
				<td>Phone</td>
				<td>Delete</td>
			</tr>
			<?php 
			$i=1;
			$myrows2 = $wpdb->get_results( "SELECT * FROM {$table_name} order by ID DESC");		
			foreach ($myrows2 as $value){
			?>
			<tr>				
				<td><?php echo $i;?></td>
				<td style="display:none;"><?php echo $value -> id;?></td>
				<td><?php echo $value -> first_name ; ?></td>
				<td><?php echo $value -> company ; ?></td>
				<td><a href="mailto:<?php echo $value -> email ; ?>"><?php echo $value -> email ; ?></a></td>
				<td><?php echo $value -> phone_number ; ?></td>
				<td><a onClick="return confirm('Do you want to delete?');" href="<?php bloginfo('url')?>/wp-admin/admin.php?page=news-letter&ID=<?php echo $value ->id;?>">Delete</a></td>
			</tr>
			<?php 
			$i++;
			}?>
			
		</table>
	</div>	
<?php	
}