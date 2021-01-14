<!DOCTYPE html>
<html lang="en">
<head>
    <base href="{{ asset("") }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Giỏ hàng leo-food</title>
    <link rel="shortcut icon" href="/public/frontend/images/title2.jpg">
    <link rel="stylesheet" href="/public/frontend/css/style.css">
    <link rel="stylesheet" href="/public/frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/frontend/fonts/css/all.css">
    <style>
        body {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    @include('frontend.header')
    <div class="container mt-3">
        <div class="row p-1">
            <div class="col-md-12 p-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" style="border-radius: 0">
                      <li class="breadcrumb-item"><a href="">Trang chủ</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                    </ol>
                </nav>
            </div>
            <div id="change-cart" class="col-md-12">
                @php
                    $content = Cart::content();
                @endphp
                @if (Cart::count() != 0)
                    <div class="row">
                        <!-- #1 -->
                        <div class="col-md-9 p-0 pr-2">
                            <div id="ProductInCart">
                                <div class="container">
                                    <div class="row">
                                        @foreach ($content as $item)
                                            <div class="col-md-2 p-2 pl-3 mt-2 mb-1">
                                                <img src="{{ $item->options->image }}">
                                            </div>
                                            <div class="col-md-8 pt-1 mt-2 mb-1">
                                                <small><span id="text-leo">LEO</span><span id="text-food">FOOD</span></small> |
                                                <small>{{ $item->name }}</small><br>
                                                <small id="text-giaohang30p"><i class="fas fa-angle-double-right"></i> Giao hàng
                                                    trong vòng 30 phút</small><br>
                                                <a onclick="return xoaSPGioHang('{{ $item->rowId }}')" class="btn btn-sm btn-danger" id="btn-xoa">Xóa</a>
                                            </div>
                                            <div class="col-md-2 p-0 pt-1 mt-2 mb-1">
                                                <small id="text-gia">Đơn giá: <label style="color:red">{{ number_format($item->price,0,'.','.') }}<sup>VNĐ</sup></label></small>
                                                <input onchange="return capNhatSLSP('{{ $item->rowId }}', this.value)" class="input_sl" type="number" name="soluong" min="1" style="width: 115px; text-align: center; border: 1px solid grey; border-radius: 2px; outline: none" value="{{ $item->qty }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- #2 -->
                        <div class="col-md-3 p-0">
                            <div>
                                <div id="change-money" class="frame-payment">
                                    <p>
                                        <span class="payment">Tạm tính:</span>
                                        <span class="payment price">
                                            @php
                                                echo number_format(Cart::subtotal(),0,'.','.')."<sup>VNĐ</sup>";
                                            @endphp
                                        </span>
                                    </p>
                                    <hr>
                                    <p>
                                        <span class="payment">Phí giao hàng:</span>
                                        <span class="payment price">{{ number_format(15000,0,'.','.') }}<sup>VNĐ</sup></span>
                                    </p>
                                    <hr>
                                    <p>
                                        <span class="payment">Tổng cộng:</span>
                                        <span class="payment price-all">
                                            @if (session()->has('giamgia'))
                                                @php
                                                    $x = Cart::subtotal()+15000;
                                                    $t = $x - $x*0.05;
                                                    echo number_format($t,0,'.','.')."<sup>VNĐ</sup>";
                                                @endphp
                                            @else
                                                @php
                                                    echo number_format(Cart::subtotal()+15000,0,'.','.')."<sup>VNĐ</sup>";
                                                @endphp
                                            @endif
                                        </span>
                                    </p>
                                    @if (session()->has('giamgia'))
                                        <small style="color: green"><i class="fas fa-check-circle"></i> Bạn đã được giảm 5% vào đơn hàng</small>
                                    @endif
                                </div>
                                <a href="{{ route('thong-tin-gh') }}" class="btn btn-sm btn-danger mt-2 mb-2 w-100">Tiến hành đặt hàng</a>
                                @if (!session()->has('giamgia'))
                                    <div class="frame-payment">
                                        <p>Mã giảm giá</p>
                                        <hr>
                                        <form action="{{ route('giam-gia-don-hang') }}" method="POST">
                                            @csrf
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="magiamgia" required class="form-control form-control-sm mr-sm-2"
                                                            placeholder="Nhập ở đây ...">
                                                    </td>
                                                    <td>
                                                        <input type="submit" class="btn btn-sm btn-warning ml-1" value="Đồng ý">
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                        @if (session()->has('ggtb'))
                                            <div class="alert alert-danger mt-3 mb-0" id="danger-alert">
                                                <strong><i class='fas fa-exclamation-triangle'></i></strong>
                                                {{ session('ggtb') }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row p-3" style="background-color: white">
                        <div class="col-md-12 p-1">
                            <div style="text-align: center; padding: 20px 0">
                                <img src="/public/frontend/images/mascot.png" >
                                <p class="mt-3">Không có sản phẩm nào trong giỏ hàng của bạn</p>
                                <a href="{{ route('trang-chu') }}" class="btn btn-warning">Tiếp tục mua sắm</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('frontend.footer')
    
    {{-- ### --}}
    <script src="/public/frontend/js/jquery-3.4.1.min.js"></script>
    <script src="/public/frontend/js/jquery-ui.min.js"></script>
    <script src="/public/frontend/js/bootstrap.bundle.min.js"></script>
    <script src="/public/frontend/js/myScript.js"></script>
    <script>
        $('#searchSP').on('keyup',function(){
                $value = $(this).val();
                $.ajax({
                    type: 'post',
                    url: '/tim-ten-san-pham',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'value': $value
                    },
                    success:function(reponse){
                        $('#change-tenSP').html(reponse);
                    }
                });
            });
    </script>
    <script>
        function capNhatSLSP(rowId, value){
            $.ajax({
                url: '/cap-nhat-sp-gio-hang',
                type: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'rowId': rowId,
                    'soluong': value
                },
            })
            .done(function(reponse){
                $('#change-money').html(reponse);
            });
        }
    </script>
</body>
</html>