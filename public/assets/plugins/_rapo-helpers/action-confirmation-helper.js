/*
* @Author: donytri86
* @Date:   2020-06-23 21:28:44
* @Last Modified by:   donytri86
* @Last Modified time: 2020-06-27 11:59:07
*/

(function ( $ ) {

    // $.fn.ConfirmAction = function(options) {
    //     let elements = this;
    //     var settings = $.extend({
    //         message: "Are you sure?",
    //         use_modal: false,
    //         yes_text: 'Yes',
    //         no_text: 'No',
    //     }, options );

    //     let ConfirmActionModal = {
    //         init: function(element) {
    //             let instance = this;

    //             instance.modalId = 'ActionConfirmationModal';
    //             instance.element = element;
    //             instance.options = settings;
    //             instance.modalSetup();

    //             // if (typeof $(instance.element).data('modalDefined') == 'undefined' || $(instance.element).data('modalDefined') == false) {
    //             //     instance.unloadModal();
    //             //     $(instance.element).data('modalDefined', true);
    //             // }

    //             instance.onSubmit();
    //         },

    //         modalSetup: function() {
    //             let instance = this;

    //             instance.html = ''+
    //             '<div id="'+instance.modalId+'" class="modal fade bs-example-modal-sm">'+
    //                 '<div class="modal-dialog modal-sm">'+
    //                     '<div class="modal-content">'+
    //                         // '<div class="modal-header">'+
    //                         // '<button id="'+instance.modalId+'_btn" class="hidden" type="button" data-toggle="modal" data-target="#'+instance.modalId+'">SHOW</button>'+
    //                         '<div class="modal-header">'+
    //                             '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
    //                             '<h4 class="modal-title" id="mySmallModalLabel">Confirmation</h4>'+
    //                         '</div>'+
    //                         '<div class="modal-body">'+
    //                             instance.options.message +
    //                         '</div>'+
    //                         '<div class="modal-footer">'+
    //                             '<button type="button" class="btn btn-default" data-dismiss="modal">'+instance.options.no_text+'</button>'+
    //                             '<button type="button" class="btn btn-primary" data-dismiss="modal" data-confirmation="yes">'+instance.options.yes_text+'</button>'+
    //                         '</div>'+
    //                     '</div>'+
    //                 '</div>'+
    //             '</div>'+
    //             '';

    //             instance.modal_element = $(instance.html);
    //         },

    //         onSubmit: function() {
    //             let instance = this;

    //             if (instance.element.tagName === 'FORM') {
    //                 instance.trigger = 'submit';
    //             } else if (element.tagName === 'A') {
    //                 instance.trigger = 'click';
    //             }

    //             $(instance.element).on(instance.trigger, function(evt){
    //                 if ($(instance.element).data('modal-confirmed') != true) {
    //                     instance.modal_element.modal('show');
    //                     evt.preventDefault();
    //                     return false;
    //                 }
    //             });

    //             instance.modal_element.on('show.bs.modal', function(evt){
    //                 instance.modal_element.find('[data-dismiss]').on('click', function(){
    //                     if ($(this).is('[data-confirmation="yes"]')) {
    //                         alert('yes');
    //                         $(instance.element).data('modal-confirmed', true);
    //                         $(instance.element).trigger(instance.trigger);
    //                     } else {
    //                         alert('no');
    //                         $(instance.element).data('modal-confirmed', false);
    //                     }
    //                 });
    //             });

    //             instance.modal_element.on('hidden.bs.modal', function(evt){
    //                 instance.modal_element.remove();
    //             });
    //         },

    //         unloadModal: function() {
    //             let instance = this;

    //             $('body').delegate('#'+instance.modalId, 'hidden.bs.modal', function() {
    //                 $(this).remove();
    //             });

    //             let submit = false;
    //             $('body').delegate('#'+instance.modalId, 'hide.bs.modal', function(evt) {
    //                 var $activeElement = $(document.activeElement);

    //                 if ($activeElement.is('[data-dismiss]')) {
    //                     let confirmation = $activeElement.data('confirmation');

    //                     if (confirmation === 'yes') {
    //                         $(instance.element).data('accepted', true)
    //                         $(instance.element).trigger(instance.trigger);
    //                     }
    //                 }
    //             });
    //         }
    //     }

    //     $.each(elements, function(){
    //         let element = this;

    //         settings.message = $(element).data('message') || "Are you sure?";
    //         settings.use_modal = $(element).data('use-modal') || false;

    //         if (settings.use_modal == true) {
    //             ConfirmActionModal.init(element);
    //         } else {
    //             if (typeof $(element).data('confirmAction') == 'undefined' || $(element).data('confirmAction') == "false") {
    //                 $(element).data('confirmAction', 'true');

    //                 if (element.tagName === 'FORM') {
    //                     $(element).on('submit', function(evt){

    //                         // if (typeof $(element).data('accepted') == 'undefined' || $(element).data('accepted') == "false") {
    //                         //     evt.preventDefault();

    //                         //     let trigger = 'submit';
    //                         //     let confirmBox = confirm(settings.message);
    //                         //     if (confirmBox == true) {
    //                         //         $(element).data('accepted', "true");
    //                         //         $(element).trigger(trigger);
    //                         //     } else {
    //                         //         $(element).data('accepted', "false");
    //                         //     }

    //                         //     return false;
    //                         // } else {
    //                         //     $(element).data('accepted', "false");
    //                         // }

    //                         let confirmBox = confirm(settings.message);

    //                         if (confirmBox == false) {
    //                             evt.preventDefault();
    //                             return false;
    //                         }
    //                     });
    //                 } else if (element.tagName === 'A') {
    //                     $(element).on('click', function(evt){

    //                         // if (typeof $(element).data('accepted') == 'undefined' || $(element).data('accepted') == "false") {
    //                         //     evt.preventDefault();

    //                         //     let trigger = 'click';
    //                         //     let confirmBox = confirm(settings.message);
    //                         //     if (confirmBox == true) {
    //                         //         $(element).data('accepted', "true");
    //                         //         $(element).trigger(trigger);
    //                         //         alert($(element).data('accepted'))
    //                         //     } else {
    //                         //         $(element).data('accepted', "false");
    //                         //     }

    //                         //     return false;
    //                         // } else {
    //                         //     $(element).data('accepted', "false");
    //                         // }

    //                         let confirmBox = confirm(settings.message);

    //                         if (confirmBox == false) {
    //                             evt.preventDefault();
    //                             return false;
    //                         }
    //                     });
    //                 }
    //             }
    //         }
    //     });
    // }

    // $('[data-need-confirm="true"]').ConfirmAction();
}( jQuery ));


