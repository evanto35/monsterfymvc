<br />

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRegisterCall">
    <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> Registrar Ligação
</button>

<div id="modalRegisterCall" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="incomingCalling" id="incomingCalling" action="./" method="POST">
                <input type="hidden" name="action" value="register">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Registrar Ligação</h4>
                </div>

                <div class="modal-body">
                    <!-- PAX -->
                    <div class="form-group">
                        <label for="inputPax">PAX</label>
                        <input type="text" title="Forneça o nome do PAX" id="inputPax" name="paxName" class="form-control" required>
                    </div>
                    <!--##############################-->

                    <!-- BOOKING -->
                    <div class="form-group">
                        <label for="inputBooking">Reserva</label>
                        <input type="text" title="Forneça o identificador da reserva (LOC)" id="inputBooking" name="booking" class="form-control" required>
                    </div>
                    <!--##############################-->

                    <!-- TIPO DE CLIENTE -->
                    <div class="form-group">
                        <label for="inputClientTypeId">Tipo de Cliente</label>
                        <select id="inputClientTypeId" name="clientTypeId" title="Tipo de Cliente" class="form-control" required>
                            <?php foreach($PageContent->System->clientTypes as $element): ?>
                                <option value=<?php echo $element['id']; ?>><?php echo $element['description']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!--##############################-->

                    <!-- TIPO DE EVENTO -->
                    <div class="form-group">
                        <label for="inputEventTypeId">Ocorrência</label>
                        <select id="inputEventTypeId" name="eventTypeId" title="Selecione o tipo de Ocorrência" class="form-control" required>
                            <?php foreach($PageContent->System->eventTypes as $element): ?>
                                <option value=<?php echo $element['id']; ?>><?php echo $element['description']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!--##############################-->

                    <!-- PRODUTO -->
                    <div class="form-group">
                        <label for="inputProductId">Produto</label>
                        <select id="inputProductId" name="productId" title="Selecione o produto" class="form-control" required>
                            <?php foreach($PageContent->System->products as $element): ?>
                                <option value=<?php echo $element['id']; ?>><?php echo $element['description']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!--##############################-->

                    <!-- CAUSADOR -->
                    <div class="form-group">
                        <label for="inputPrompterId">Causador</label>
                        <select id="inputPrompterId" name="prompterId" title="Selecione o causador" class="form-control" required>
                            <?php foreach($PageContent->System->prompters as $element): ?>
                                <option value=<?php echo $element['id']; ?>><?php echo $element['description']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!--##############################-->

                    <!-- CANAL DE VENDAS -->
                    <div class="form-group">
                        <label for="inputSalesChannelId">Canal de Vendas</label>
                        <select id="inputSalesChannelId" name="salesChannelId" title="Selecione o canal de vendas" class="form-control" required>
                            <?php foreach($PageContent->System->salesChannels as $element): ?>
                                <option value=<?php echo $element['id']; ?>><?php echo $element['description']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!--##############################-->

                    <!-- RESUMO -->
                    <div class="form-group">
                        <label for="inputSummary">Resumo da Ocorrência</label>
                        <textarea rows="4" cols="50" id="inputSummary" name="summary" title="Descreva a ocorrência" class="form-control" required></textarea>
                    </div>
                    <!--##############################-->
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancelar <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                    <button type="submit" class="btn btn-success">
                        Registrar <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->