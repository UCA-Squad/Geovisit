var current_fs, next_fs, previous_site_fs;
var left, opacity, scale;
var animating;

$(document).ready(function () {
    var titre_tp = $("input[name=titre_site]");

    $(titre_tp).blur(function () {
        if (titre_tp.val().length === 0) {
            $('.titre_dynamique_publication').html('Titre dynamique de mon site');
        } else {
            $('.titre_dynamique_publication').html(titre_tp.val());
        }
    });

    $("#etape_actuelle_site").val("fieldsiteintro");
    $(".next_site").click(function () {
        var arr_nb_cochee = 0;
        $('.checkbox-admin').each(function () {
            var input = $(this).attr('id');
            var cochee = $("#" + input).is(':checked');
            if (cochee)  {
                arr_nb_cochee++;
            }
        });

        if ($("#etape_actuelle_site").val() === "fieldsiteintro") {
            if (animating) {
                return false;
            }
            animating = true;

            current_fs = $(this).parent().parent();
            next_fs = $(this).parent().parent().next();
            $("#progressbar_sites li").eq($("fieldset").index(next_fs)).addClass("active");            
            next_fs.show();
            var id_next = next_fs.attr('id');
            
            $.ajax({
                url: host + '/admin/site/setactive',
                type: "post",
                data: {'active': id_next, '_token': $('input[name=_token]').val()},
                dataType: "json",
                success: function (data) {
                    $("#etape_actuelle_site").val(data.msg);
                }
            });
            animating = false;
            current_fs.hide();

        } else {
            if ($("#etape_actuelle_site").val() === "fieldsiteexercices") {

                if (animating) {
                    return false;
                }
                animating = true;

                current_fs = $(this).parent().parent();
                next_fs = $(this).parent().parent().next();
                $("#progressbar_sites li").eq($("fieldset").index(next_fs)).addClass("active");
                next_fs.show();
                var id_next = next_fs.attr('id');

                $.ajax({
                    url: host + '/admin/site/setactive',
                    type: "post",
                    data: {'active': id_next, '_token': $('input[name=_token]').val()},
                    dataType: "json",
                    success: function (data) {
                        $("#etape_actuelle_site").val(data.msg);
                    }
                });
                animating = false;
                current_fs.hide();

            } else if ($("#etape_actuelle_site").val() === "fieldsitepublication") {

                if (animating) {
                    return false;
                }
                animating = true;

                current_fs = $(this).parent().parent();
                next_fs = $(this).parent().parent().next();
                $("#progressbar_sites li").eq($("fieldset").index(next_fs)).addClass("active");
                next_fs.show();
                var id_next = next_fs.attr('id');
                
                $.ajax({
                    url: host + '/admin/site/setactive',
                    type: "post",
                    data: {'active': id_next, '_token': $('input[name=_token]').val()},
                    dataType: "json",
                    success: function (data) {
                        $("#etape_actuelle_site").val(data.msg);
                    }
                });
                animating = false;
                current_fs.hide();
            }
        }
    });

    $(".previous_site").each(function () {

        $(".previous_site").click(function () {
            if (animating) {
                return false;
            }
            animating = true;

            current_fs = $(this).parent().parent();
            previous_site_fs = $(this).parent().parent().prev();
            $("#progressbar_sites li").eq($("fieldset").index(current_fs)).removeClass("active");
            previous_site_fs.show();
            var id_previous_site = previous_site_fs.attr('id');
            
            $.ajax({
                url: host + '/admin/site/setactive',
                type: "post",
                data: {'active': id_previous_site, '_token': $('input[name=_token]').val()},
                dataType: "json",
                success: function (data) {
                    $("#etape_actuelle_site").val(data.msg);
                }
            });
            animating = false;
            current_fs.hide();
        });
    });
});

