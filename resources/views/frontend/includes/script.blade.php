<script src="{{ asset('/public/web-assets/common/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('/public/web-assets/frontend/js/popper.min.js') }}"></script>
<script src="{{ asset('/public/web-assets/frontend/js/bootstrap.js') }}"></script>
<script src="{{ asset('/public/web-assets/frontend/js/plugin.js') }}"></script>
<script src="{{ asset('/public/web-assets/frontend/js/main.js') }}"></script>
<script src="{{ asset('/public/web-assets/frontend/js/dynamic-script.js') }}"></script>
<script src="{{ asset('/public/web-assets/common/js/toastr.min.js') }}"></script>
<script type="text/javascript"></script>
<script src="{{ asset('/public/web-assets/backend/plugins/select2/js/select2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/en.js"></script>
<script>
    $('.nav-new-menu-style li').addClass('list');
    $('select').select2({
        language: "en"
    });
</script>
<script>
    (function($) {
        "use strict";
        $(document).ready(function() {
            // password check
            $(document).on('click', '.toggle-password', function() {
                $(this).toggleClass('show');
                let input = $(this).siblings('input');
                let icon = $(this).find('i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('la-eye-slash').addClass('la-eye');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('la-eye').addClass('la-eye-slash');
                }
            });

            // modal close
            $('.close').on('click', function() {
                $('#media_upload_modal').modal('hide');
            });
            $(document).on('mouseup', function(e) {
                if ($(e.target).closest('.navbar-right-notification').find(
                        '.navbar-right-notification-wrapper').length === 0) {
                    $('.navbar-right-notification-wrapper').removeClass('active');
                }
            });
        });
    }(jQuery));
</script>
<script src="/public/web-assets/frontend/js/jquery.ihavecookies.min.js"></script>
<script>
    $(document).ready(function() {
        var delayTime = "5000";
        delayTime = delayTime ? delayTime : 4000;
        // $.gdprcookie/
        $('body').ihavecookies({
            title: "Cookies &amp; Privacy",
            message: `Is education residence conveying so so. Suppose shyness say ten behaved morning had. Any unsatiable assistance compliment occasional too reasonably advantages.`,
            expires: "30",
            link: "https://listocean.bytesed.com/privacy-policy",
            delay: delayTime,
            moreInfoLabel: "More information",
            acceptBtnLabel: "Accept",
            advancedBtnLabel: "Decline",
            cookieTypes: [{
                "type": "Site Preferences",
                "value": "Site Preferences",
                "description": "These are cookies that are related to your site preferences, e.g. remembering your username, site colours, etc."
            }, {
                "type": "Analytics",
                "value": "Analytics",
                "description": "Cookies related to site visits, browser types, etc."
            }],
            moreBtnLabel: "Manage",
            cookieTypesTitle: "Manage Cookies",
        });
        $('body').on('click', '#gdpr-cookie-close', function(e) {
            e.preventDefault();
            $(this).parent().remove();
        });
    });
</script>

<script>
    (function($) {
        $(document).ready(function() {
            var defaulGateway = $('#site_global_payment_gateway').val();
            $('.payment-gateway-wrapper ul li[data-gateway="' + defaulGateway + '"]').addClass('selected');
            let customFormParent = $('.payment_gateway_extra_field_information_wrap');
            customFormParent.children().hide();
            // for manual payment gateway
            $(document).on('click', '.payment-gateway-wrapper > ul > li', function(e) {
                e.preventDefault();
                let gateway = $(this).data('gateway');
                let manual_transaction_div = $('.manual_transaction_id');
                let summernot_wrap_div = $('.summernot_wrap');

                customFormParent.children().hide();
                if (gateway === 'manual_payment') {
                    manual_transaction_div.fadeIn();
                    summernot_wrap_div.fadeIn();
                    manual_transaction_div.removeClass('d-none');
                } else {
                    manual_transaction_div.addClass('d-none');
                    summernot_wrap_div.fadeOut();
                    manual_transaction_div.fadeOut();

                    let wrapper = customFormParent.find('#' + gateway + '-parent-wrapper');
                    if (wrapper.length > 0) {
                        wrapper.fadeIn();
                    }
                }
                $(this).addClass('selected').siblings().removeClass('selected');
                $('.payment-gateway-wrapper').find(('input')).val($(this).data('gateway'));
                $('.payment_gateway_passing_clicking_name').val($(this).data('gateway'));
            });
        });
    })(jQuery);
