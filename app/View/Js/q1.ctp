<style>
td {
	height: 20px;
}

textarea, input {
	width: -webkit-fill-available;
}

.description_container {
	width: 40%;
}
.quantity_container, .price_container {
	width: 25%;
}
</style>
<div class="alert">
<button class="close" data-dismiss="alert"></button>
Question: Advanced Input Field</div>
<p>
1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.

</p>

<p>
2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field

<?php echo htmlentities('<input name="data[1][quantity]" class="">')?> ,  you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]

</p>

<div class="alert alert-success">
<button class="close" data-dismiss="alert"></button>
The table you start with</div>

<table class="table table-striped table-bordered table-hover" id="mytable">
<thead>
<th><span id="add_item_button" class="btn mini green addbutton" onclick="addToObj=false">
											<i class="icon-plus"></i></span></th>
<th>Description</th>
<th>Quantity</th>
<th>Unit Price</th>
</thead>
	<tbody>
		<tr>
			<td></td>
			<td class="description_container">
				<label class="description_label"></label>
				<textarea style="display:none" name="data[][description]" class="input m-wrap  description required" rows="2" ></textarea></td>
			<td class="quantity_container">
				<label class="quantity_label"></label>
				<input style="display:none" name="data[][quantity]" class="input quantity" type="number">
			</td>
			<td class="price_container">
				<label class="price_label"></label>
				<input style="display:none" name="data[][unit_price]" class="input price" type="number">
			</td>
		</tr>
	</tbody>
</table>

<hr>
<span id="save_item_button" class="btn blue"><i class="icon-check"></i> Save</span>

<p></p>
<div class="alert alert-info ">
<button class="close" data-dismiss="alert"></button>
Video Instruction</div>

<p style="text-align:left;">
<video width="78%" controls>
  <source src="<?php echo Router::url("/video/q3_2.mov") ?>">
Your browser does not support the video tag.
</video>
</p>


<?php $this->start('script_own');?>
<script>
function closeAll() {
	$(".description").hide();
	$(".price").hide();
	$(".quantity").hide();
	$(".description_label").show();
	$(".price_label").show();
	$(".quantity_label").show();
}

$(document).ready(function(){
	$("#add_item_button").click(function(){
		$('#mytable tbody').append(
			'<tr><td></td><td class="description_container"><label class="description_label"></label><textarea style="display:none" name="data[][description]" class="input m-wrap  description required" rows="2" ></textarea></td><td class="quantity_container"><label class="quantity_label"></label><input style="display:none" name="data[][quantity]" class="input quantity" type="number"></td>'+
			'<td class="price_container"><label class="price_label"></label><input style="display:none" name="data[][unit_price]" class="input price" type="number"></td></tr>'
		);
        return false;
	});

	$("#save_item_button").click(function(){
		var description = $("textarea[name='data[][description]']").map(function(){return $(this).val();}).get();
		var quantity = $("input[name='data[][quantity]']").map(function(){return $(this).val();}).get();
		var price = $("input[name='data[][unit_price]']").map(function(){return $(this).val();}).get();

		alert('description:' + description + '\r\n' +
		'quantity:' + quantity + '\r\n' +
		'price:' + price + '\r\n' );
	});

	$(document).on('change', ".description", function() {
		var parent = $(this).parent();
		var text = $(this).val();
		parent.children('.description_label').text(text);
	});

	$(document).on('click', ".description_container", function() {
		var input = $(this).find(".description");
		var label = $(this).find(".description_label");

		if(input.is(":hidden")) {
			closeAll();
			input.show();
			input.focus();
			label.hide();
		} else {
			closeAll();
			input.hide();
			label.show();
		}
	});

	$(document).on('change', ".price", function() {
		var parent = $(this).parent();
		var text = $(this).val();
		parent.children('.price_label').text(text);
	});

	$(document).on('click', ".price_container", function() {
		var input = $(this).find(".price");
		var label = $(this).find(".price_label");

		var text = input.val();
		label.text(text);

		if(input.is(":hidden")) {
			closeAll();
			input.show();
			input.focus();
			label.hide();
		} else {
			closeAll();
			input.hide();
			label.show();
		}
	});

	$(document).on('change', ".quantity", function() {
		var parent = $(this).parent();
		var text = $(this).val();
		parent.children('.quantity_label').text(text);
	});

	$(document).on('click', ".quantity_container", function() {
		var input = $(this).find(".quantity");
		var label = $(this).find(".quantity_label");

		var text = input.val();
		label.text(text);

		if(input.is(":hidden")) {
			closeAll();
			input.show();
			input.focus();
			label.hide();
		} else {
			closeAll();
			input.hide();
			label.show();
		}
	});
});
</script>
<?php $this->end();?>

