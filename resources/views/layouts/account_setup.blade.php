<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">
        <a
            href="{{route('taxes.index')}}"
            class="list-group-item list-group-item-action border-0 {{ (Request::route()->getName() == 'taxes.index' ) ? ' active' : '' }}"
            >
                {{__('Taxes')}}
                <div class="float-end">
                    <i class="ti ti-chevron-right"></i>
                </div>
            </a>
        <a
            href="{{route('details.countries')}}"
            class="list-group-item list-group-item-action border-0
                {{
                    (Request::route()->getName() == 'details.countries' )
                    ? ' active'
                    : ''
                }}"
            >
                {{__('Countries')}}
                <div class="float-end">
                    <i class="ti ti-chevron-right"></i>
                </div>
        </a>

        <a
            href="{{route('details.refundreasons')}}"
            class="list-group-item list-group-item-action border-0
                {{
                    (Request::route()->getName() == 'details.refundreasons' )
                    ? ' active'
                    : ''
                }}"
            >
                {{__('Refund Reasons')}}
                <div class="float-end">
                    <i class="ti ti-chevron-right"></i>
                </div>
        </a>

        <a
            href="{{route('details.currencies')}}"
            class="list-group-item list-group-item-action border-0
                {{
                    (Request::route()->getName() == 'details.currencies' )
                    ? ' active'
                    : ''
                }}"
            >
                {{__('Currencies')}}
                <div class="float-end">
                    <i class="ti ti-chevron-right"></i>
                </div>
        </a>

        <a
            href="{{route('details.banks')}}"
            class="list-group-item list-group-item-action border-0
                {{
                    (Request::route()->getName() == 'details.banks' )
                    ? ' active'
                    : ''
                }}"
            >
                {{__('Banks')}}
                <div class="float-end">
                    <i class="ti ti-chevron-right"></i>
                </div>
        </a>

        <a
            href="{{route('details.languages')}}"
            class="list-group-item list-group-item-action border-0
                {{
                    (Request::route()->getName() == 'details.languages' )
                    ? ' active'
                    : ''
                }}"
            >
                {{__('Languages')}}
                <div class="float-end">
                    <i class="ti ti-chevron-right"></i>
                </div>
        </a>

        <a
            href="{{route('details.payment-types')}}"
            class="list-group-item list-group-item-action border-0
                {{
                    (Request::route()->getName() == 'details.payment-types' )
                    ? ' active'
                    : ''
                }}"
            >
                {{__('Payment Types')}}
                <div class="float-end">
                    <i class="ti ti-chevron-right"></i>
                </div>
        </a>

        <a href="{{ route('product-category.index') }}" class="list-group-item list-group-item-action border-0 {{ (Request::route()->getName() == 'product-category.index' ) ? 'active' : '' }}">{{__('Category')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('product-unit.index') }}" class="list-group-item list-group-item-action border-0 {{ (Request::route()->getName() == 'product-unit.index' ) ? ' active' : '' }}">{{__('Unit')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="{{ route('custom-field.index') }}" class="list-group-item list-group-item-action border-0 {{ (Request::route()->getName() == 'custom-field.index' ) ? 'active' : '' }}   ">{{__('Custom Field')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

    </div>
</div>
