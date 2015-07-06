<link rel="stylesheet" type="text/css" href="../../plugins/DataTables/extensions/TableTools/css/dataTables.tableTools.min.css">
<script type="text/javascript" charset="utf8" src="../../plugins/DataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#registers').dataTable( {
	        scrollY		 	: "450px",
	        scrollCollapse	: true,
	        paging		 	: false,
	        dom			 	: 'T<"clear">lfrtip',
	        tableTools 		: {
            	"sSwfPath"	: "../../plugins/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
        	}
	    } );
	} );
</script>

<?php include 'modals/insert.php'; ?>

<table id="registers" class="display">
	<thead>
		<tr>
			<th>Analista</th>
			<th>Atendimento</th>
			<th>PAX</th>
			<th>Reserva</th>
			<th>Tipo de Cliente</th>
			<th>Canal de Vendas</th>
			<th>Resumo</th>
			<th>Tipo de Ocorrência</th>
			<th>Produto</th>
			<th>Causador</th>
			<th>Solução</th>
			<th>Conclusão</th>
        </tr>
	</thead>
	<tbody>
		<?php foreach($PageContent->data as $element): ?>
			<tr>
				<td title="Analista que atendeu à ligação"><?php echo $element['userName']; ?></td>
				<td title="Horário de início do atendimento"><?php echo $element['dtTmStart']; ?></td>
				<td title="Nome do PAX"><?php echo $element['paxName']; ?></td>
				<td title="Identificação da Reserva"><?php echo $element['booking']; ?></td>
				<td title="Tipo de Cliente"><?php echo $element['clientType']; ?></td>
				<td title="Canal de Vendas"><?php echo $element['salesChannel']; ?></td>
				<td title="<?php echo $element['summary']; ?>">
					<?php echo substr($element['summary'], 0, 20); ?>...
				</td>
				<td title="Tipo da ocorrência"><?php echo $element['eventType']; ?></td>
				<td title=""><?php echo $element['product']; ?></td>
				<td title=""><?php echo $element['prompter']; ?></td>
				<?php if (empty($element['dtTmEnd'])): ?>
					<form action="./" method="POST">
						<input type="hidden" name="action" value="finishCall">
						<input type="hidden" name="callId" value="<?php echo $element['callId']; ?>">
						<td title="Descreva a resolução para finalizar o atendimento">
							<textarea title="Descreva a resolução para finalizar o atendimento" name="resolution"
								class="form-control" required></textarea>
						</td>
						<td title="Clique para concluir o atendimento">
							<button class="btn btn-success btn-xs" type="submit">
								Concluir <span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
							</button>
						</td>
					</form>
				<?php else: ?>
					<td title="<?php echo $element['resolution']; ?>">
						<?php echo substr($element['resolution'], 0, 20); ?>...
					</td>
					<td title="Horário que o atendimento foi concluído"><?php echo $element['dtTmEnd']; ?></td>
				<?php endif; ?>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>