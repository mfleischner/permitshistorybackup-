$(document).ready(function() {
    $("#phone").inputmask("(999) 999-9999");
    $("#altphone").inputmask("(999) 999-9999");
    $("#companyphone").inputmask("(999) 999-9999");
    var url = window.location.origin; /* 'http://localhost/permitsearch/public';*/
    $('#errorSpanC').show().delay(4000).fadeOut('slow');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /** Clear the search result dropdown when click on the outside **/
    $(document).on('click', function() {
        $('.droplistResult').html('');
        $('.droplistResult').hide();
    });

    // $(document).on('click', '.slctSEcRs', function(e) {
    //     var text = $(this).html();
    //     var id = $(this).data('val');
    //     $('#searchPRHD').val(id);
    //     $('#searchPR').val(text);
    //     $('.droplistResult').html('');
    //     $('.droplistResult').hide();
    //     window.location.href = url + '/search-result/' + id;
    // });

    $(document).on('click', '#contAddress, .contAddress', function() {
        var price = $('input[name="pricePlan"]:checked').val();
        var listing = $('#package-selectID');
        if (price == '') {
            console.log('Please checked one of the option');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: url + '/getPrice',
                data: { "id": price },
                success: function(result) {
                    //console.log(result);
                    listing.html('');
                    var html = '';
                    $(result).each(function(i) {
                        html += '<div class="package-select-name">' + result[i].title + '</div>';
                        html += '<ul><li class="show-price"><i class="fa fa-circle price"></i> $' + result[i].price + '</li>';
                        html += '<ul><li><i class="fa fa-circle"></i>&nbsp;' + result[i].report + '</li>';
                        html += '<ul><li><i class="fa fa-circle"></i>&nbsp;' + result[i].description + '</li>';
                    });
                    listing.html(html);
                    $('#priceIDVal').val(result[0].id);
                    $(".pricePOPUP").css("display", "none");
                    $('.accountPOPUP').css('display', 'block');
                }
            });
        }
    });

    $(document).on('click', '#bkBTNPOP', function() {
        $(".pricePOPUP").css("display", "block");
        $('.accountPOPUP').css('display', 'none');
    });

    $(document).on('click', '#priceBkPOP', function() {
        $(".accountLoginPOPUP").css("display", "none");
        $(".pricePOPUP").css("display", "block");
    });

    $(document).on('click', '#loginPOP', function() {
        $('#priPopUp').data("val", "Hide");
        $(".accountLoginPOPUP").css("display", "block");
        $("#priPopUp").css("display", "none");
    });

    $(document).on('click', '.buy-now', function() {
        var price = $(this).data('val');
        $('#priPopUp').show();
        $('#priPopUp').data("val", "Hide");
        $("#priPopUp").find("#radio_" + price).prop("checked", true);
    });

    $(window).load(function() {
        if (pricing_page_flag != true) {
            $('#priPopUp').delay(500).fadeIn('slow');
            $('body').bind('mousemove', function(e) {
                if ($('#priPopUp').data("val") == "show") {
                    $('#priPopUp').show();
                    $('#priPopUp').data("val", "Hide");
                }
            });
        }
    });

    $(document).on('click', '#logSubmitForm', function() {
        $('#priPopUp').data("val", "Hide");
        $("#priPopUp").css("display", "none");
        var email = $('#logEmail').val();
        if (email == '') {
            $('#logEmail').focus();
            $('.logErrClass').html('<div class="alert alert-danger">please enter valid email address.</div>').show().delay(4000).fadeOut("slow");
            return false;
        } else if ($('#logPass').val() == '') {
            $('#logPass').focus();
            $('.logErrClass').html('<div class="alert alert-danger">please enter password.</div>').show().delay(4000).fadeOut("slow");
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: url + '/login/account',
                data: { 'email': email, 'password': $('#logPass').val() },
                success: function(result) {
                    //console.log(result);
                    if (result == 'error') {
                        $('.logErrClass').html('<div class="alert alert-danger">Email & password does not match.</div>').show().delay(4000).fadeOut("slow");
                    } else if (result == "success") {
                        $('.logErrClass').html('<div class="alert alert-success">Login successfully.</div>').show().delay(4000).fadeOut("slow");
                        window.setTimeout(function() {
                            if (pricing_page_flag) {

                                var price_id = $('#priPopUp').find('input[type="radio"]:checked').val();
                                //console.log(price_id);
                                window.location.href = "/buy-subscription/" + price_id;
                                //window.location.href = "/pricing";
                            } else
                                window.location.href = "/dashboard/permit";
                        }, 2000);
                        exit();
                    } else if (result == 'permit-request-credits-handle') {
                        // $('.display-yes-credits-popup').addClass('show');
                        window.location.href = "/dashboard/permit-requests?request=new";
                    }

                }
            });
        }
    });

    $('#SchooRESpan').show().delay(4000).fadeOut('slow');
    $('#successStatusMsg1').show().delay(4000).fadeOut('slow');

    $('#submitAddressRequest').on('click', function() {
        var url = window.location.origin;
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var email = $('#email_address').val();
        // var property_house_no = $('#property_house_no').val();
        // var property_house_no_prefix = $('#span_property_house_no_prefix').val();
        // var property_direction = $('#property_direction').val();
        var property_street_name = $('#property_street_name').val();
        var property_city = $('#property_city').val();
        var zip_code = $('#zip_code').val();
        var property_state = $('#property_state').val();
        var purchase_with_in = $('#purchase_with_in').val();
        var des = $('#description').val();
        if (first_name == '' && last_name == '' && email == '' && property_city == '' && property_street_name == '' &&
            property_state == '' && zip_code == '' && purchase_with_in == '') {
            $('#span_first_name').html('please enter valid First Name.').show().delay(4000).fadeOut("slow");
            $('#span_last_name').html('please enter valid Last name.').show().delay(4000).fadeOut("slow");
            $('#span_email_address').html('please enter valid Email address.').show().delay(4000).fadeOut("slow");
            // $('#span_property_house_no').html('please enter valid Property House no.').show().delay(4000).fadeOut("slow");
            $('#span_property_city').html('please enter valid City.').show().delay(4000).fadeOut("slow");
            $('#span_property_street_name').html('please enter valid street address.').show().delay(4000).fadeOut("slow");
            $('#span_property_state').html('please enter valid State.').show().delay(4000).fadeOut("slow");
            $('#span_property_zip_code').html('please enter valid zip code.').show().delay(4000).fadeOut("slow");
            // $('#span_contact_no').html('please enter valid phone number').show().delay(4000).fadeOut("slow");
            $('#span_purchase_with_in').html('please select planning purchase in').show().delay(4000).fadeOut("slow");
            $('#span_description').html('please enter description').show().delay(4000).fadeOut("slow");
            return false;
        } else
        if (first_name == '') {
            $('#span_first_name').html('please enter valid First Name.').show().delay(4000).fadeOut("slow");
            return false;
        } else
        if (last_name == '') {
            $('#span_last_name').html('please enter valid Last name.').show().delay(4000).fadeOut("slow");
            return false;
        } else
        if (email == '') {
            $('#span_email_address').html('please enter valid Email address.').show().delay(4000).fadeOut("slow");
            return false;
        } else
        if (property_city == '') {
            $('#span_property_city').html('please enter valid City.').show().delay(4000).fadeOut("slow");
            return false;
        } else
        if (property_street_name == '') {
            $('#span_property_street_name').html('please enter valid Street Address.').show().delay(4000).fadeOut("slow");
            return false;
        } else
        if (property_state == '') {
            $('#span_property_state').html('please enter valid State.').show().delay(4000).fadeOut("slow");
            return false;
        } else
        if (zip_code == '') {
            $('#span_property_zip_code').html('please enter valid zip code.').show().delay(4000).fadeOut("slow");
            return false;
        } else
        // if(mobile.length > 11 || mobile.length < 9){
        //     $('#span_contact_no').html('please enter valid phone number').show().delay(4000).fadeOut("slow");
        //     return false;
        // }else
        if (purchase_with_in == '') {
            $('#span_purchase_with_in').html('please select planning to purchase in').show().delay(4000).fadeOut("slow");
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: url + '/user-permit-request',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'data': $('#addressRequestForm').serializeArray()
                },
                success: function(result) {
                    if (result == 0 || result == '0') {
                        location.href = url + '/dashboard/permit-requests?request=new'; //paid credits then redirects to epermit requsts
                    } else if (result == 1 || result == '1') {
                        // $('.display-no-credits-popup').addClass('show');
                        location.href = url + '/';
                    } else if (result == 2 || result == '2') {
                        location.href = url + '/?getcredits=yes';
                    }
                },
                error: function(result) {
                    console.log('Failed - ' + result);
                }
            });
        }
    });


    // $('#clickHereToStorePermitRequest').on('click', function() {
    //     $.ajax({
    //         type: "POST",
    //         url: url+'/click-to-spend-permit-requests',
    //         data:{'_token':$('meta[name="csrf-token"]').attr('content')},
    //         success:function(result){
    //             if(result == 0){
    //                 location.href = url+'/permit-requests';
    //             }
    //         },
    //         error: function(result){
    //             console.log('Failed - '+result);
    //         }
    //     });
    // });

    $(document).on('click', '#contactSubmit', function() {

        var name = $('#nameE').val();
        var email = $('#emailL').val();
        var mobile = $('input[name="mobile"]').val();
        var enq = $('#inquiry').val();
        var des = $('#description').val();

        if(name == '' && email == '' && mobile == '' && enq == '' && des == ''){
            $('#span1').html('please enter the name.').show().delay(4000).fadeOut("slow");
            $('#span2').html('please enter valid email address.').show().delay(4000).fadeOut("slow");
            $('#span3').html('please enter valid phone number').show().delay(4000).fadeOut("slow");
            $('#span4').html('please select inquiry').show().delay(4000).fadeOut("slow");
            $('#span5').html('please enter description').show().delay(4000).fadeOut("slow");
            return false;
        }else if(IsText(name)==false){
            $('#nameE').focus();
            $('#span1').html('please enter the name.').show().delay(4000).fadeOut("slow");
            return false;
        }else if(IsEmail(email)==false){
            $('#emailL').focus();
            $('#span2').html('please enter valid email address.').show().delay(4000).fadeOut("slow");
            return false;
        }else if(mobile == ''){
            $('input[name="mobile"]').focus();
            $('#span3').html('please enter valid phone number').show().delay(4000).fadeOut("slow");
            return false;
        }else if(mobile.length > 11 || mobile.length < 9){
            $('input[name="mobile"]').focus();
            $('#span3').html('phone number must be 10 digit.').show().delay(4000).fadeOut("slow");
            return false;
        }else if(enq == ''){
            $('#inquiry').focus();
            $('#span4').html('please select inquiry').show().delay(4000).fadeOut("slow");
            return false;
        }else if(des == ''){
            $('#description').focus();
            $('#span5').html('please enter description').show().delay(4000).fadeOut("slow");
            return false;
        }else{
            $.ajax({
                type: "POST",
                url: url+'/contact-us/form',
                data:{'_token':$('meta[name="csrf-token"]').attr('content'),'name':name,'email':email,'mobile':mobile,'enq':enq,'des':des},
                // beforeSend: function(){
                //   $("#overlay").fadeIn(300);
                // },
                success:function(result){
                    // console.log(result);
                    if(result == "error"){
                        $('#spann').html('one or more(s) error found!').show().delay(4000).fadeOut("slow");
                    }else{
                        $('#spann').html('successfully sent contact us').show().delay(4000).fadeOut("slow");
                        $('#contactUsFormE').trigger('reset');
                        setTimeout(function(){
                            $("#contAddressPOP").children().addClass("active-popup"); },1000
                        );
                    }
                }
            });
        }
    });

    $(".nuFldEnaClas").keypress(function(e) {
        if (e.which != 8 && e.which != 0 && e.which != 43 && (e.which < 48 || e.which > 57)) {
            $("#span3").html("Digits Only").show().delay(4000).fadeOut("slow");
            $(".errorMSG").html("Digits Only").show().delay(4000).fadeOut("slow");
            return false;
        }
    });

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            return false;
        } else {
            return true;
        }
    }


    $("#rePoDisID").children().addClass("active-popup");
    $("#pricPopSh").children().addClass("active-popup");
    $("body").removeClass("popup-open");

    $(document).on("click", '#conTVieTab', function() {
        $(".conTVieTab_clicked").removeClass("hide");
        $(".conTVieTab_clicked").addClass("show");
        $.ajax({
            type: "GET",
            url: url + '/viewReportSes/' + $('#txNm').html(),
            // data:{'_token':$('meta[name="csrf-token"]').attr('content')},
            success: function(result) {
                $(".conTVieTab_clicked").removeClass("show");
                $(".conTVieTab_clicked").addClass("hide");
                console.log(result);
                $('#creRemSpn').html(result);
                $("body").removeClass("popup-open");
                $(".popup-table").addClass("active-popup");
            }
        });

    });

    $(document).on("click", '#conTVieTabPermitRequest', function() {
        $(".conTVieTab_clicked").removeClass("hide");
        $(".conTVieTab_clicked").addClass("show");
        $.ajax({
            type: "GET",
            url: url + '/viewReportSes',
            // data:{'_token':$('meta[name="csrf-token"]').attr('content'),'name':''},
            success: function(result) {
                $(".conTVieTab_clicked").removeClass("show");
                $(".conTVieTab_clicked").addClass("hide");
                location.href = url + '/dashboard/permit-requests?request=new';
            }
        });

    });

    $("#viewReportPopup").children().removeClass("active-popup");

    $(document).on("click", '.beLPoPUp', function() {
        // alert('hh');return false;
        var alarm = $(this).parent().data('set');
        if (alarm == 'cellAlram') {
            window.location.href = url + '/dashboard/permit/my-report';
            return true;
        } else if (alarm == 'cell') {
            var id = $(this).parent().parent().data("id");
            if (id != "") {
                $.ajax({
                    type: "POST",
                    url: url + '/getPemitDataReport',
                    data: { '_token': $('meta[name="csrf-token"]').attr('content'), 'id': id },
                    success: function(result) {
                        // console.log(result);return false;
                        if (result[1] == "error") {
                            $("#pricPopSh").children().removeClass("active-popup");
                            return false;
                        } else {
                            // $('#creRemSpn').html(result[1]);
                            $('input[name="altPID"]').val(result[0].id);
                            var html = '<ul><li><cite>Status:</cite> ' + result[0].PermitStatus + '</li>';
                            html += '<li><cite>Control Number:</cite> ' + result[0].SourcePermitID + '</li>';
                            html += '<li><cite>Permit Number:</cite> ' + result[0].PermitNumber + '</li>';
                            html += '<li><cite>Issue Date:</cite> ' + result[0].PermitEffectiveDate + '</li>';
                            html += '<li><cite>Issued By:</cite> N/A</li>';
                            html += '<li><cite>Township:</cite> ' + result[0].Location + '</li></ul>';
                            html += '<ul class="pt-3"><li><cite>Work Type:</cite> ' + result[0].PermitType + '</li>';
                            html += '<li><cite>Work Description:</cite> ' + result[0].PermitDescription + '</li>';
                            html += '<li><cite>Subcodes:</cite> ' + result[0].PropertyZipCode + '</li>';
                            html += '<li><cite>Status:</cite> ' + result[0].PermitStatus + '</li>';
                            html += '<li><cite>Close Date:</cite> ' + result[0].PermitStatusDate + '</li>';
                            html += '<li><cite>Certificates:</cite> N/A</li></ul>';
                            html += '<ul class="pt-3"><li><cite>Total Cost:</cite> $' + result[0].PermitFee + '</li>';
                            html += '<li><cite>Agent:</cite> ' + result[0].ApplicantName + '</li></ul>';
                            html += '<p class="py-3">A text alert will notify you by text of any changes to this permit</p>';
                            $('.dSlReport').html(html);
                            $("#rePoDisID").children().removeClass("active-popup");
                        }
                    }
                });
            } else {
                // console.log('something went wrong!');
                return false;
            }
        } else {
            console.log('something went wrong');
            return false;
        }
    });

    $(document).on('click', '#popupClosee', function() {
        $("#pricPopSh").children().addClass("active-popup");
        $("#poShFrnPop").children().addClass("active-popup");
    });

    $(document).on('click', '#creAlForSin', function() {
        $.ajax({
            type: "GET",
            url: url + '/checkUserNum',
            success: function(result) {
                // console.log(result);
                if (result == "empty") {
                    $('.dSlReport').html('');
                    var html = '<div class="inputPhone"><div class="phn-creAlForSin"><label>Phone Number</label><input type="number" name="phone_num" class="form-control nuFldEnaClas"><span id="spanPh" class="errorMSG"></span></div>';
                    html += '<input id="formSubmitCheck" class="btn btn-effect" style="background-color: #5AB9E3;" type="submit" name="submit" value="submit"></div>';
                    $('.dSlReport').html(html);
                    $('#creAlForSin').css("display", "none");
                } else {
                    $('#setUpAlert').submit();
                    return true;
                }
            }
        });
    });

    $(document).on('click', '#formSubmitCheck', function() {
        if ($("input[name='phone_num']").val() == '') {
            $("input[name='phone_num']").focus();
            $('#spanPh').html('please enter valid phone number').show().delay(4000).fadeOut('slow');
            return false;
        } else if ($("input[name='phone_num']").val().length >= 11) {
            $("input[name='phone_num']").focus();
            $('#spanPh').html('phone number must be 10 digits').show().delay(4000).fadeOut('slow');
            return false;
        } else if ($("input[name='phone_num']").val().length <= 9) {
            $("input[name='phone_num']").focus();
            $('#spanPh').html('phone number must be 10 digits').show().delay(4000).fadeOut('slow');
            return false;
        } else {
            return true;
        }
    });

    $(document).on('click', '.rePoDisIDCl', function() {
        $("#rePoDisID").children().addClass("active-popup");
    });

    $(document).on('click', '#cnctUpPop', function() {
        $("#contAddressPOP").children().removeClass("active-popup");
        $(".errorPOP").children().addClass("active-popup");
    });

    $(document).on('click', '#popupClosew', function() {
        $("#contAddressPOP").children().addClass("active-popup");
    });

    $(document).on('click', '#vieMapSEar', function() {
        var str = $('#txNm').html();
        // var str1 = '123 AUTUMN HILL RD, 1, PRINCETON, NJ, 08540';
        // 123 AUTUMN HILL RD, 1, PRINCETON, NJ, 08540
        // 123 AUTUMN HILL RD, 1, PRINCETON, NJ, 08540
        // var place = str.replace(/\s+/g,'%20');
        var place = str.replace(/\s+/g, '%20');
        // console.log(place1);
        // console.log(place);return false;
        var html = '<div style="width: 100%;">';
        html += '<iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=' + place + '+()&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>';
        html += '</div>';

        var myWindow = window.open("", "_blank");
        myWindow.document.write(html);
    });

    $('#successStatusMsg').show().delay(4000).fadeOut('slow');

    $(document).on('click', '#saveActInfo', function() {

        if ($('input[name="phone"]').val() == "" && $('input[name="phone"]').val() == null) {
            $('input[name="phone"]').focus();
            $('.errorMSG').html('');
            $("input[name='phone']").next('.errorMSG').html('Please enter valid mobile number').show().delay(6000).fadeOut('slow');
            return false;
        }  else if ($('input[name="phone"]').val().replace(/\D/g, "").length < 11) {
            $("input[name='phone']").focus();
            $('.errorMSG').html('');
            $("input[name='phone']").next('.errorMSG').html('phone number must be 10 digits').show().delay(6000).fadeOut('slow');
            return false;
        } else if($('input[name="user_role_type"]').val() == 1) {

            if ($("input[name='zipcode']").val() == ""){
                $('input[name="zipcode"]').focus();
                $('.errorMSG').html('');
                $("input[name='zipcode']").next('.errorMSG').html('Please enter valid zipcode').show().delay(4000).fadeOut('slow');
                return false;
            } else if (is_usZipCode($("input[name='zipcode']").val()) != true){
                $('input[name="zipcode"]').focus();
                $('.errorMSG').html('');
                $("input[name='zipcode']").next('.errorMSG').html('Please enter valid zipcode').show().delay(4000).fadeOut('slow');
                return false;
            }  else if ($('input[name="contact"]').val().replace(/\D/g, "").length > 0 &&  $('input[name="contact"]').val().replace(/\D/g, "").length < 11) {
                $("input[name='phone']").focus();
                $('.errorMSG').html('');
                $("input[name='contact']").next('.errorMSG').html('Alternate phone number must be 10 digits').show().delay(6000).fadeOut('slow');
                return false;
            }   else if ($('input[name="company_phone_no"]').val().replace(/\D/g, "").length > 0 &&  $('input[name="company_phone_no"]').val().replace(/\D/g, "").length < 11) {
                $("input[name='company_phone_no']").focus();
                $('.errorMSG').html('');
                $("input[name='company_phone_no']").next('.errorMSG').html('Company phone number must be 10 digits').show().delay(6000).fadeOut('slow');
                return false;
            } else if(isValidUrl($("input[name='website_url']").val())!=1) {
                $('input[name="website_url"]').focus();
                $('.errorMSG').html('');
                $("input[name='website_url']").next('.errorMSG').html('Please enter valid website url').show().delay(4000).fadeOut('slow');
                return false;
            }  else {
                return true;
            }
        } else {
            return true;
        }
    });

    function isValidUrl(url){

        var myVariable = url;
           if(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(myVariable)) {
             return 1;
           } else {
             return -1;
           }
       }
       function isValidphone(str){
        var regexp = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;
        if (regexp.test(str))
        {
           return true;
        } else {
            return false;
        }
    }




       function is_usZipCode(str)
       {
       regexp = /^[0-9]{5}(?:-[0-9]{4})?$/;
           if (regexp.test(str))
           {
              return true;
           } else {
               return false;
           }
       }

       function chkExist(email)
       {    var rs;
            $.ajax({
            type: 'GET',
            async:false,
            url: url + '/chkEmailExists/'+ email,
            data: { "email": $('#regemail').val() },
            success: function(result) {
                console.log(result);
                if (result == "1") {
                    $('#regnameMai').html('Email address already exist.').show().delay(4000).fadeOut("slow");
                    rs = false;
                } else {
                    rs = true;
                }
            }
        });
        return rs;
       }

    $(document).on('click', '#regSubForm', function() {
        // $('#priPopUp').data("val","Hide");
        // $("#priPopUp").css("display","none");
        if ($('#regname').val() == '') {
            $('#regname').focus();
            $('#regnameErr').html('Please enter your name.').show().delay(4000).fadeOut("slow");
            return false;
        } else if (IsEmail($('#regemail').val()) == false) {
            $('#regemail').focus();
            $('#regnameMai').html('Please enter valid email address.').show().delay(4000).fadeOut("slow");
            return false;
        }  else if (IsEmail($('#regemail').val()) == true) {
            if(chkExist($('#regemail').val()) == false)
            {
                return false;
            } else {
                return true;
            }
        } else if ($('#regpass').val() == '') {
            $('#regpass').focus();
            $('#regnamePass').html('Please enter your password.').show().delay(4000).fadeOut("slow");
            return false;
        } else if ($('#regpass').val().length < 8) {
            $('#regpass').focus();
            $('#regnamePass').html('Please enter at least 8 characters.').show().delay(4000).fadeOut("slow");
            return false;
        } else if ($('#redcpass').val() == '') {
            $('#redcpass').focus();
            $('#regnameCpass').html('Please confirm your password.').show().delay(4000).fadeOut("slow");
            return false;
        } else if ($('#regpass').val() != $('#redcpass').val()) {
            $('#regnameCpass').html('Password does not match.').show().delay(4000).fadeOut("slow");
            return false;
        } else if ($('#regccname').val() == '') {
            $('#regccname').focus();
            $('#regnameCarNam').html('Please enter name on card.').show().delay(4000).fadeOut("slow");
            return false;
        } else if ($('#regCradname').val() == '') {
            $('#regCradname').focus();
            $('#regnameCarNum').html('Please enter card number.').show().delay(4000).fadeOut("slow");
            return false;
        } else if ($('#regCradMn').val() == '') {
            $('#regCradMn').focus();
            $('#regnameMon').html('Please enter card month.').show().delay(4000).fadeOut("slow");
            return false;
        } else if ($('#regCradYr').val() == '') {
            $('#regCradYr').focus();
            $('#regnameYea').html('Please enter card year.').show().delay(4000).fadeOut("slow");
            return false;
        } else if ($('#regCradCv').val() == '') {
            $('#regCradCv').focus();
            $('#regnameCvv').html('Please enter card cvv.').show().delay(4000).fadeOut("slow");
            return false;
        } else {
            return true;
        }
    });

    $(document).on('click', '.checkboxID', function() {
        var id = $(this).val();
        var address = $(this).data("val");
        if (this.checked) {
            var alarm = "1";
        } else {
            var alarm = "0";
        }

        $.ajax({
            type: 'POST',
            url: url + '/notification',
            data: { "id": id, "alarm": alarm, "address": address },
            success: function(result) {
                console.log(result);
                if (result == "success") {
                    var set = "Off";
                    if (alarm == 1) {
                        var set = "On";
                    }
                    $('#successDiv').html('Alarm notification ' + set);
                    $('#successDiv').show().delay(4000).fadeOut('slow');
                }
            }
        });

    });

    $("#poShFrnPop").children().addClass("active-popup");
    $(document).on('click', '#sharePermitPop', function() {
        $("#poShFrnPop").children().removeClass("active-popup");
    });

    $(document).on('click', '#formSharSub', function() {
        var email = $('#shareEmail').val();
        if (IsEmail(email) == false) {
            $('#spanPh').html('Please enter a valid email address!').show().delay(4000).fadeOut('slow');
            return false;
        } else {
            return true;
        }
    });

    $(document).on('click', '#loginFormVal', function() {
        var email = $('#email').val();
        var pass = $('#password').val();

        if (email == '' && pass == '') {
            $('#LoginErrEm').html('Please enter a valid email address.').show().delay(4000).fadeOut('slow');
            $('#LoginErrPa').html('Please enter your password.').show().delay(4000).fadeOut('slow');
            return false;
        } else if (IsEmail(email) == false) {
            $('#LoginErrEm').html('Please enter a valid email address.').show().delay(4000).fadeOut('slow');
            return false;
        } else if (pass == '') {
            $('#LoginErrPa').html('Please enter your password.').show().delay(4000).fadeOut('slow');
            return false;
        } else if (pass < 8) {
            $('#LoginErrPa').html('Password must be 8 or more characters.').show().delay(4000).fadeOut('slow');
            return false;
        } else {
            return true;
        }
    });

});

