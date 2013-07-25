<div class="row">
	<div class="span10 offset1">
		<h4>Please enter the address for users' emails forwarding</h4>
		<?php
		echo form_open('settings/setAdminMail', $form_attr);
			echo form_input('admin_email', $admin_email, $placeholder);
			echo form_submit($submit_attr);		
		echo form_close();
		?>
		<h4>Dropdown list example</h4>
		<select id="items_select">
		<?php 
		$o = 0;
		foreach ($drop_list as $key => $item) { ?>
			<option id="opt_<?= $o ?>" value="<?= $item ?>"><?= $item ?></option>
		<?php 
		$o++;
		} ?>
		</select>
		<h4>Dropdown list items</h4>

		<ul id="items">
		<?php 
		$i = 0;
		foreach ($drop_list as $key => $item) { ?>
			<li id="<?= $i ?>">
				<span id="item_<?= $i ?>"><?= $item ?></span>
				<button id="del_<?= $i ?>" class="btn btn-mini btn-danger delete">Delete</button>
			</li>
		<?php 
		$i++;
		} ?>
		</ul>
		<input type="hidden" id="list" value='<?= json_encode($drop_list) ?>'>
		<input type="hidden" id="list_i" value='<?= $i; ?>'>
		<input type="text" name="new_list_item" id="new_list_item">
		<button id="add_new_item" class="btn btn-success">Add new item</button>
		
		<h4>Rows number</h4>
		<?php 
		$data = array(
              'name'        => 'rows_number',
              'id'          => 'rows_number',
              'value'       => $fields_num
            );

		 ?>
		<?= form_input($data); ?>
		<button id="rows_number_save" class="btn btn-success">Save</button>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('#add_new_item').live('click', function() {
			var addNewItemUrl = "settings/addItem";
			var newItem = $('#new_list_item').val();
			var i = $("#list_i").val();
			if(newItem != "") {
				$.ajax({
					url: addNewItemUrl,
					type: 'post',
					data: {'new_item':newItem},
					success:function() {
						$("#items").append("<li id='"+i+"'><span id='item_"+i+"'>"+newItem+"</span><button id='del_"+i+"' class='btn btn-mini btn-danger delete'>Delete</button></li>");
						$("#items_select").append('<option id="opt_'+i+'" value="'+newItem+'">'+newItem+'</option>');
						i++
					}
				})
			} else {
				alert('Enter item name');
			}
			
		});
		$('.delete').live('click', function() {
			var deleteItemUrl = "settings/deleteItem";
			var i = $(this).attr('id').split('_');
			var item = $('#item_'+i[1]).text();

			$.ajax({
				url: deleteItemUrl,
				type: "post",
				data: {'item':item},
				success: function(Response) {
					$("#"+i[1]).remove();
					$("#opt_"+i[1]).remove();

				}
			})
		});

		$('#rows_number_save').click(function() {
			var fields_num = $('#rows_number').val();
			var setFieldUrl = "settings/setFieldsNum";
			if( fields_num != "" &&  fields_num > 0) {
				$.ajax({
					url: setFieldUrl,
					type: "post",
					data: {'fields_num':fields_num},
					success: function(Response) {
						if( Response != "")
							alert(Response);
					}
				})
			} else if(fields_num <= 0) {
				alert('Value must be greater than 0');
			} else {
				alert('Enter fields number');
			}
		})
	});
</script>		
