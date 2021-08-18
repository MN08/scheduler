/*
* @Author: donytri86
* @Date:   2020-06-20 21:25:12
* @Last Modified by:   donytri86
* @Last Modified time: 2020-08-22 20:27:35
*/

(function ( $ ) {
    $('select[data-selected]').each(function(){
        let val = $(this).data('selected');
        $(this).val(val);
    });

    $.fn.Select2Helper = function(options) {
        let elements = this;
        var settings = $.extend({}, options );

        const Select2HelperSetup = {
            init: function(elements, option) {
                this.select = elements;

                if (typeof this.select.data('sources') == 'undefined' || this.select.data('sources') == '') {
                    this.ajax = false;
                } else {
                    this.ajax = true;
                    this.url = this.select.data('sources');
                }

                this.pre_select = '';
                if (typeof this.select.data('selected') != 'undefined' || this.select.data('selected') == '') {
                    this.pre_select = this.select.data('selected');
                    this.pre_select = this.pre_select.toString().split(',');

                    if (this.pre_select.length == 1) {
                        this.pre_select = this.pre_select[0];
                    }
                }

                this.min = 1;
                if (typeof option != 'undefined') {
                    if (typeof option.min != 'undefined') {
                        this.min = option.min;
                    }

                    this.data = option.data;
                    this.text = option.text;

                    this.param = {};
                    if (typeof option.param != 'undefined') {
                        this.param = option.param
                    }
                }

                this.loadPlugin();
            },

            loadPlugin: function() {
                let instance = this;

                let baseOption = {
                    allowClear: true,
                    placeholder: function(){
                        instance.select.data('placeholder');
                    },
                    width: '100%',
                }

                let ajaxOption = {
                    minimumInputLength: instance.min,
                    ajax: {
                        url: instance.url,
                        dataType: 'json',
                        type: "GET",
                        data: function (params) {
                            let queryParam = {
                                search: {
                                    value: params.term
                                },
                                length: 10
                            }

                            $.extend(true, queryParam, instance.param);

                            return queryParam;
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data.data.items, function(item) {
                                    let data_key = instance.data.split('.');

                                    let data = item;
                                    $.each(data_key, function (index, key) {
                                        data = data[key];
                                    });

                                    let text_key = instance.text.split('.');

                                    let text = item;
                                    $.each(text_key, function (index, key) {
                                        text = text[key];
                                    });


                                    var result = {
                                        id: data,
                                        text: text
                                    };

                                    return result;
                                })
                            };
                        }
                    }
                }

                if (instance.ajax == true) {
                    $.extend(true, baseOption, ajaxOption);
                }

                instance.select.select2(baseOption);

                if (instance.ajax == true && instance.pre_select != '') {
                    $.ajax({
                        type: 'GET',
                        url: instance.url,
                        dataType: 'json',
                        data: {
                            preselect_id: instance.pre_select
                        }
                    }).then(function (data) {
                        console.log(data.data.length);
                        if (data.data != []) {
                            var items = [];
                            if (typeof data.data.length == 'undefined') {
                                items.push(data.data);
                            } else {
                                items = data.data;
                            }

                            $.each(items, function(index, item) {
                                var option = new Option(item.text, item.id, true, true);
                                instance.select.append(option);
                            });

                            instance.select.trigger('change');
                            instance.select.trigger({
                                type: 'select2:select',
                                params: {
                                    data: items
                                }
                            });
                        }
                    });
                }

                if (instance.select.is('[readonly]')) {
                    instance.select.select2({ disabled:'readonly' });
                }
            }
        }

        Select2HelperSetup.init(elements, settings);
    }
}( jQuery ));