</script>
<script>
    (function($) {
        $(document).ready(function() {
            //if the wallet checkbox is checked need to show this value as current seleted payment gateway
            $(document).on('click', '.current_balance_selected_gateway', function() {
                $('.payment-gateway-wrapper li').removeClass('active');
                $('.payment-gateway-wrapper li').removeClass('selected');
                $('.current-balance-wrapper .current_balance_selected_gateway').addClass(
                    'selected');
                $('.payment-gateway-wrapper #order_from_user_wallet').val('current_balance');
            });
            // if the wallet checkbox is checked need to show this value as current selected payment gateway
            $(document).on('click', '.wallet_selected_payment_gateway', function() {
                let wallet_value = $(this).val();
                $('.payment-gateway-wrapper li').removeClass('active');
                $('.payment-gateway-wrapper li').removeClass('selected');
                $('.wallet-payment-gateway-wrapper .wallet_selected_payment_gateway').addClass(
                    'selected');
                if ($('.wallet-payment-gateway-wrapper input[type="checkbox"]').prop('checked')) {
                    $('.payment-gateway-wrapper #order_from_user_wallet').val('wallet');
                    $('.wallet-payment-gateway-wrapper input[type="checkbox"]').prop('checked',
                        true)
                } else {
                    $('.payment-gateway-wrapper #order_from_user_wallet').val('');
                    $('.wallet-payment-gateway-wrapper input[type="checkbox"]').removeAttr(
                        'checked');
                }
            });

            //select payment gateway
            $(document).on('click', '.payment_getway_image ul li', function() {
                //wallet start
                $('.wallet_selected_payment_gateway').removeClass('selected')
                $(".wallet_selected_payment_gateway").prop("checked", false);
                //wallet end
                //current balance start
                $('.current_balance_selected_gateway').addClass('selected');
                $(".current_balance_selected_gateway").prop("checked", false);
                //current balance end
                $(this).siblings().removeClass('active');
                $(this).addClass('active');
                let payment_gateway_name = $(this).data('gateway');
                $('#msform input[name=selected_payment_gateway]').val();

                $('.payment_gateway_extra_field_information_wrap > div').hide();
                $('.payment_gateway_extra_field_information_wrap div.' + payment_gateway_name +
                    '_gateway_extra_field').show();
                $(this).addClass('selected').siblings().removeClass('selected');
                $('.payment-gateway-wrapper').find(('input')).val(payment_gateway_name);
            });
            $('.payment_getway_image ul li.selected.active').trigger('click');
        });
    })(jQuery);
