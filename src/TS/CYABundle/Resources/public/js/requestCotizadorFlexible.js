/**
 * Created by tscompany on 17/02/16.
 */
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

            $city_selector.html('<option>Seleccionar opción</option>');

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

            $city_selector.html('<option>Seleccionar opción</option>');

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
            $headquarter_selector.html('<option>Seleccionar opción</option>');

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
            $lodging_selector.html('<option>Seleccionar opción</option>');

            for (var i=0, total = data.length; i < total; i++) {
                $lodging_selector.append('<option value="' + data[i].id + '">' + data[i].name +' - '+ data[i].type +'</option>');
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
            $course_selector.html('<option>Seleccionar opción</option>');

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

    var semanas1 = $("#quotation_semanas").val();
    var semanas2 = $("#quotation_semanas_summer").val();
    var semanas = semanas1 + semanas2;

    if (semanas) {
        $.ajax({
            type: 'get',
            url: Routing.generate('course_by_id', {id: data.courseId, weeks: semanas}, true),
            success: function(price) {
                $("#valor_curso").html("Curso: " + price);
            }
        });
    }

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

/*$(".lodging_selector").change(function(){
    var data = {
        lodgingId: $(this).val()
    };

    var semanas1 = $("#quotation_semanas_lodging").val();
    var semanas2 = $("#quotation_semanas_lodging_summer").val();
    var semanas =  semanas1 + semanas2;

    if (semanas) {
        $.ajax({
            type: 'get',
            url: Routing.generate('lodging_by_id', {id: data.lodgingId, weeks: semanas}, true),
            success: function(price) {
                $("#valor_alojamiento").html("Alojamiento: " + price);
            }
        });
    }
});*/

/*$(".service_selector").change(function(){
    var services = $(this).val();

    var semanas1 = $("#quotation_semanas").val();
    var semanas2 = $("#quotation_semanas_summer").val();
    var semanas = semanas1 + semanas2;

    var data = {
        "weeks": semanas,
        "services": services
    };

    if (semanas) {
        $.ajax({
            type: 'post',
            url: Routing.generate('services_by_id', null, true),
            data: data,
            success: function(price) {
                $("#valor_servicio").html("Servicios: " + price);
            }
        });
    }
});*/

$("#quotation_semanas").change(function(){
    var semanas1 = $(this).val();
    var semanas2 = $("#quotation_semanas_summer").val();
    var semanas = semanas1 + semanas2;

    var course = $(".course_selector").val();
    var services = $(".service_selector").val();
    var data = {
        "weeks": semanas,
        "course": course,
        "services": services
    };
    if (semanas > 0 && (course && course !== 'Seleccionar opción' || services)) {
        $.ajax({
            type: 'post',
            url: Routing.generate('weekschange', null, true),
            data: data,
            success: function(result) {
                $("#valor_curso").html("Curso: " + result.course);
                /*$("#valor_servicio").html("Servicios: " + result.services);*/
            }
        });
    }
});
/*
$("#quotation_semanas_lodging").change(function(){
    var semanas1 = $(this).val();
    var semanas2 = $("#quotation_semanas_lodging_summer").val();
    var semanas =  semanas1 + semanas2;

    var lodging = $(".lodging_selector").val();
    var data = {
        "weeks": semanas,
        "lodging": lodging
    };
    if (semanas > 0 &&  lodging && lodging !== 'Seleccionar opción') {
        $.ajax({
            type: 'post',
            url: Routing.generate('weekschangeLodging', null, true),
            data: data,
            success: function(result) {
                $("#valor_alojamiento").html("Alojamiento: " + result.lodging);
            }
        });
    }
});*/
