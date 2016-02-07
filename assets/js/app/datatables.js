define(['jquery', 'dataTables'], function($, dataTables) {

    var jQuery            = $,
        DIR_DATATABLES_PT = '../../../plugins/DataTables/datatables.pt-br.txt';

    function initialize(tableId) {
        handleDatatable();
        if ($('#'+tableId).hasClass('datatables')) {
            renderRawTable('.datatables');
        }
    }  

    function renderRawTable(datatableSelector) {

        return $(datatableSelector).dataTable({
            "oLanguage": {
                "sUrl": DIR_DATATABLES_PT
            },
            "bPaginate": false, 
            "bProcessing": true,
            "bStateSave": true,
            "bRetrieve": true,
            "sScrollX": "100%",
            "bScrollCollapse": true,
            "bAutoWidth": false
        });
        
    }

    function changeSearchbox(instance, elementSearch) {
        var dataTable = $(instance).dataTable();

        $(elementSearch).keyup(function() {
            dataTable.fnFilter(this.value);
        }); 
    }

    function disableSorting(instance) {

        return $(instance).dataTable({
            "oLanguage": {
                "sUrl": DIR_DATATABLES_PT
            },
            "bPaginate": false, 
            "bProcessing": true,
            "bStateSave": true,
            "bRetrieve": true,
            "sScrollX": "100%",
            "bScrollCollapse": true,
            "bAutoWidth": false,
            "bSort": false,
            "aoColumns": [
                { "bSortable": false },
                { "bSortable": false },
                { "bSortable": false }
            ]} 
        );
    }

    function handleDatatable() {

        // Extensões do plugin dataTables para implementação de detecção de tipos de dado.
        jQuery.fn.dataTableExt.oSort['uk_date-asc']  = function(a,b) {
            var ukDatea = a.split('/');
            var ukDateb = b.split('/');

            var x = (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
            var y = (ukDateb[2] + ukDateb[1] + ukDateb[0]) * 1;

            return ((x < y) ? -1 : ((x > y) ?  1 : 0));
        };

        jQuery.fn.dataTableExt.oSort['uk_date-desc'] = function(a,b) {
            var ukDatea = a.split('/');
            var ukDateb = b.split('/');

            var x = (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
            var y = (ukDateb[2] + ukDateb[1] + ukDateb[0]) * 1;

            return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
        };

        /* Note 'unshift' does not work in IE6. A simply array concatenation would. This is used
         * to give the custom type top priority
         */
        jQuery.fn.dataTableExt.aTypes.unshift(
            function ( sData )
            {
                var sValidChars = "0123456789-,";
                var Char;
                var bDecimal = false;
                
                /* Check the numeric part */
                for ( i=0 ; i<sData.length ; i++ )
                {
                    Char = sData.charAt(i);
                    if (sValidChars.indexOf(Char) == -1)
                    {
                        return null;
                    }
                    
                    /* Only allowed one decimal place... */
                    if ( Char == "," )
                    {
                        if ( bDecimal )
                        {
                            return null;
                        }
                        bDecimal = true;
                    }
                }
                
                return 'numeric-comma';
            }
        );

        jQuery.fn.dataTableExt.oSort['numeric-comma-asc']  = function(a,b) {
            var x = (a == "-") ? 0 : a.replace( /,/, "." );
            var y = (b == "-") ? 0 : b.replace( /,/, "." );
            x = parseFloat( x );
            y = parseFloat( y );
            return ((x < y) ? -1 : ((x > y) ?  1 : 0));
        };

        jQuery.fn.dataTableExt.oSort['numeric-comma-desc'] = function(a,b) {
            var x = (a == "-") ? 0 : a.replace( /,/, "." );
            var y = (b == "-") ? 0 : b.replace( /,/, "." );
            x = parseFloat( x );
            y = parseFloat( y );
            return ((x < y) ?  1 : ((x > y) ? -1 : 0));
        };
    } 

    function isDataTable ( nTable ) {
        var settings = $.fn.dataTableSettings;
        for ( var i=0, iLen=settings.length ; i<iLen ; i++ )
        {
            if ( settings[i].nTable == nTable )
            {
                return true;
            }
        }
        return false;
    }

    return {
        initialize          : initialize,
        renderRawTable      : renderRawTable,
        isDataTable         : isDataTable,
        initDatatables      : initDatatables,
        changeSearchbox     : changeSearchbox,
        disableSorting      : disableSorting
    };
});