</script>
<script>
    (function($) {
        $(document).ready(function() {

            let site_default_currency_symbol = '$';

            // Renew membership plan
            $(document).on('click', '.renew_current_membership', function(e) {
                // Change the class ID name
                $('#paymentGatewayModal').find('#membership_id').attr('id', 'membership_id_stop');
                let membership_id = $(this).data('renew_id');
                $('#membership_id').val(membership_id);
            });

            // Buy now membership plan
            $(document).on('click', '.choose_membership_plan', function(e) {
                // Change the class ID name
                $('#paymentGatewayModal').find('#membership_id_stop').attr('id', 'membership_id');

                let membership_id = $(this).data('id');
                let membership_price = $(this).data('price');
                let balance = 0;

                $('#membership_id').val(membership_id);
                $('#membership_price').val(membership_price);

                if (membership_price > balance) {
                    $('.display_balance').html(
                        '<span class="text-danger">Wallet Balance Shortage:' +
                        site_default_currency_symbol + (membership_price - balance) + '</span>');
                    $('.deposit_link').html('<a href="index.html#" target="_blank">Deposit</a>');
                }
            });

            // login
            $(document).on('click', '.login_to_buy_a_membership', function(e) {
                e.preventDefault();
                let username = $('#username').val();
                let password = $('#password').val();
                let membership_price = $('#membership_price').val();
                let erContainer = $(".error-message");
                erContainer.html('');
                $.ajax({
                    url: "https://listocean.bytesed.com/membership/user/login",
                    data: {
                        username: username,
                        password: password
                    },
                    method: 'POST',
                    error: function(res) {
                        let errors = res.responseJSON;
                        erContainer.html('<div class="alert alert-danger"></div>');
                        $.each(errors.errors, function(index, value) {
                            erContainer.find('.alert.alert-danger').append(
                                '<p>' + value + '</p>');
                        });
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            location.reload();
                            let balance = res.balance;
                            $('#loginModal').modal('hide');
                            if (membership_price > balance) {
                                $('.load_after_login').load(location.href +
                                    ' .load_after_login',
                                    function() {
                                        $('.display_balance').html(
                                            '<span class="text-danger">Wallet Balance Shortage:' +
                                            site_default_currency_symbol + (
                                                membership_price - balance) +
                                            '</span>');
                                        $('.deposit_link').html(
                                            '<a href="index.html#" target="_blank">Deposit</a>'
                                        );
                                    });
                            }
                        }
                        if (res.status == 'failed') {
                            erContainer.html('<div class="alert alert-danger">' + res
                                .msg + '</div>');
                        }
                    }

                });
            });

            //buy membership-load spinner
            $(document).on('click', '#confirm_buy_membership_load_spinner', function() {
                //Image validation
                let manual_payment = $('#order_from_user_wallet').val();
                if (manual_payment == 'manual_payment') {
                    let manual_payment_image = $('input[name="manual_payment_image"]').val();
                    if (manual_payment_image == '') {
                        toastr_warning_js("Image field is required")
                        return false
                    }
                }

                $('#buy_membership_load_spinner').html('<i class="fas fa-spinner fa-pulse"></i>')
                setTimeout(function() {
                    $('#buy_membership_load_spinner').html('');
                }, 10000);
            });

        });
    }(jQuery));
</script>

<script>
    (function($) {
        "use strict";
        $(document).ready(function() {

            //bookmarks
            $(document).on('click', '.click_to_favorite_add_remove', function() {
                let $this = $(this);
                let listing_id = $this.data('listing_id');
                $.ajax({
                    url: "https://listocean.bytesed.com/favorite/listing-add-remove",
                    type: 'POST',
                    data: {
                        _token: '4qMgoof0CGXn76Y2Ovd5AWGkX891VOaiaqMZeUxn',
                        listing_id: listing_id
                    },
                    success: function(res) {
                        if (res.status === 'add_success') {
                            // Change the heart icon to filled heart
                            $this.find('i').removeClass('favorite_remove_icon')
                                .addClass('favorite_add_icon');
                            $this.closest('.favourite-icon').addClass('favourite');
                            toastr_success_js(res.message);
                        } else if (res.status === 'remove_success') {
                            $this.find('i').removeClass('favorite_add_icon').addClass(
                                'favorite_remove_icon');
                            $this.closest('.favourite-icon').removeClass('favourite');
                            toastr_warning_js(res.message);
                        } else {
                            toastr_warning_js(res.message);
                        }
                    }
                });
            });

        });
    })(jQuery);
