
<?php	
	require_once 'php_script\session.php';
	session_security();	
	require_once 'php_script\validation.php';	
	require_once 'php_script\sql_connect.php';
	$conn = sql_connect();	 	
	//Delete contact
	$form_ask_delete ='';
	if (isset($_POST['delete'])) {
		require_once 'php_script\delete_contacts.php';
		$form_ask_delete=delete_contacts($conn);		
	}	
	require 'php_script\view_contacts_list.php';	
	//header
	require 'pages\header.php';
?>
	<main class="main">
		<div class="container">
			<div class='content_view'>
				<div class="msg" style="<?php echo ($form_ask_delete !== '') ? 'visibility: visible':'visibility: hidden'; ?>">					
					<p>Are you want to delete this contact?
					<p> <?php echo $_POST['email'] ?>
					<form action="index.php" method="post" >
						<input type='hidden' name="ask" value="ok">
						<input type='hidden' name="id" value="<?php echo $_POST['id']; ?>">

						<input style = 'float:left;' type='submit' name="delete" value="Delete">
						<input style = 'float:right;' type='button'  value= 'CANCEL' onclick="location.href='index.php'">								
					</form>
				</div>
				<span style='text-align: right'><h3>MANAGEMENT MAIN PAGE</h3></span>
				<table>
					<form action='edit_view.php'>
					<input type='submit' value= 'ADD'>		
					</form>
					<thead>
						<tr>
							<th><a href="index.php?sort_l=<?= $_SESSION['cur_sort_l'];?>">Last </a><?= (isset($symbol_l))? $symbol_l : '' ?> &nbsp;&nbsp; <a href="index.php?second_sort_l=<?= $_SESSION['cur_second_sort_f'];?>"><?= (isset($second_symbol_l))? $second_symbol_l : ''; ?></a></th>

							<th><a href="index.php?sort_f=<?= $_SESSION['cur_sort_f'];?>">First </a><?= (isset($symbol_f))? $symbol_f : '' ?>  &nbsp;&nbsp; <a href="index.php?second_sort_f=<?= $_SESSION['cur_second_sort_l'];?>"><?= (isset($second_symbol_f))? $second_symbol_f : ''; ?></a></th>
							<th>Email</th>
							<th>Best Phone</th>
						</tr>
					</thead>
					<tbody>
						<?php	
							if (!empty($result)){
								//php_script\view_contacts_list.php
								view_contacts_list_index_php($result, $res);	
							}
						?>					
						</tbody>
					</table>
				<form action='edit_view.php'>			
				<input type='submit' value= 'ADD'>				
				</form>				
				<?php
					if ($how_many_records > $num_records_per_page){		
						//php_script\view_contacts_list.php
						view_pagination($how_many_records, $num_records_per_page, $pre_page, $pre_page, $pre_page2, $pre_page, $next_page, $next_page2, $next_page, $last_page, 'index.php');
					}
				?>
				</div>
			</div>			
		</div>	
	</main>	
</body>
</html>


