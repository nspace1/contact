<?php
	require_once 'php_script\session.php';
	session_security();
	include 'php_script\validation.php';
	require_once 'php_script\sql_connect.php'; 
	$conn = sql_connect();

	require 'php_script\view_contacts_list.php';
	//header
	require 'pages\header.php';
?>
	<main>
		<div class="container">
			<div class='content_view'>
				<span style='text-align: right'><h3>SELECTION MAIN PAGE</h3></span>
					<form action='event.php' method="post">
						<input type='submit' name="ACCEPT" value= 'ACCEPT'>
						<input type='button' value= 'CANCEL' onclick="location.href='event.php'">
						<table>
							<thead>
								<tr><th>
										all
										<input type="checkbox" name="checkAll" value="checkAll">	
									</th>
									<th>
										<a href="add_contact_from_list.php?sort_l=<?php echo $sort_l;?>">Last </a><?php echo $symbol_l ?>
									</th>
									<th>
										<a href="add_contact_from_list.php?sort_f=<?php echo $sort_f;?>">First </a><?php echo $symbol_f ?>
									</th>
									<th>Email</th>
									<th>Best Phone</th>
								</tr>
							</thead>
							<tbody>
								<?php
									//php_script\view_contacts_list.php
									view_contacts_add_contact_from_list_php($result, $best_phone);
								?>						
							</tbody>
						</table>
					<input type='submit' name="ACCEPT" value= 'ACCEPT'>
					<input type='button' value= 'CANCEL' onclick="location.href='event.php'">
				</form>
				<?php
				if ($how_many_records > $num_records_per_page){		
					//php_script\view_contacts_list.php									
					view_pagination($how_many_records, $num_records_per_page, $pre_page, $pre_page, $pre_page2, $pre_page, $next_page, $next_page2, $next_page, $last_page, $page_active, 'add_contact_from_list.php');		
				}
				?>		
			</div>
		</div>	
	</main>
</body>
</html>