(function ( $ ) {

    $.fn.ConfirmAction = function(options) {
        let elements = this;

        $.each(elements, function(){
            let element = this;

            let settings = $.extend({
                message: $(element).data('confirm-message') || "Are you sure?",
                use_modal: $(element).data('use-modal') || false,
                yes_text: $(element).data('yes-text') || 'Yes',
                no_text: $(element).data('no-text') || 'No',
            }, options );

            ConfirmActionModal(element, settings)
        });
    }

    const ConfirmActionModal = function(element, settings) {
        modalId = 'ActionConfirmationModal';

        let html;
        let modal_element;

        function setupModal() {
            if ($('#' + modalId).length > 0) {
                $('#' + modalId).remove();
            }

            html = ''+
                '<div id="'+modalId+'" class="modal fade bs-example-modal-sm">'+
                    '<div class="modal-dialog modal-sm">'+
                        '<div class="modal-content">'+
                            // '<div class="modal-header">'+
                            // '<button id="'+modalId+'_btn" class="hidden" type="button" data-toggle="modal" data-target="#'+modalId+'">SHOW</button>'+
                            '<div class="modal-header">'+
                                '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                '<h4 class="modal-title" id="mySmallModalLabel">Konfirmasi</h4>'+
                            '</div>'+
                            '<div class="modal-body">'+
                                settings.message +
                            '</div>'+
                            '<div class="modal-footer">'+
                                '<button type="button" class="btn btn-primary" data-dismiss="modal">'+settings.no_text+'</button>'+
                                '<button type="button" class="btn btn-warning" data-dismiss="modal" data-confirmation="yes">'+settings.yes_text+'</button>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '';

            modal_element = $(html);
            $('body').append(modal_element);

            modal_element.on('show.bs.modal', function(evt){
                modal_element.find('[data-dismiss]').on('click', function(){
                    if ($(this).is('[data-confirmation="yes"]')) {
                        $(element).data('modal-confirmed', true);
                        $(element).trigger(element_trigger);
                    } else {
                        $(element).data('modal-confirmed', false);
                    }
                });
            });

            modal_element.on('hidden.bs.modal', function(evt){
                modal_element.remove();
            });
        }
        setupModal();

        if (element.tagName === 'FORM') {
            var element_trigger = 'submit';
        } else if (element.tagName === 'A') {
            var element_trigger = 'click';
        }

        $(element).on(element_trigger, function(evt){
            let is_modal_confirmed = $(element).data('modal-confirmed');
            if (typeof is_modal_confirmed == 'undefined' || is_modal_confirmed == false) {
                setupModal();
                modal_element.modal('show');

                evt.preventDefault();

                return false;
            }

            $(element).data('modal-confirmed', false);

            if (element.tagName === 'A') {
                let href = $(element).attr('href');
                let target = $(element).attr('target');

                if (target === '_blank') {
                    window.open(href, target);
                } else {
                    window.location.href = href;
                }
            }

            return true;
        });
    }

    // let ConfirmActionModal = {
    //     init: function(element, settings) {
    //         let instance = this;
    //         instance.element = element;
    //         instance.settings = settings;

    //         console.log(instance);
    //     }
    // }

    $('[data-need-confirm="true"]').ConfirmAction();
}( jQuery ));
