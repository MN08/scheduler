/*
* @Author: donytri86
* @Date:   2020-06-19 17:38:02
* @Last Modified by:   donytri86
* @Last Modified time: 2020-08-07 21:00:08
*/

(function ( $ ) {

    $.fn.DataTableHelper = function(column, dataSrc = "data.items") {
        let id = this.attr('id');
        var columns = $.extend({}, column);

        let is_defined = false;

        let DataTableHelperSetup = {
            init: function(id, column) {
                this.id = id;
                this.table = $('#' + id);
                this.column = column;

                this.setHeader();
                this.loadPlugin();
            },

            setHeader: function() {
                let instance = this;

                instance.columnFormatted = [];
                instance.header = "<thead><tr>";

                $.each(instance.column, function(index, item) {
                    let column = {...item};

                    if (typeof item.render != 'undefined') {
                        column.data = function(data) {
                            return data;
                        }

                        if (item.render == 'number') {
                            column.render = function(data, type, row, meta) {
                                return instance.renderNumber(meta);
                            }
                        } else if (item.render == 'action') {
                            column.render = function(data, type, row, meta) {
                                if (typeof item.action == 'undefined') {
                                    item.action = [];
                                }

                                if (typeof data.action == 'undefined') {
                                    data.action = [];
                                }

                                return instance.renderAction(data.action, item.action);
                            }
                        } else {
                            column.data = item.render;
                            column.render = function(data, type, row, meta) {
                                if (typeof data == 'undefined' || row[item.data] == null) {
                                    return '-';
                                } else {
                                    return data;
                                }
                            }
                        }
                    }

                    instance.columnFormatted.push(column);

                    let width = '';
                    if (item.width) {
                        width = 'width="' + item.width + '"';
                    }

                    instance.header += "<th class=\"text-center\" " + width + ">" + item.header + "</th>";
                });

                instance.header += "</tr></thead>";

                instance.table.html(instance.header);
            },

            renderNumber: function(meta) {
                return meta.row + 1;
            },

            renderAction: function(allAction, showAction) {
                let instance = this;
                let html = '';

                $.each(showAction, function(index, item) {
                    html += allAction[item];
                });

                return html;
            },

            setDatatable: function() {
                let instance = this,
                    url = instance.table.data('resources');

                instance.baseOption = {
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "stateSave": true,
                    "dom": "<'row'<'col-md-6 col-sm-12'<'pull-left'l><'pull-left margin-left-20'B>><'col-md-6 col-sm-12'rf>><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                    "ajax": {
                        "url": url,
                        "dataType": "json",
                        "dataSrc": dataSrc
                    },
                    "scrollX": true,
                    "language": {
                        "paginate": {
                            "previous": '<i class="fa fa-angle-left"></i>',
                            "next" : '<i class="fa fa-angle-right"></i>'
                        },
                        "processing": '<i class="fa fa-spinner fa-spin"></i>'
                    },
                    "columns": instance.columnFormatted,
                    buttons: [
                        // 'copyHtml5',
                        // 'excelHtml5',
                        // 'csvHtml5',
                        // 'pdfHtml5'
                    ],
                }
            },

            initComplete: function() {
                let instance = this;
                let tableWrapper = jQuery('#' + instance.id + '_wrapper');

                tableWrapper.find('.dataTables_length select').select2();

                $('[data-need-confirm="true"]').ConfirmAction();
            },

            loadPlugin: function() {
                let instance = this;

                instance.setDatatable();

                let oTable = $('#' + instance.id).DataTable(instance.baseOption);

                $('#' + instance.id).on( 'draw.dt', function () {
                    instance.initComplete();
                } );
            },
        }

        DataTableHelperSetup.init(id, columns);
    }

}( jQuery ));
