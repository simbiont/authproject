<div class="row">
	<div class="span10 offset1">
		<!-- <input id="delete_all" type="checkbox" name="delete_all"> -->
		<select id="user_list" class="span10 offset1">
			<?php 
				foreach ($list->rows as $user) { ?>
					<option value="<?= $user->id ?>"><?= $user->username ?></option>
			<?	}	?>
		</select>
		

		<button id="new_project" class="btn btn-primary">Create New Project</button>

		<?php
			echo form_open('projects/add', $form_attr);
				echo form_input('project_name', '', $placeholder);
				echo form_hidden('project_user_id');
				echo form_submit($submit_attr);
			echo form_close();
		?>

		<ul id="project_list"></ul>


		<button id="delete" class="btn btn-danger">Delete</button>
		<input type="hidden" id="projects_ids" name="projects_ids">

	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		getProjects();
		$('#new_project').click( function() {
			if ($("#project_form").is(":hidden")) {
				$("#project_form").show();
			} else {
				$("#project_form").hide();
			}
		});
		$('#delete_all').live('change', function() {
			if($(this).is(":checked")) {
				$(".delete_project").each(function() {
					$(this).attr('checked','checked');
				})
			} else {
				$(".delete_project").each(function() {
					$(this).removeAttr('checked');
				})
			}
		});
		$("#delete").live('click', function() {
			var projects_ids_array = new Array();
			$(".delete_project").each(function() {
				if($(this).is(":checked")) {
					projects_ids_array.push($(this).val());
				}
			});
			var projects_ids = $("#projects_ids").val(projects_ids_array);
			var projectsDeleteProjectUrl = 'projects/ajax_delete_projects/';

			$.ajax({
				url: projectsDeleteProjectUrl,
				type: 'post',
				data: projects_ids,
				success:function(Response) {
					var parsed = $.parseJSON(Response);
					var ids = parsed.split(",");
					for (var i = 0; i < ids.length; i++) {
						if (ids[i] == $("#"+ids[i]).attr("id")) {
							$("#"+ids[i]).remove();
						};
					};
				}
			})

		});
		$('#user_list').change(function() {
			getProjects();
		});
	});
	function getProjects() {
		var userProjectsUrl = 'projects/ajax_user_projects/';
		var user_id = $('#user_list').val();
		$.ajax({
				url: userProjectsUrl,
				type: 'post',
				data: {'user_id':user_id},
				success:function(Response) {
					$("#project_list").empty();
					var parsed = $.parseJSON(Response);
					if(parsed.rows.length > 0)
						$("#project_list").append('<li class="select_label"><input id="delete_all" class="delete_project" type="checkbox" name="delete_all">Select all</li>');
					for (var i = 0; i < parsed.rows.length; i++) {

						$("#project_list").append("<li id='"+parsed.rows[i].id+"'><input class='delete_project' type='checkbox' name='delete_project' value='"+parsed.rows[i].id+"'><a href='projects/view/"+parsed.rows[i].id+"'>"+parsed.rows[i].project_name+"</a><span class='project_date'>Created: "+parsed.rows[i].date+" </span></li>");
						
					};
					$("input[name='project_user_id']").val(user_id);
				}
			})
	}
</script>	