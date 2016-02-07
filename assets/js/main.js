requirejs.config({
    urlArgs: "bust=v100"+ Math.random(),
    baseUrl: "../../assets/js/app/",
    waitSeconds: 30,
    shim: {

        'monsterfy': {
            deps    : ['jquery'],
            exports : 'monsterfy'
        },

        'bootstrap': {
            deps    : ['jquery'],
            exports : 'bootstrap'
        },

        'bootstrapDatepicker': {
            deps    : ['jquery'],
            exports : 'bootstrapDatepicker'
        },

        'bootstrapSelect': {
            deps    : ['jquery'],
            exports : 'bootstrapSelect'
        },

        'dataTables': {
            deps    : ['jquery'],
            exports : 'dataTables'
        },

        'tinymce': {
            deps    : ['jquery'],
            exports : 'tinymce',
            init: function() {
                this.tinyMCE.DOM.events.domLoaded = true;
                return this.tinyMCE;
            }
        }

    },
    paths: {        
        jquery              : "../vendor/jquery.min",
        bootstrap           : "../vendor/bootstrap.min",
        bootstrapDatepicker : "../vendor/bootstrap-datepicker.min",
        bootstrapSelect     : "../vendor/bootstrap-select.min",
        tinymce             : "../vendor/tinymce/jscripts/tiny_mce/tiny_mce",
        // dataTables          : "../../../plugins/DataTables/datatables.min",
        dataTables          : "../../../plugins/DataTables/DataTables-1.10.10/js/jquery.dataTables.min",
        monsterfy           : "monsterfy"
    }
});

// Carrega os arquivos principais e suas dependências.
requirejs([
    "jquery",
    "bootstrap",
    "bootstrapDatepicker",
    "bootstrapSelect",
    "dataTables",
    "tinymce",
    "monsterfy"
], function($, bootstrap, bootstrapDatepicker, bootstrapSelect, dataTables, tinymce, Monsterfy) {

    var jQuery = $;

    Monsterfy.initialize();
});