</script>
<script>
    (function($) {
        "use strict";

        $(document).ready(function() {
            $(document).on('change',
                '#search_by_country,#search_by_state,#search_by_city,#search_by_category,#search_by_subcategory, #search_by_child_category, #search_by_rating,#search_by_sorting',
                function(e) {
                    e.preventDefault();
                    // get price and set value
                    let left_value = $('.input-min').val();
                    let right_value = $('.input-max').val();
                    $('#price_range_value').val(left_value + ',' + right_value);

                    // google map km set
                    let distance_km_value = $('#slider-value').text();
                    $('#distance_kilometers_value').val(distance_km_value);
                    let get_autocomplete_value = $('#autocomplete').val();
                    $('#autocomplete_address').val(get_autocomplete_value);

                    $('#search_listings_form').trigger('submit');
                });

            $(document).on('click', '#yesterday,#last_week,#today', function(e) {
                e.preventDefault();

                // get price and set value
                let left_value = $('.input-min').val();
                let right_value = $('.input-max').val();
                $('#price_range_value').val(left_value + ',' + right_value);

                // google map km set
                let distance_km_value = $('#slider-value').text();
                $('#distance_kilometers_value').val(distance_km_value);
                let get_autocomplete_value = $('#autocomplete').val();
                $('#autocomplete_address').val(get_autocomplete_value);



                // Determine the value based on the clicked element
                let date_posted_value;
                if ($(this).is('#yesterday')) {
                    date_posted_value = 'yesterday';
                } else if ($(this).is('#last_week')) {
                    date_posted_value = 'last_week';
                } else if ($(this).is('#today')) {
                    date_posted_value = 'today';
                }
                // Set the value to the hidden input field
                $('#date_posted_listing').val(date_posted_value);

                $('#search_listings_form').trigger('submit');
            });

            $(document).on('click', '#card_grid,#card_list', function(e) {
                e.preventDefault();

                // get price and set value
                let left_value = $('.input-min').val();
                let right_value = $('.input-max').val();
                $('#price_range_value').val(left_value + ',' + right_value);
                // google map km set
                $('#distance_kilometers_value').val(0);
                $('#autocomplete_address').val('');
                $('#autocomplete').val('');
                $('#location_city_name').val('');
                $('#longitude').val(0);
                $('#latitude').val(0);
                $('#price_range_value').val(0);

                // Determine the value based on the clicked element
                let listing_card_view_value;
                if ($(this).is('#card_grid')) {
                    listing_card_view_value = 'grid';
                } else if ($(this).is('#card_list')) {
                    listing_card_view_value = 'list';
                }
                // Set the value to the hidden input field
                $('#listing_grid_and_list_view').val(listing_card_view_value);

                showLoader();
                handleFormSubmission();

                $('#search_listings_form').trigger('submit');
            });

            $(document).on('click', '#featured, #top_listing', function(e) {
                e.preventDefault();

                // get price and set value
                let left_value = $('.input-min').val();
                let right_value = $('.input-max').val();
                $('#price_range_value').val(left_value + ',' + right_value);

                // google map km set
                let distance_km_value = $('#slider-value').text();
                $('#distance_kilometers_value').val(distance_km_value);
                let get_autocomplete_value = $('#autocomplete').val();
                $('#autocomplete_address').val(get_autocomplete_value);

                let listing_type_preferences_value;
                if ($(this).is('#featured')) {
                    listing_type_preferences_value = 'featured';
                } else if ($(this).is('#top_listing')) {
                    listing_type_preferences_value = 'top_listing';
                }
                // Set the value to the hidden input field
                $('#listing_type_preferences').val(listing_type_preferences_value);
                $('#search_listings_form').trigger('submit');
            });

            $(document).on('click', '#new, #used', function(e) {
                e.preventDefault();
                // get price and set value
                let left_value = $('.input-min').val();
                let right_value = $('.input-max').val();
                $('#price_range_value').val(left_value + ',' + right_value);

                // google map km set
                let distance_km_value = $('#slider-value').text();
                $('#distance_kilometers_value').val(distance_km_value);
                let get_autocomplete_value = $('#autocomplete').val();
                $('#autocomplete_address').val(get_autocomplete_value);

                let condition_listing_value;
                if ($(this).is('#new')) {
                    condition_listing_value = 'new';
                } else if ($(this).is('#used')) {
                    condition_listing_value = 'used';
                }
                // Set the value to the hidden input field
                $('#listing_condition').val(condition_listing_value);
                $('#search_listings_form').trigger('submit');
            });

            // Sync search input to hidden form field and submit
            $(document).on('click', '#search_by_query_btn', function(e) {
                e.preventDefault();
                let qVal = $('#search_by_query').val().trim();
                $('#search_q_hidden').val(qVal);

                // get price and set value
                let left_value = $('.input-min').val();
                let right_value = $('.input-max').val();
                $('#price_range_value').val(left_value + ',' + right_value);

                // google map km set
                let distance_km_value = $('#slider-value').text();
                $('#distance_kilometers_value').val(distance_km_value);
                let get_autocomplete_value = $('#autocomplete').val();
                $('#autocomplete_address').val(get_autocomplete_value);

                if (qVal.length > 0) {
                    $('#search_listings_form').trigger('submit');
                }
            });

            // Function to show the loader
            function showLoader() {
                $('#loader').show();
                $('.customTab-content-1, .googleWraper, .custom-pagination').hide();
            }

            // Function to handle form submission
            function handleFormSubmission() {
                setTimeout(function() {
                    $('.customTab-content-1, .googleWraper, .custom-pagination').show();
                    $('#loader').hide();
                }, 2000);
            }

            // Hide the loader initially
            $('#loader').hide();

        });
    })(jQuery);
