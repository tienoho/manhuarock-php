@extends('themes.manga18fx.layouts.full')
@section('title', L::_("Profile"))

@section('content')
    <link href="/manga18fx/css/user.css" rel="stylesheet" type="text/css">

    <div class="manga-content wleft">
        <div class="user-content">
            <div class="centernav">
                <div class="c-breadcrumb-wrapper">
                    <div class="c-breadcrumb">
                        <ol class="breadcrumb">
                            <li>
                                <a href="/" title="{{ L::_("Home") }}">
                                    {{ L::_("Home") }} 
                                </a>
                            </li>
                            <li>
                                <a href="{{ url() }}" class="active">
                                    Nạp coin
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="user-setting wleft">
                    <div class="left">
                        <div class="user-settings wleft ng-scope" ng-controller="userSetting">
                            <div class="tab-item wleft">
                                <form id="depositForm" class="ng-pristine ng-valid">
                                <div class="settings-title">
                                    <h3>
                                        {{ L::_("Coin") }}
                                    </h3>
                                </div>
                                <div class="form-items wleft">
                                    <label class="form-label">Mã giao dịch</label>
                                    <div class="form-input">
                                      <span class="show ng-scope" id="transactionCode">{{userget()->id}}00{{mt_rand(11000, 99999)}}</span>
                                      <input type="hidden" id="email" value="{{userget()->email}}">
                                    </div>
                                </div>
                                <div class="form-items wleft">
                                    <label class="form-label">Phương thức</label>
                                    <label class="custom-radio">
                                        <input type="radio" id="momo" name="paymentMethod" value="momo" checked>
                                        <span class="radio-checkmark"></span>
                                        Thanh toán qua MoMo
                                    </label><br>
                                    <label class="custom-radio">
                                        <input type="radio" id="bank" name="paymentMethod" value="bank">
                                        <span class="radio-checkmark"></span>
                                        Thanh toán qua Ngân hàng
                                    </label><br>
                                </div>
                                
                                    <div class="form-items wleft" id="amount-section">
                                        <label class="form-label">Số tiền</label>
                                        <div class="form-input">
                                            <input type="text" id="amount" placeholder="Nhập số tiền nạp (tối thiểu 10.000 vnđ)" ng-model="form.displayname"
                                                   class="ng-pristine ng-untouched ng-valid ng-empty">
                                            <div class="message wleft">
                                                <p ng-if="!validate" class="error ng-binding ng-scope"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-items wleft" id="qrCode">
                                        <label class="form-label">QR code</label>
                                       <img style="max-width:250px" id="qrResult" src="" alt="QR Code">
                                    </div>
                                    <div class="form-items wleft">
                                        <label class="form-label"></label>
                                        <div class="form-input">
                                            <input type="submit" value="{{ L::_("Submit") }}">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @include('themes.manga18fx.components.user.right')
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function() {
    var baseQRBank = 'https://api.vietqr.io/image/970416-13218151-9SP6rcY.jpg?accountName=NGUYEN%20HUU%20THANG';
    var baseQRMomo = 'https://manhuarockz.com/uploads/z5763967309331_34ccf61be2aa5c29d67f97ff9fdf002c.jpg';

    $('#amount').on('input', function() {
        var value = $(this).val().replace(/\D/g, '');
        if (value) {
            $(this).val(value.replace(/\B(?=(\d{3})+(?!\d))/g, ','));
        }
    });

    $('#amount').on('input', function() {
        var amount = $(this).val().replace(/,/g, '');
        var userLogin = $('#email').val();
        var transactionCode = $('#transactionCode').text();

        if (amount && $('input[name="paymentMethod"]:checked').val() === 'bank') {
            var qrUrl = `${baseQRBank}&amount=${amount}&addInfo=${userLogin}%20${transactionCode}`;
            $('#qrResult').attr('src', qrUrl);
        }
    });

    $('input[name="paymentMethod"]').on('change', function() {
        if ($(this).val() === 'momo') {
            $('#qrResult').attr('src', baseQRMomo);
        } else {
            $('#qrResult').attr('src', baseQRBank);
            $('#amount').trigger('blur');
        }
    });

    $('input[name="paymentMethod"]:checked').trigger('change');

    $('#depositForm').on('submit', function(event) {
        event.preventDefault();

        var transactionCode = $('#transactionCode').text();
        var paymentMethod = $('input[name="paymentMethod"]:checked').val();
        var amount = $('#amount').val().replace(/,/g, '');
        var email = $('#email').val();

        $.ajax({
            url: '/ajax/user/depositCoins', 
            type: 'POST',
            data: {
                transactionCode: transactionCode,
                paymentMethod: paymentMethod,
                amount: amount,
                email: email
            },
            success: function(response) {
                if (response.status) {
                    alert('Nạp tiền thành công.Liên hệ Admin ^.^');
                    window.location.href = '/';
                } else {
                    alert('Liên hệ Admin hỗ trợ nhé');
                }
            },
            error: function(xhr, status, error) {
                alert('Vui lòng kiểm tra lại.');
            }
        });
    });
});

</script>
@stop

@section('modal')

@stop

@section('js-body')

@stop