/**
 * Created by rzyuzin on 11.11.2015.
 */
var cartAddress = null;

function blockWindow()
{
    $.blockUI({
        css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#fff',
            width:'20%'
        },
        message: 'Loading...'
    });
}

function unblockWindow()
{
    $.unblockUI();
}

function displayPleaseWait() {
    $('#pleaseWait').modal();
}

function closePleaseWait() {
    $('#pleaseWait').modal('hide');
}

function displayMessage(title, message) {
    $('#messageModal h4').html(title);
    $('#messageModal #messageContent').html(message);
    $('#messageModal').modal();
}

function closeMessage() {
    $('#messageModal').modal('hide');
}

function showAddressForm(title)
{
    $('#addressModal h4').html(title);
    $('#addressModal').modal();
}

$(function () {
    $('#query').on('keyup', function() {
        if ($(this).val().length > 2)
        {
            $.ajax({
                type: 'POST',
                async: true,
                url: baseUrl + 'search',
                dataType: 'html',
                data: {
                    query: $(this).val()
                },
                success: function(html) {
                    $('#ajaxSearch .ajax-result').html(html);
                    $('#ajaxSearch').fadeIn();
                    $(window).trigger('resize');
                },
            });
        }
    });

    $('#closeSearch').on('click', function() {
        $('#ajaxSearch').fadeOut();
    });

    $('#closeMessageModal').on('click', function() {
        closeMessage();
    });

    var isotopeLength = 0;
    var isotopeItems = [];

    var initIsotopeBorders = function() {
        if ($('.elem-container').length) {
            $('.elem div.borders').remove();

            $('.elem-container').each(function(index, element) {
                var $container = $(this),
                    $bottomRight = '<div class="borders bottom right"></div>',
                    $bottomLeft = '<div class="borders bottom left"></div>',
                    $topRight = '<div class="borders top right"></div>',
                    $topLeft = '<div class="borders top left"></div>',
                    $row = 1,
                    $elemWidth = $(this).children('.elem').outerWidth(true),
                    $elemLength = 0;

                if (isotopeLength == 0)
                {
                    $(this).children('.elem').each(function(index, element) {
                        if ($(this).css('display') != 'none')
                        {
                            ++$elemLength;
                        }
                    });
                }
                else
                {
                    $elemLength = isotopeLength;
                }

                var $colNumber = parseInt($container.outerWidth(true) / $elemWidth);
                var $rowNumber = Math.ceil($elemLength / $colNumber);
                //console.log($rowNumber);

                var idx = 0;

                var arr = [];

                var is_chrome = /chrome/.test(navigator.userAgent.toLowerCase());

                if (isotopeItems.length)
                {
                    for (var i = 0; i < isotopeItems.length; ++i)
                    {

                        $id = '#' + isotopeItems[i].element.id;

                        var is_isotope = $($id).hasClass('isotope');

                        if ($rowNumber == 1)
                        {
                        }
                        else if (idx == 0 && $elemLength > 1 && $rowNumber > 1 && $colNumber > 1) {
                            $($id).prepend($bottomRight);
                            if (is_chrome && is_isotope)
                            {
                                $($id).css('left', '-1px');
                            }
                        }
                        else if ($row == 1 && (idx + 1) % $colNumber == 0 && $rowNumber > 1 && $colNumber > 1)
                        {
                            $($id).prepend($bottomLeft);
                        }
                        else if ($row == 1 && $rowNumber > 1 && $colNumber > 1)
                        {
                            $($id).prepend($bottomLeft).prepend($bottomRight);
                        }
                        else if ($row > 1 && idx % $colNumber == 0 && $row == $rowNumber && $colNumber > 1)
                        {
                            $($id).prepend($topRight);
                            if (is_chrome && is_isotope)
                            {
                                $($id).css('left', '-1px');
                            }
                        }
                        else if (idx % $colNumber == 0 && $row < $rowNumber && $colNumber > 1)
                        {
                            $($id).prepend($bottomRight).prepend($topRight);
                            if (is_chrome && is_isotope)
                            {
                                $($id).css('left', '-1px');
                            }
                        }
                        else if ($row == $rowNumber && (idx + 1) % $colNumber == 0 && $colNumber > 1)
                        {
                            $($id).prepend($topLeft);
                        }
                        else if ($row > 1 && (idx + 1) % $colNumber == 0 && $colNumber > 1)
                        {
                            $($id).prepend($topLeft).prepend($bottomLeft);
                        }
                        else if ($row < $rowNumber && $colNumber > 1)
                        {
                            $($id).prepend($bottomLeft).prepend($bottomRight).prepend($topLeft).prepend($topRight);
                        }
                        else if ($row == $rowNumber && $colNumber > 1)
                        {
                            $($id).prepend($topLeft).prepend($topRight);
                        }

                        if ((idx + 1) % $colNumber == 0)
                        {
                            ++$row;
                        }

                        ++idx;
                    }
                }
                else
                {
                    $(this).children('.elem').each(function() {

                        var is_isotope = $(this).hasClass('isotope');

                        if ($rowNumber == 1)
                        {
                        }
                        else if (idx == 0 && $elemLength > 1 && $rowNumber > 1 && $colNumber > 1) {
                            $(this).prepend($bottomRight);
                            if (is_chrome && is_isotope)
                            {
                                $(this).css('left', '-1px');
                            }
                        }
                        else if ($row == 1 && (idx + 1) % $colNumber == 0 && $rowNumber > 1 && $colNumber > 1)
                        {
                            $(this).prepend($bottomLeft);
                        }
                        else if ($row == 1 && $rowNumber > 1 && $colNumber > 1)
                        {
                            $(this).prepend($bottomLeft).prepend($bottomRight);
                        }
                        else if ($row > 1 && idx % $colNumber == 0 && $row == $rowNumber && $colNumber > 1)
                        {
                            $(this).prepend($topRight);
                            if (is_chrome && is_isotope)
                            {
                                $(this).css('left', '-1px');
                            }
                        }
                        else if (idx % $colNumber == 0 && $row < $rowNumber && $colNumber > 1)
                        {
                            $(this).prepend($bottomRight).prepend($topRight);
                            if (is_chrome && is_isotope)
                            {
                                $(this).css('left', '-1px');
                            }
                        }
                        else if ($row == $rowNumber && (idx + 1) % $colNumber == 0 && $colNumber > 1)
                        {
                            $(this).prepend($topLeft);
                        }
                        else if ($row > 1 && (idx + 1) % $colNumber == 0 && $colNumber > 1)
                        {
                            $(this).prepend($topLeft).prepend($bottomLeft);
                        }
                        else if ($row < $rowNumber && $colNumber > 1)
                        {
                            $(this).prepend($bottomLeft).prepend($bottomRight).prepend($topLeft).prepend($topRight);
                        }
                        else if ($row == $rowNumber && $colNumber > 1)
                        {
                            $(this).prepend($topLeft).prepend($topRight);
                        }

                        if ((idx + 1) % $colNumber == 0)
                        {
                            ++$row;
                        }

                        ++idx;
                    });
                }
            });
        }
    };

    $(window).on('resize', function() {

        initIsotopeBorders();

        $('.cart-item .td').each(function(index, element) {
            var parent = $(this).parents('.cart-item');
            $(this).css('padding-top', (parent.height() - $(this).height()) / 2);
        });

        var paymentPadding = 0;
        $('.payment-left').height(function() {
            paymentPadding = ($('.payment').height() - $('.payment-left').height() - 40) / 2;
            return $('.payment-left').height($('.payment').height() - 40 - paymentPadding);
        }).css('padding-top', function() {
            return paymentPadding + 20 + 'px';
        });

    });

    $(window).trigger('resize');

    if ($('#carrier').length) {
        $('#carrier').dropkick({
            mobile: true,
            change: function () {
                var mem = $('#memory').val(),
                    filter = '';
                if (mem != 'all') {
                    filter = '.' + mem;
                }
                if (this.value != 'all') {
                    filter += '.carrier_' + this.value;
                }
                $('.elem div.borders').remove();
                $('.selector').isotope({filter: filter});
            }
        });
    }

    if ($('#memory').length) {
        $('#memory').dropkick({
            mobile: true,
            change: function () {
                var carr = $('#carrier').val(),
                    filter = '';
                if (carr != 'all') {
                    filter = '.' + carr;
                }
                if (this.value != 'all') {
                    filter += '.' + this.value;
                }
                $('.elem div.borders').remove();
                $('.selector').isotope({filter: filter});
            }
        });
    }

    if ($('.selector').length) {
        $('.selector')
            .isotope({layoutMode: 'fitRows'})
            .isotope('reloadItems')
            .isotope('on', 'layoutComplete', function (laidOutItems) {
                isotopeLength = laidOutItems.length;
                isotopeItems = laidOutItems;
                $(window).trigger('resize');
            });
    }

    var conditionCentering = function() {
        $('.btn-condition.btn-group > .btn div.right').each(function() {
            $(this).siblings('.left')
                .css('padding-top', 0)
                .css('padding-bottom', 0);
            var padding = (parseInt($(this).actual( 'outerHeight', { includeMargin : true })) - $(this).siblings('.left').actual( 'outerHeight', { includeMargin : true })) / 2;
            $(this).siblings('.left')
                .css('padding-top', padding)
                .css('padding-bottom', padding);
        });
    };

    if(jQuery().actual) {
        conditionCentering();
    }

    var phoneDialogPanelsCentering = function () {
        if ($(window).width() > 800)
        {
            var conditionRadios = $('#conditionRadioSingle').length ? $('#conditionRadioSingle') : $('#conditionRadio');

            var leftHeight = parseInt(conditionRadios.actual('outerHeight', { includeMargin : true })) - 10;
            var rightHeight = parseInt($('.phone-desc-wrapper').actual('outerHeight', { includeMargin : true }));

            if (leftHeight < rightHeight)
            {
                conditionRadios.height(rightHeight);
            }
            else
            {
                $('.phone-desc-wrapper').height(leftHeight);
            }

            $('.phoneCart').width($('.phone-desc-wrapper').width());

            $('.phone-img-wrapper').css('margin-top', function() {
                var height = $(this).next().offset().top - $(this).prev().offset().top - parseInt($(this).prev().outerHeight(true)) - $(this).height();
                return 0;//height / 2;
            });
        }
    };

    if ($('#conditionRadioSingle').length) {
        phoneDialogPanelsCentering();
    }

    $('.share-btn').each(function(index, element) {
        var sharer = $(this).attr('data-sharer');
        $(this).attr('data-url', sharer + phoneUrl);
    });

    $('.share-btn').on('click', function() {
        var left = (screen.width / 2) - (width / 2),
            top = (screen.height / 2) - (height / 2),
            width = screen.width / 2,
            height = screen.height / 2,
            url = $(this).attr('data-url');
        window.open(
            url,
            "",
            "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width="
            + width + ",height=" + height + ",top=" + top + ",left=" + left
        );

        var bonus = parseInt($('#shareBonus').val());

        $('.perfect-cost').text('$' + (parseInt($('#perfectCost').val()) + bonus));
        $('.good-cost').text('$' + (parseInt($('#goodCost').val()) + bonus));
        $('.fair-cost').text('$' + (parseInt($('#fairCost').val()) + bonus));

        googleShare = 1;
    });

    if ($('.accordion').length) {
        $('.accordion').accordion({
            collapsible: true,
            heightStyle: "content",
            active: false
        });
    }

    if ($('#hiwTabs').length) {
        $('#hiwTabs').tabs({
            event: 'mouseover',

        });
    }

    //$('#conditionRadio, #conditionRadioSingle, #editConditionRadio').buttonset();

    $('.button').button();

    $('body').on('click', '.selector .elem', function(e) {
        e.preventDefault();
        var phoneId = $(this).attr('data-id'),
            carrierId = $(this).attr('data-carrier');

        showPhone(phoneId, carrierId);
    });

    var showPhone = function(phoneId, carrierId)
    {
        if (phoneId && carrierId)
        {
            blockWindow();
            $.ajax({
                url: baseUrl + 'phone/get-phone',
                async: true,
                type: 'POST',
                dataType: 'html',
                data: {
                    phoneId: phoneId,
                    carrierId: carrierId
                },
                success: function(response)
                {
                    response = $.parseJSON(response);
                    var item = response.item;
                    var firm = response.firm;
                    var price = response.price;
                    var carrier = response.carrier;

                    if (item != null)
                    {
                        $('#phoneID').val(phoneId);
                        $('#carrierID').val(carrierId);

                        $('.phone-img img').prop('src', baseUrl + 'uploads/phone/thumb_' + item.image);
                        $('.perfect-cost').text('$' + price.price_good);
                        $('.good-cost').text('$' + price.price_fair);
                        $('.fair-cost').text('$' + price.price_poor);
                        $('.phone-name, .phone-desc-wrapper h2').text(firm.name + ' ' + item.name);
                        $('.phone-carrier span').text(carrier.name);

                        $('#perfectCost').val(price.price_good);
                        $('#goodCost').val(price.price_fair);
                        $('#fairCost').val(price.price_poor);

                        $("#addPhoneDlg").modal();

                        conditionCentering();

                        phoneDialogPanelsCentering();
                    }
                },
                complete: function() {
                    unblockWindow();
                }
            });
        }
    };

    $('#addPhoneDlg').on('hidden.bs.modal', function (e) {
        $('#conditionRadio, .phone-desc-wrapper').height('auto');
        $('#phoneID').val(0);
        $('#carrierID').val(0);
        $('#perfectCost').val(0);
        $('#goodCost').val(0);
        $('#fairCost').val(0);
        $('.btn-condition label').removeClass('active');
        $('label[for="conditionPerfect"]').addClass('active');
        $('#conditionPerfect').prop('checked', true);
    });

    $('#phoneContinue').on('click', function(e) {
        e.preventDefault();
        addCartItem('add', '');
    });

    $('.phoneCart').on('click', function(e) {
        e.preventDefault();
        addCartItem('cart', '');
    });

    $('.phoneCartSingle').on('click', function(e) {
        e.preventDefault();
        addCartItem('cart', 'Single');
    });

    var addCartItem = function (action, single)
    {
        var condition = $('[name="conditionRadio'+single+'"]:checked').val(),
            phoneId = $('#phoneID'+single).val(),
            carrierId = $('#carrierID'+single).val(),
            cost = $('[name="conditionRadio'+single+'"]:checked').siblings('.left').find('.cost').text();

        //cost = cost.find('.cost').text();
        cost = cost.substring(1, cost.length);

        blockWindow();

        $("#addPhoneDlg").modal('hide');

        $.ajax({
            url: baseUrl + 'cart/add-item',
            async: true,
            type: 'POST',
            dataType: 'html',
            data: {
                phoneId: phoneId,
                carrierId: carrierId,
                condition: condition,
                cost: cost
            },
            success: function(response)
            {
                response = $.parseJSON(response);

                var path = window.location.pathname.split('/')
                var reloadCart = false;
                for (var  i = 0; i < path.length; ++i)
                {
                    if (path[i] == 'cart') {
                        reloadCart = true;
                    }
                }

                if (action == 'cart' || reloadCart) {
                    window.location.href = baseUrl + 'cart/'
                } else {
                    updateMyCart(response);
                    unblockWindow();
                }
            }
        });
    };

    $('.cart-edit').on('click', function(e) {
        e.preventDefault();
        var parent = $(this).parents('.cart-item');

        var phone_id = parent.attr('data-id'),
            carrier_id = parent.attr('data-carrier'),
            state = parent.attr('data-state'),
            positionId = parent.attr('data-ajax'),
            number = parent.attr('data-number');

        if (phone_id && carrier_id)
        {
            blockWindow();
            $.ajax({
                url: baseUrl + 'phone/get-phone',
                async: true,
                type: 'POST',
                dataType: 'html',
                data: {
                    phoneId: phone_id,
                    carrierId: carrier_id
                },
                success: function(response)
                {
                    response = $.parseJSON(response);
                    var item = response.item;
                    var firm = response.firm;
                    var price = response.price;
                    var carrier = response.carrier;

                    if (item != null)
                    {

                        $('#editPhoneID').val(phone_id);
                        $('#editCarrierID').val(carrier_id);
                        $('#editCoockie').val(positionId);
                        $('#editNumber').val(number);

                        $('.perfect-cost').text('$' + price.price_good);
                        $('.good-cost').text('$' + price.price_fair);
                        $('.fair-cost').text('$' + price.price_poor);

                        $('.btn-condition label').removeClass('active');
                        $('[name="editConditionRadio"][value="'+state+'"]').parent('label').addClass('active');
                        $('[name="editConditionRadio"][value="'+state+'"]').attr('checked', true);

                        $("#editPhoneDlg").modal();

                        conditionCentering();
                    }
                },
                complete: function() {
                    unblockWindow();
                }
            });
        }
    });

    $('#editPhoneCart').on('click', function(e) {
        e.preventDefault();
        updateCartItem();
    });

    var updateCartItem = function ()
    {
        var condition = $('[name="editConditionRadio"]:checked').val(),
            positionId = $('#editCoockie').val();

        blockWindow();

        $("#editPhoneDlg").modal('hide');

        $.ajax({
            url: baseUrl + 'cart/update-item',
            async: false,
            type: 'POST',
            dataType: 'html',
            data: {
                condition: condition,
                positionId: positionId
            },
            success: function()
            {
                window.location.href = baseUrl + 'cart';
            }
        });
    };

    var updateMyCart = function (data)
    {
        $('.my-cart').addClass('header-cart-link');
        $('.header-positions').text('(' + data.totalPositions + ')');
        $('.header-total').text('$' + data.totalCost);

        $('.total span').text(data.totalCost);
    };

    $('.cart-item .item-count').on('change', function() {
        if ($(this).val() == 0) $(this).val(1);
        var positionId = $(this).parents('.cart-item').attr('data-ajax');
        $.ajax({
            url: baseUrl + 'cart/update-item-qty',
            async: true,
            type: 'POST',
            dataType: 'html',
            data: {
                positionId: positionId,
                value: $(this).val()
            },
            success: function(response)
            {
                response = $.parseJSON(response);
                updateMyCart(response);
            }
        });
    });

    $('#getPromo').on('click', function(e) {
        e.preventDefault();

        if ($('#promo').val().length)
        {
            $('#getPromo').next('p').remove();
            blockWindow();
            $.ajax({
                url: baseUrl + 'cart/apply-promo',
                async: true,
                type: 'POST',
                dataType: 'html',
                data: {
                    code: $('#promo').val()
                },
                success: function(response)
                {
                    response = $.parseJSON(response);

                    if (response.error == '') {
                        $('#promo_type').val(response.promoType);
                        $('#promo_number').val(response.promoCost);
                        $('#promo_price').val(response.promoTotal);

                        updateMyCart(response);
                    } else {
                        $('#promo_type').val('');
                        $('#promo_number').val(0);
                        $('#promo_price').val(0);
                        updateMyCart(response);
                        displayMessage('Not found', response.error);
                    }
                },
                complete: function() {
                    unblockWindow();
                }
            });
        }
    });

    if ($('.promo-right').height() > $('.promo-left').height()) {
        var padding = ($('.promo-right').height() - $('.promo-left').height()) / 2;
        $('.promo-left').height($('.promo-right').height() - padding).css('padding-top', padding + 20);
    } else {
        var padding = ($('.promo-left').height() - $('.promo-right').height()) / 2;
        $('.promo-right').height($('.promo-left').height() - padding).css('padding-top', padding + 20);
    }

    $('.shipping-radio input[type="radio"]:first').attr('checked', true);

    $('.shipping-radio').each(function(index, element) {
        $(this).css('margin-top', ($(this).siblings('.shipping-info').height() - $(this).height()) / 2);
    });

    if ($('.shipping-right').height() > $('.shipping-left').height()) {
        var padding = ($('.shipping-right').height() - $('.shipping-left').height()) / 2;
        $('.shipping-left').height($('.shipping-right').height() - padding).css('padding-top', padding + 20);
    } else {
        var padding = ($('.shipping-left').height() - $('.shipping-right').height()) / 2;
        $('.shipping-right').height($('.shipping-left').height() - padding).css('padding-top', padding + 20);
    }

    $('[name="check"]').on('focus', function() {
        $('[name="payment_type"][value="1"]').click();
    });

    $('[name="confirm_email"], form[name="payment"] [name="email"]').on('focus', function() {
        $('[name="payment_type"][value="0"]').click();
    });

    $('input[name=payment_type]').change(function() {
        $('.' + $('input[name=payment_type]:not(:checked)').attr('id')).fadeOut('fast');

        $('.' + $('input[name=payment_type]:checked').attr('id')).fadeIn('slow');

        if ($('input[name=payment_type]:checked').val() == 0)
        {
            $('.payment-address-form').slideUp();
        }
        else if (cartAddress != null && cartAddress.value == 0)
        {
            $('.payment-address-form').slideDown();
        }
    });

    if ($('#cartAddress').length) {
        $('#cartAddress').dropkick({
            mobile: true,
            initialize: function () {
                cartAddress = this;
            },
            change: function () {
                if (this.value == 0) {
                    getAddressForm(null);
                }
            }
        });
    }

    if ($('#orderAddress').length) {
        $('#orderAddress').dropkick({
            mobile: true,
            initialize: function () {
                cartAddress = this;
            },
            change: function () {
                if (this.value == 0) {
                    getAddressForm(null);
                }
            }
        });
    }

    $('.btn-add-address').on('click', function(e) {
        e.preventDefault();
        getAddressForm(null);
    });

    $('.btn-edit-address').on('click', function(e) {
        getAddressForm($(this).parent().attr('data-address'));
    });

    function getAddressForm(id)
    {
        $.ajax({
            url: baseUrl + 'user/get-address-form',
            async: false,
            type: 'POST',
            dataType: 'html',
            data: { id: id },
            success: function(response)
            {
                $('#addressContent').html(response);
                showAddressForm('Delivery address');
            }
        });
    }

    $('#closeAddressModal').on('click', function() {
        $('#addressModal').modal('hide');
    });

    $('#saveAddress').on('click', function() {
        $('#payment-address-form').submit();
    });

    $('#addressModal').on('hidden.bs.modal', function () {
        if (cartAddress) cartAddress.reset(true);
    });

    $('.table-orders tbody tr:odd, .table-order-items tbody tr:odd').addClass('odd');

    $('.table-orders tbody tr:last td:first').addClass('ui-corner-bl');

    $('.table-orders tbody tr:last td:last').addClass('ui-corner-br');

    $('.table-order-items tbody tr:last').removeClass('odd');

    $('.payment_button').click(function() {
        var submitOrder = true;
        if (!$(':radio').is(':checked')) {
            displayMessage('Error:', 'Select payment type.');
            return false;
        } else {
            var payment_type = $('input[name=payment_type]:checked').val();
            var regular = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+$/;

            if (payment_type == 0) {
                var emailPaypal = $('#emailPaypal').val();
                var confirm_email = $('#confirm_email').val();

                if (emailPaypal == '' || confirm_email == '' || !regular.test(emailPaypal) || !regular.test(confirm_email)) {
                    displayMessage('Error:', 'Please enter you PayPal e-mail address.');
                    return false;
                } else if (confirm_email != emailPaypal) {
                    displayMessage('Error:', 'Please correct your PayPal e-mail.');
                    return false;
                }
            }

            if (payment_type == 1) {
                var check = $('[name="check"]').val();
                var address = cartAddress != null ? cartAddress.value : '';

                if (address == undefined) {
                    displayMessage('Error', 'You must choose address.');
                    return false;
                } else if (check.length == 0) {
                    displayMessage('Error:', 'Please fill out Payable to');
                    return false;
                }
            }

            blockWindow();

            var error = '';

            if (isGuest) {
                // LOGIN
                var emailLogin = $('#login-form #user-email').val();
                var passwordLogin = $('#login-form #user-password').val();
                var remember = $('[name="remember"]:checked').val();
                var login = false;
                var register = false;

                if (emailLogin != '' && passwordLogin != '') {
                    $.ajax({
                        url: baseUrl + 'cart/login-user',
                        type:'POST',
                        async:false,
                        data: {
                            User: {
                                email: emailLogin,
                                to_red: 0,
                                password: passwordLogin,
                                remember: remember
                            }
                        },
                        success: function(response) {
                            if(response == 1) {
                                login = true;
                            } else {
                                error = $.parseJSON(response);
                            }
                        }
                    });
                }

                // REGISTER
                var email = $('#register-form #user-email').val();
                var password = $('#register-form #user-password').val();
                var confirm_password = $('#register-form #user-confirm').val();
                var first_name = $('#register-form #user-first_name').val();
                var last_name = $('#register-form #user-last_name').val();
                var phone = $('#register-form #user-phone').val();
                var to_red = 0;
                var line_1 = $('#register-form #useraddress-line_1').val();
                var line_2 = $('#register-form #useraddress-line_2').val();
                var city = $('#register-form #useraddress-city').val();
                var state = $('#register-form #useraddress-state').val();
                var zip = $('#register-form #useraddress-zip').val();


                if (phone != '' && email != '' && password != '' && confirm_password != '' && first_name != '' &&
                    last_name != '' && line_1 != '' && city != '' && state != 0 && zip != '') {
                    if (password != confirm_password) {
                        error = {message:['Password does not match the confirm password.']};
                    } else {
                        if (!regular.test(email)) {
                            error = {message:['Wrong e-mail format.']};
                        } else {
                            if ($('#user-terms').prop("checked")) {
                                $.ajax({
                                    url: baseUrl + 'cart/register-user',
                                    type:'POST',
                                    async: false,
                                    data: {
                                        User: {
                                            email: email,
                                            password: password,
                                            confirm: confirm_password,
                                            first_name: first_name,
                                            last_name: last_name,
                                            to_red: to_red,
                                            phone: phone
                                        },
                                        UserAddress: {
                                            line_1: line_1,
                                            line_2: line_2,
                                            city: city,
                                            state: state,
                                            zip: zip
                                        },
                                        address: 1
                                    },
                                    success: function(response) {
                                        if(response > 0) {
                                            register = true;
                                            $('[name="address"]').val(response);

                                        } else {
                                            error = $.parseJSON(response);
                                        }
                                    }
                                });
                            } else {
                                error = {message:['You must read and accept terms & conditions.']};
                            }
                        }
                    }
                }

                if (!login && !register) {
                    if (error) {
                        var errorStr = '';
                        $.each(error, function(index, value) {
                            for (var i = 0; i < value.length; ++i) {
                                errorStr += value[i] + '<br>';
                            }
                        });
                    } else {
                        errorStr = 'Your contact information is not complete. Please double check.';
                    }
                    displayMessage('Error:', errorStr);
                    submitOrder = false;
                }
            }

            if (submitOrder) {
                $('form[name="completeOrder"]').submit();
            } else {
                unblockWindow();
            }
        }
    });
});

function isLocalStorage() {
    try {
        return 'localStorage' in window && window['localStorage'] !== null;
    } catch (e) {
        return false;
    }
}

if (isLocalStorage()) {
    //var foo = localStorage.getItem("bar");
    console.log(localStorage);
}