</script>
<script>
    $(document).ready(function() {
        // empty check
        $(document).on('click', '.setLocation_btn', function() {
            var get_home_search_value = $('#home_search').val();
            var errorMessage = 'Please enter a search term.';
            if (get_home_search_value === null || get_home_search_value === "") {
                toastr.warning(errorMessage);
                $(this).prop("disabled", true);
            }
        });

        // empty check
        $("#home_search").on('keyup click change', function() {
            var home_search_value = $(this).val();
            if (home_search_value === null || home_search_value === "") {
                $('.setLocation_btn').attr('disabled', 'disabled');
            } else {
                $('.setLocation_btn').removeAttr('disabled');
            }
        });
    });
</script>


<script>
    //toastr warning
    function toastr_warning_js(msg) {
        Command: toastr["warning"](msg, "Warning !")
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }

    //toastr success
    function toastr_success_js(msg) {
        Command: toastr["success"](msg, "Success !")
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }

    //toastr error
    function toastr_error_js(msg) {
        Command: toastr["error"](msg, "Error !")
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }
</script>
<script>
    function slickSliderConfiguration() {
        let global = document.querySelectorAll('.global-slick-init');
        global.forEach(function(element, index) {
            let parentBoxWidth = element.clientWidth;
            let childCount = element.querySelectorAll('.category-slider-item, .testimonial-item')?.length ?? 0;
            let childItemWidth = element.querySelector('.category-slider-item, .testimonial-item')
                ?.clientWidth ?? 0;
            if (childCount !== 0 && childItemWidth !== 0) {
                if ((childCount * childItemWidth) < parentBoxWidth) {
                    let targetSwipeDiv = element.parentElement.parentElement.parentElement.querySelector(
                        '.testimonial-arrows');
                    targetSwipeDiv.classList.add('d-none');
                    targetSwipeDiv.parentElement.classList.remove('mt-5')
                }
            }
        })
    }
    window.addEventListener('load', slickSliderConfiguration, false);
    window.addEventListener('resize', slickSliderConfiguration, false);
</script>

<!-- google map for live location -->
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmhubfH-tz1yy06iiLe6Srrk107TJTjtU&libraries=places&v=3.46.0">
</script>

<script>
    // Function to get a cookie
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }
</script>

