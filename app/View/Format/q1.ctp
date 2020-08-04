
<div id="message1">


<?php echo $this->Form->create('Type',array('id'=>'form_type','type'=>'file','class'=>'','method'=>'POST','autocomplete'=>'off','inputDefaults'=>array(
				
				'label'=>false,'div'=>false,'type'=>'text','required'=>true), 'url' => array('controller' => 'Format','action' =>'submit')))?>
	
<?php echo __("Hi, please choose a type below:")?>
<br><br>

<?php $options_new = array(
 		'Type1' => __('<span class="showDialog" data-id="dialog_1" style="color:blue">Type1</span>
 				<div class="description" style="display:none" id="dialog_1"><ul><li>Description .......</li>
				 <li>Description 2</li></ul>
				 </div>'),
		'Type2' => __('<span class="showDialog" data-id="dialog_2" style="color:blue">Type2</span>
 				<div class="description" style="display:none" id="dialog_2"><ul><li>Desc 1 .....</li>
 				<li>Desc 2...</li></ul></div>')
		);?>

<?php echo $this->Form->input('type', array('legend'=>false, 'type' => 'radio', 'options'=>$options_new,'before'=>'<label class="radio line notcheck">','after'=>'</label>' ,'separator'=>'</label><label class="radio line notcheck">'));?>

<?php echo $this->Form->submit('Save', array('class' => 'btn btn-primary')); ?>
<?php echo $this->Form->end();?>

</div>

<style>
.showDialog:hover{
	text-decoration: underline;
}

#message1 .radio{
	vertical-align: top;
	font-size: 13px;
}

.control-label{
	font-weight: bold;
}

.wrap {
	white-space: pre-wrap;
}

.description {
	display: inline-flex;
	border-top: 1px solid #000;
    background: #fff;
	box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
}
</style>

<?php $this->start('script_own')?>
<script>

$(document).ready(function(){
	$(".showDialog").bind('mouseover',function(event){
		var id = $(this).data('id');
		$("#"+id).fadeIn(100);
	});
	$('.showDialog').bind('mouseleave', function(e) {
		var id = $(this).data('id');
		$("#"+id).fadeOut(100);
	});
})


</script>
<?php $this->end()?>