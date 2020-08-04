
<div class="row-fluid">
	<table class="table table-bordered" id="table_records">
		<thead>
			<tr>
				<th>ID</th>
				<th>NAME</th>	
			</tr>
		</thead>
	</table>
</div>
<?php $this->start('script_own')?>
<script>
	$(document).ready(function() {
		var config = {
			"bServerSide": true,
			"sAjaxSource": '<?php echo $link; ?>'
		}; 

		$('#table_records').dataTable(config);
	})
</script>
<?php $this->end()?>