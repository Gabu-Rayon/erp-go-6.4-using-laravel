@if(!empty($customer))
    <div class="row">
        <div class="col-md-4">
                <h6>{{__('Customer Details')}}</h6>
                <div class="bill-to">
                    @if(!empty($customer['name']))
                    <small>
                        <span>Name: {{$customer['name']}}</span><br>
                        <span>TIN: {{$customer['customerTin']}}</span><br>
                        <span>Customer No: {{$customer['customerNo']}}</span><br>
                        <span>Contact: {{$customer['contact'] }}</span><br>
                        <span>{{$customer['billing_zip']}}</span>
                    </small>
                    @else
                        <br> -
                    @endif
                </div>
        </div>
        <div class="col-md-4">
            <h6>{{__('Bill to')}}</h6>
            <div class="bill-to">
                @if(!empty($customer['billing_name']))
                <small>
                    <span>{{$customer['billing_name']}}</span><br>
                    <span>{{$customer['billing_phone']}}</span><br>
                    <span>{{$customer['billing_address']}}</span><br>
                    <span>{{$customer['billing_city'] . ' , '.$customer['billing_state'].' , '.$customer['billing_country'].'.'}}</span><br>
                    <span>{{$customer['billing_zip']}}</span>
                </small>
                @else
                    <br> -
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <h6>{{__('Ship to')}}</h6>
            <div class="bill-to">
                @if(!empty($customer['shipping_name']))
                <small>
                    <span>{{$customer['shipping_name']}}</span><br>
                    <span>{{$customer['shipping_phone']}}</span><br>
                    <span>{{$customer['shipping_address']}}</span><br>
                    <span>{{$customer['shipping_city'] . ' , '.$customer['shipping_state'].' , '.$customer['shipping_country'].'.'}}</span><br>
                    <span>{{$customer['shipping_zip']}}</span>
                </small>
                @else
                    <br> -
                @endif
            </div>
        </div>
        <div class="col-md-2">
            <a href="#" id="remove" class="btn btn-sm my-3 btn-danger">{{__(' Remove')}}</a>
        </div>
    </div>
@endif
