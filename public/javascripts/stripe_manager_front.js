
function fmff_manager_add_notification(t, e) {
    //var a = arguments.length > 1 && void 0 !== e ? e : "success"
    var a = e,
        n = jQuery("body").find(".os-notifications");
    n.length || (jQuery("body").append('<div class="os-notifications"></div>'), n = jQuery("body").find(".os-notifications")), n.find(".item").length > 0 && n.find(".item:first-child").remove(), n.append('<div class="item item-type-' + a + '">' + t + '<span class="os-notification-close"><i class="latepoint-icon latepoint-icon-x"></i></span></div>')
}


jQuery(document).ready(function ($) {

    $('#clic_change_paymentmethod').click(function() {
        //alert( "Handler for .click() called." );
        var a = $(this),
            t = a.closest(".card");

            var form = t.find('.form_register_card'),
            card_payment = t.find('.card-payment');
            card_payment.hide();
            form.removeAttr('hidden');
        
    });

    $('.close_aaction_pm').click( function() {
        
        var a = $(this),
        t = a.closest(".card");

        var form = t.find('.form_register_card'),
        card_payment = t.find('.card-payment');

        //form.hide();
        form.attr('hidden', true);
        card_payment.show();

    });

    $(".stripe-manager-content").on("click", 'form[data-sm-action] button[type="submit"]', (function(t) {
        $(this).addClass("sm-loading");
    }))


    $(".stripe-manager-content").on("submit", "form[data-sm-action]", (function(e) {
        e.preventDefault();


        var a = $(this),
            n = a.serialize();

            o = {
                action: "fmff_manager_route_call",
                route_name: a.data("sm-action"),
                params: n,
                return_format: "json"
            };

       return  $.ajax({
            type: "post",
            dataType: "json",
            url: fmff_manager_helper.ajaxurl,
            data: o,
            success: function e(n) {
                console.log( n );
                if ("success" === n.status ) {
                    a.find('button[type="submit"].sm-loading').removeClass("sm-loading");
                    fmff_manager_add_notification( n.message,"success"),void location.reload();
                }else{                    
                    alert(n.message);
                    a.find('button[type="submit"].sm-loading').removeClass("sm-loading");
                }
            },
            error: function (e) {
                console.log( e );
                alert(e.message);
                a.find('button[type="submit"].sm-loading').removeClass("sm-loading");
            }
        }), !1


    }));

});