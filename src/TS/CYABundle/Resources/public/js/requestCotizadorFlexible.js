/**
 * Created by tscompany on 17/02/16.
 */
$("#quotation_without_lodging").change(function(a){
    if ($(this).is(':checked')) {
        $("#quotation_lodgingpackage").prop('disabled', true);
        $("#quotation_semanas_lodging").prop('disabled', true);
        $("#quotation_lodging").prop('disabled', true);
    } else {
        $("#quotation_lodgingpackage").prop('disabled', false);
        $("#quotation_semanas_lodging").prop('disabled', false);
        $("#quotation_lodging").prop('disabled', false);
    }
});

$(".country_selector").change(function(){
    var data = {
        countryId: $(this).val()
    };

    $.ajax({
        type: 'post',
        url: Routing.generate('select_cities', null, true),
        data: data,
        success: function(data) {
            var $city_selector = $('.city_selector');

            $city_selector.html('<option value="">Seleccionar opción</option>');

            for (var i=0, total = data.length; i < total; i++) {
                $city_selector.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
        }
    });

    $.ajax({
        type: 'post',
        url: Routing.generate('select_discretionary_spendings', null, true),
        data: data,
        success: function(data) {
            var $city_selector = $('.discretionary_spending_selector');

            $city_selector.html('<option value="">Seleccionar opción</option>');

            for (var i=0, total = data.length; i < total; i++) {
                $city_selector.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
        }
    });

    $.ajax({
        type: 'get',
        url: Routing.generate('country_id_coin', {id: data.countryId}, true),
        success: function(string) {
            $("#valor_moneda").html(string);
        }
    });
});
$(".city_selector").change(function(){
    var data = {
        cityId: $(this).val()
    };

    $.ajax({
        type: 'post',
        url: Routing.generate('select_headquarters', null, true),
        data: data,
        success: function(data) {
            var $headquarter_selector = $('.headquarter_selector');
            $headquarter_selector.html('<option value="">Seleccionar opción</option>');

            for (var i=0, total = data.length; i < total; i++) {
                $headquarter_selector.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
        }
    });
});
$(".headquarter_selector").change(function(){
    var data = {
        headquarterId: $(this).val()
    };

    //Lodging
    $.ajax({
        type: 'post',
        url: Routing.generate('select_lodgings', null, true),
        data: data,
        success: function(data) {
            var $lodging_selector = $('.lodging_selector');
            $lodging_selector.html('<option value="">Seleccionar opción</option>');

            for (var i=0, total = data.length; i < total; i++) {
                $lodging_selector.append('<option value="' + data[i].id + '">' + data[i].name +' - '+ data[i].type +'</option>');
            }
        }
    });

    $.ajax({
        type: 'post',
        url: Routing.generate('select_lodgings_package', null, true),
        data: data,
        success: function(data) {
            var $lodging_selector = $('.lodging_package_selector');
            $lodging_selector.html('<option value="">Seleccionar opción</option>');

            for (var i=0, total = data.length; i < total; i++) {
                $lodging_selector.append('<option value="' + data[i].id + '">' + data[i].description +'</option>');
            }
        }
    });
    //Course
    $.ajax({
        type: 'post',
        url: Routing.generate('select_courses', null, true),
        data: data,
        success: function(data) {
            var $course_selector = $('.course_selector');
            $course_selector.html('<option value="">Seleccionar opción</option>');

            for (var i=0, total = data.length; i < total; i++) {
                $course_selector.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
        }
    });
    //Service
    var array = [];
    $.ajax({
        type: 'post',
        url: Routing.generate('select_services', null, true),
        data: data,
        success: function (data) {
            var select = document.getElementById('quotation_service');
            select.options.length = 0;
            $.each(data, function (index, item) {
                //
                if (item.type == "REQUIRED" || (item.name == "FEE" && $('#quotation_client_isUnderAge').is(":checked"))) {
                    array.push(item.id);
                    select.options.add(new Option(item.name, item.id, true, true));
                } else {
                    select.options.add(new Option(item.name, item.id));
                }
            });
        }
    });

    setTimeout(function(){
        var multi = $("#quotation_service").select2();
        multi.val(array).trigger("change");

    }, 1000);
});
/**
 * Get preview values
 */
$(".course_selector").change(function(){
    var data = {
        courseId: $(this).val()
    };

    $.ajax({
        type: 'post',
        url: Routing.generate('current_promotion', {id: data.courseId, type_promotion: 'course'}, true),
        success: function(price) {
            if (price) {
                $("#valor_promocion").html("Promoción: " + price);
            } else {
                $("#valor_promocion").html("Sin promoción");
            }
        }
    });
});
