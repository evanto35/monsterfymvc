define(['jquery'], function($) {

    function initialize() {
        if ($('.page-id').length > 0) getPage($('.page-id').attr('data-page'));
        else                          console.log('Nenhuma página associada ao script');

        $('.call-action').click(function() {
            var action = $(this).attr('data-action');
            var module = $(this).attr('data-module');
            var form   = $(this).attr('data-form');
            callAction(action, module, form);
        });        
    }

    function getPage(pageID) {
        require([pageID], function(Module) {
            Module.initialize();
        });
    }

    function callAction(actionKey, module, form) {

        if (typeof form == 'undefined' || form == '') {
            document.getElementById('btn-hidden').value    = (typeof actionKey == 'undefined') ? '' : actionKey;
            document.getElementById('module-hidden').value = (typeof module == 'undefined')   ? '' : module;
            document.getElementById('frm-hidden').submit();
        }
        else {
            document.getElementById('action').value = (typeof actionKey == 'undefined') ? '' : actionKey;
            document.getElementById('module').value = (typeof module == 'undefined') ? '' : module;
            document.getElementById(form).submit();
        }
    }

    function submitForm(idForm, idCallback, module) {
        $(document.body).on('click', '#'+idCallback, function() {
            document.getElementById('module-hidden').value = module;
            $('#'+idForm).submit();
        });
    }

    function getScreenSize() {
        return $(window).width();
    }

    /**
     * Submeter formulario com post para chegada na controller
     */
    function submitForm(formId, action) {
        document.getElementById('method').value = action;
        document.getElementById(formId).submit();
    }

    // Métodos públicos que serão utilizados por outras bibliotecas externas
    return {
        initialize    : initialize,
        callAction    : callAction,
        submitForm    : submitForm,
        getScreenSize : getScreenSize,
        submitForm    : submitForm
    };
});
