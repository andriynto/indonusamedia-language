<ul class="{{ config('language.flags.ul_class') }}">
    @foreach (language()->allowed() as $code => $name)
        <li class="{{ config('language.flags.li_class') }}">
            <a href="{{ language()->back($code) }}">
                <img src="{{ asset('vendor/accounting/language/src/Resources/assets/img/flags/'.strtolower(substr($code, 3)).'.png') }}" alt="{{ $name }}" width="{{ config('language.flags.width') }}" /> &nbsp; {{ $name }}
            </a>
        </li>
    @endforeach
    </ul>