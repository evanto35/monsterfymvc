<script type="text/javascript">
	$(document).ready(function() {
	    $('#users').dataTable( {
	        scrollY		 	: "450px",
		    deferRender		: true,
	        responsive		: true,
	        scrollCollapse	: true,
	        paging		 	: false,
			dom 			: 'B<"clear">lfrtip',
		    buttons			: true
	    } );
	} );
</script>

<table id="users" class="display">
	<thead>
		<tr>
			<th>ID</th>
			<th>Nome</th>
			<th>E-Mail</th>
			<th>Ativo</th>
        </tr>
	</thead>
	<tbody>
		<?php foreach($this->data as $element): ?>
			<tr>
				<td title="ID"><?php echo $element->id; ?></td>
				<td title="Nome"><?php echo $element->name; ?></td>
				<td title="E-Mail"><?php echo $element->email; ?></td>
				<td title="Ativo">
					<span class="glyphicon glyphicon-<?php echo $element->active ? 'ok': 'remove'; ?>" aria-hidden="true"></span>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>	
