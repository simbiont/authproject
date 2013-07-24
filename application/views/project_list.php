<div class="row">
	<div class="span10 offset1">
		<button id="new_project" class="btn btn-primary">Create New Project</button>

		<?php
		echo form_open('projects/add', $form_attr);
			echo form_input('project_name', '', $placeholder);
			echo form_submit($submit_attr);		
		echo form_close();
		?>
		<br>
		<input id="delete_all" type="checkbox" name="delete_all">
		<ul id="project_list">
		<?php 
		foreach ($list->rows as $project) { ?>
			<li id="<?= $project->id ?>">
				<input class="delete_project" type="checkbox" name="delete_project" value="<?= $project->id; ?>">
				<?= anchor('projects/view/'.$project->id, $project->project_name, 'class="project_link"'); ?>
				<span class='project_date'>Created: <?= date("Y-m-d", strtotime($project->date)); ?> </span>
			</li>
		<?	}	?>
		</ul>

		<button id="delete" class="btn btn-danger">Delete</button>
		<input type="hidden" id="projects_ids" name="projects_ids">

	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		

		$('#new_project').click( function() {
			if ($("#project_form").is(":hidden")) {
				$("#project_form").show();
			} else {
				$("#project_form").hide();
			}
		});
		$('#delete_all').change(function() {
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
		$("#delete").click(function() {
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

		})
	});
</script>	