function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        return false;
    } else {
        return true;
    }
}

function IsText(text) {
    var regex = /^[a-zA-Z]*$/;
    if (!regex.test(text)) {
        return false
    } else {
        return true;
    }
}

/*-- body-on-click --*/


$(document).ready(function() {
    $(document).on('click', 'body', function() {
        $('.navbar-collapse').removeClass('show');
    })
});

var ids = new Array();
$(".selectedReports input[type=checkbox]:checked").each(function() {
    ids.push(this.value);
});
if (ids.length > 0) {
    $('.enabled_btn').removeClass('hide');
    $('.disabled_btn').removeClass('show');
    $('.disabled_btn').addClass('hide');
} else {
    $('.enabled_btn').addClass('hide');
    $('.disabled_btn').removeClass('hide');
    $('.disabled_btn').addClass('show');
}

$(".ckbCheckAll").click(function() {
    $(".checkBoxClass").prop('checked', $(this).prop('checked'));

    var ids = new Array();
    $(".selectedReports input[type=checkbox]:checked").each(function() {
        ids.push(this.value);
    });

    if (ids.length > 0) {
        $('.enabled_btn').removeClass('hide');
        $('.disabled_btn').addClass('hide');
    } else {
        $('.enabled_btn').addClass('hide');
        $('.disabled_btn').removeClass('hide');
        $('.disabled_btn').addClass('show');
    }
});