<script>
    // Cookie add set of time
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    // if  Cookie id null
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    // Function to get the visitor's country and coordinates
    function getVisitorLocation() {
        // Check if the Geolocation API is supported
        if (navigator.geolocation) {
            // Get the visitor's current position
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                // Store the latitude and longitude in localStorage
                localStorage.setItem('latitude', latitude);
                localStorage.setItem('longitude', longitude);

                // Create a new Geocoder object
                var geocoder = new google.maps.Geocoder();
                // Prepare the latitude and longitude values as a LatLng object
                var latLng = new google.maps.LatLng(latitude, longitude);

                // Reverse geocode the coordinates to get the address
                geocoder.geocode({
                    'location': latLng
                }, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            // Get the country component from the address
                            var address = results[0].formatted_address;
                            var placeId = results[0].place_id;
                            var country = '';
                            for (var i = 0; i < results[0].address_components.length; i++) {
                                var component = results[0].address_components[i];
                                if (component.types.includes('country')) {
                                    country = component.long_name;
                                    break;
                                }
                            }


                            $('#myLocationGetAddress').on('click', function() {
                                if ('permissions' in navigator) {
                                    // Request location permission using the Permissions API
                                    navigator.permissions.query({
                                        name: 'geolocation'
                                    }).then(function(permissionStatus) {
                                        if (permissionStatus.state === 'granted') {
                                            // Location permission granted
                                            $("#autocomplete").val(address);
                                        } else if (permissionStatus.state ===
                                            'prompt') {
                                            // Location permission prompt
                                            permissionStatus.onchange = function() {
                                                if (permissionStatus.state ===
                                                    'granted') {
                                                    // Location permission granted
                                                    $("#autocomplete").val(address);
                                                }
                                            };
                                            permissionStatus.prompt();
                                        }
                                    });
                                } else if ('geolocation' in navigator) {
                                    // Request location permission using the Geolocation API
                                    navigator.geolocation.getCurrentPosition(function(
                                        position) {
                                        // Location permission granted
                                        $("#autocomplete").val(address);
                                    }, function(error) {});
                                }
                            });

                            // Display the stored place ID
                            var storedPlaceId = getCookie('placeId');
                        }
                    }
                });
            }, function() {});
        }
    }
    getVisitorLocation();
</script>
<!-- autocomplete address js start -->
<script>
    $(document).ready(function() {
        $("#latitudeArea").addClass("d-none");
        $("#longtitudeArea").addClass("d-none");
    });
</script>

<!-- search user address wise-->
<script>
    $(document).ready(function() {
        $('#autocomplete').on('keyup change click', function() {
            var input = document.getElementById("pac-input");
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.setFields(["address_components", "geometry"]);
            autocomplete.addListener("place_changed", function() {
                var place = autocomplete.getPlace();
                if (!place.geometry || !place.geometry.location) {
                    return;
                }
                // Get the latitude and longitude of the selected place
                let selectedLatitude = place.geometry.location.lat();
            });
        });
    });
</script>

<script>
    google.maps.event.addDomListener(window, 'load', initialize);

    // Function to set a cookie
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    // Function to get a cookie
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function initialize() {
        var input = document.getElementById('autocomplete');
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            $('#latitude').val(place.geometry.location.lat());
            $('#longitude').val(place.geometry.location.lng());
            $("#latitudeArea").removeClass("d-none");
            $("#longitudeArea").removeClass("d-none");
            $("#change_address_new").val(1);

            // Check if stored placeId exists
            var storedPlaceId = getCookie('placeId');
            var placeId = place.place_id;
            var currentPlaceId;
            if (storedPlaceId) {
                currentPlaceId = placeId;
                if (currentPlaceId !== storedPlaceId) {
                    // Remove old cookies
                    document.cookie = "placeId=;expires=" + new Date(0).toUTCString();
                    document.cookie = "address=;expires=" + new Date(0).toUTCString();
                }
            }
            setCookie('placeId', placeId, 7);
            setCookie('address', place.formatted_address, 7);
        });


        $('.setLocation_btn').on('click', function() {
            var changeAddress = $('#change_address_new').val();
            if (changeAddress === '') {
                // User didn't change the address, use current location-wise service
                var place = autocomplete.getPlace();

                if (typeof place !== 'undefined' && place.hasOwnProperty('place_id') && place.hasOwnProperty(
                        'formatted_address')) {
                    var placeId = place.place_id;
                    var address = place.formatted_address;
                    var id_add = setCookie('placeId', placeId, 7);
                    var add_add = setCookie('address', address, 7);
                }

            }
        });
    }
</script>
<!-- location address validation -->
<script>
    $(document).ready(function() {
        // remove  disabled
        var autocompleteInput = $('#autocomplete');
        autocompleteInput.on('keyup click change', function() {
            var getAutocompleteInputValue = $('#autocomplete').val();
            if (getAutocompleteInputValue !== null) {
                $('.setLocation_btn').removeAttr('disabled');
            } else {
                $(this).prop("disabled", false);
            }
        });

    });
</script>
<!-- autocomplete address js end -->
