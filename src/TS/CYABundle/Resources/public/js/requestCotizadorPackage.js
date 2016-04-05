/**
 * Created by tscompany on 20/02/16.
 */
var packageSelect = $(".package_selector");
var serviceSelect = $(".service_selector");
function getService() {
    var services = serviceSelect.val();
    if (packageSelect.val() !== 'Seleccionar opción' && services) {
        var data = {
            "services": services,
            "package": packageSelect.val()
        };

        $.ajax({
            type: 'post',
            url: Routing.generate('services_and_package', null, true),
            data: data,
            success: function (price) {
                $("#valor_servicio").html("Servicios: " + price);
            }
        });
    }
}
$(".country_selector").change(function () {
    var data = {
        countryId: $(this).val()
    };

    $.ajax({
        type: 'post',
        url: Routing.generate('select_cities', null, true),
        data: data,
        success: function (data) {
            var $city_selector = $('.city_selector');

            $city_selector.html('<option>Seleccionar opción</option>');

            for (var i = 0, total = data.length; i < total; i++) {
                $city_selector.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
        }
    });

    $.ajax({
        type: 'post',
        url: Routing.generate('select_discretionary_spendings', null, true),
        data: data,
        success: function (data) {
            var $city_selector = $('.discretionary_spending_selector');

            $city_selector.html('<option>Seleccionar opción</option>');

            for (var i = 0, total = data.length; i < total; i++) {
                $city_selector.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
        }
    });

    $.ajax({
        type: 'get',
        url: Routing.generate('country_id_coin', {id: data.countryId}, true),
        success: function (string) {
            $("#valor_moneda").html(string);
        }
    });
});
$(".city_selector").change(function () {
    var data = {
        cityId: $(this).val()
    };

    $.ajax({
        type: 'post',
        url: Routing.generate('select_headquarters', null, true),
        data: data,
        success: function (data) {
            var $headquarter_selector = $('.headquarter_selector');
            $headquarter_selector.html('<option>Seleccionar opción</option>');

            for (var i = 0, total = data.length; i < total; i++) {
                $headquarter_selector.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
        }
    });
});

$(".headquarter_selector").change(function () {
    var data = {
        headquarterId: $(this).val()
    };

    //Lodging
    $.ajax({
        type: 'post',
        url: Routing.generate('select_lodgings', null, true),
        data: data,
        success: function (data) {
            var $lodging_selector = $('.lodging_selector');
            $lodging_selector.html('<option>Seleccionar opción</option>');

            for (var i = 0, total = data.length; i < total; i++) {
                $lodging_selector.append('<option value="' + data[i].id + '">' + data[i].name + ' - ' + data[i].type + '</option>');
            }
        }
    });
    //Packages
    $.ajax({
        type: 'post',
        url: Routing.generate('select_packages', null, true),
        data: data,
        success: function (data) {
            var $course_selector = $('.package_selector');
            $course_selector.html('<option>Seleccionar opción</option>');

            for (var i = 0, total = data.length; i < total; i++) {
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
            var select = document.getElementById('quotation_package_service');
            select.options.length = 0;
            $.each(data, function (index, item) {
                //
                if (item.type == "REQUIRED" || (item.name == "FEE" && $('#quotation_package_client_isUnderAge').is(":checked"))) {
                    array.push(item.id);
                    select.options.add(new Option(item.name, item.id, true, true));
                } else {
                    select.options.add(new Option(item.name, item.id));
                }
            });
        }
    });

    setTimeout(function () {
        var multi = $("#quotation_package_service").select2();
        multi.val(array).trigger("change");

    }, 1000);
});

$(".lodging_selector").change(function () {
    var data = {
        lodgingId: $(this).val(),
        packageId: packageSelect.val()
    };
    $.ajax({
        type: 'get',
        url: Routing.generate('lodging_by_id', {id: data.lodgingId, weeks: 0, package: data.packageId}, true),
        success: function (price) {
            $("#valor_alojamiento").html("Alojamiento: " + price);
        }
    });
});
packageSelect.change(function () {
    var data = {
        packageId: $(this).val()
    };

    $.ajax({
        type: 'get',
        url: Routing.generate('package_by_id', {id: data.packageId}, true),
        success: function (price) {
            $("#valor_curso").html("Paquete: " + price);
        }
    });

    getService();

    $.ajax({
        type: 'post',
        url: Routing.generate('current_promotion', {id: data.packageId, type_promotion: 'package'}, true),
        success: function(price) {
            if (price) {
                $("#valor_promocion").html("Promoción: " + price);
            } else {
                $("#valor_promocion").html("Sin promoción");
            }
        }
    });
});
serviceSelect.change(function () {
    getService();
});