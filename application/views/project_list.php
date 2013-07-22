<div class="row">
	<div class="span10 offset1">
		<button id="new_project" class="btn btn-primary">Create New Project</button>

		<?php
		echo form_open('projects/add', $form_attr);
			echo form_input('project_name', '', $placeholder);
			echo form_submit($submit_attr);		
		echo form_close();
		?>

		<ul id="project_list">
			<?php 
				foreach ($list->rows as $project) {
					echo "<li>";
					echo anchor('projects/view/'.$project->id, $project->project_name, 'class="project_link"');
					echo "<span class='project_date'>Created: " . date("Y-m-d", strtotime($project->date));
					echo "</li>";
				}

			 ?>
		</ul>


		

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
	});
</script>	