<div class="row-fluid">
	<div class="alert alert-info">
		<h3>Migration Data</h3>
	</div>
	<hr />
<?php
echo $this->Form->create('FileUpload', ['enctype'=>'multipart/form-data', 'url' => array('controller' => 'Migration','action' =>'upload') ]);
echo $this->Form->input('file', array('label' => 'File Upload', 'type' => 'file'));
echo $this->Form->submit('Upload', array('class' => 'btn btn-primary'));
echo $this->Form->end();
?>
<?php echo $this->Session->flash();?>
</div>