$(".checkBoxClass").click(function() {
    if ($('.ckbCheckAll').prop("checked") == true)
        $(".ckbCheckAll").prop('checked', $(this).prop('checked'));

    var ids = new Array();
    $(".selectedReports input[type=checkbox]:checked").each(function() {
        ids.push(this.value);
    });
    if (ids.length > 0) {
        $('.enabled_btn').removeClass('hide');
        $('.disabled_btn').removeClass('show');
        $('.disabled_btn').addClass('hide');
    } else {
        $('.enabled_btn').addClass('hide');
        $('.disabled_btn').removeClass('hide');
        $('.disabled_btn').addClass('show');
    }
});

$(document).on('click', '.submit-print', function() {
    event.preventDefault();
    var ids = new Array();
    $(".selectedReports input[type=checkbox]:checked").each(function() {
        ids.push(this.value);
    });
    var url = $(this).attr("data-url")
    window.open(
        url + "/" + ids.toString(),
        '_blank' // <- This is what makes it open in a new window.
    );

});

$(document).on('click', '.submit-printrep', function() {
    event.preventDefault();
    var url = $(this).attr("data-url")
    window.open(
        url,
        '_blank' // <- This is what makes it open in a new window.
    );

});

$(document).on('click', '#formSharSub', function() {
    event.preventDefault();
    var ids = new Array();
    $(".selectedReports input[type=checkbox]:checked").each(function() {
        ids.push(this.value);
    });
    var url = $(this).attr("data-url");
    var email = $('#shareEmail').val();
    window.open(
        url + "/" + email + '/' + ids.toString(),
        '' // <- This is what makes it open in a new window.
    );

});


$("#poShFrnErrorPop").children().addClass("active-popup");
$(document).on('click', '.poShFrnErrorPopClose', function() {
    $("#poShFrnErrorPop").children().addClass("active-popup");

});
$(document).on('click', '.btn_report_popup', function() {
    $("#poShFrnErrorPop").children().removeClass("active-popup");
});

//btnn-effect Tejas : admin email notification
$(document).on('click', '.btn_admin_notify, #conTVieTab', function() {

    var search_val = "";
    if ($(this).attr('notify') == "success") {
        search_val = $("#txNm").text();
    } else {
        search_val = $('#searchPR').val();
    }
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        type: 'POST', // Default GET
        url: '/permit-admin-notify',
        data: { searchPR: search_val, 'type': $(this).attr('notify') },
        dataType: 'json', // text , XML, HTML
        success: function(data_resp, textStatus, jqXHR) {}
    });
});
