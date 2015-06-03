<div class="row" id="reg_msg">
	<div class="container">
		<div class="row-fluid">
			<div class="span12" style="padding-left: 30px;">
				<div class="span10">
					<h2>Users</h2>
				</div>
				<div class="span2" style="vertical-align: middle">
					Total no of users:
					<?php echo count($rc_list)?>
				</div>
			</div>
			<div class="span12">
				<table class="table table-striped">
					<thead>
						<tr>
							<td>Name</td>
							<td>Email</td>
						</tr>
					</thead>
					<tbody>
					<?php if(count($rc_list)):foreach ($rc_list as $list):?>
						<tr>
							<td><?php echo $list->fname." ".$list->lname?>
							</td>
							<td><?php echo $list->email; ?>
							</td>
						</tr>
						<?php endforeach;?>
						<?php else:?>
						<tr>
							<td colspan="5">We could not find any user</td>
						</tr>
					</tbody>
					<?php endif;?>
				</table>
			</div>
		</div>
	</div>
</div>
