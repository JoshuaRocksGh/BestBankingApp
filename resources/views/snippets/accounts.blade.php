@foreach (session()->get('customerAccounts') as $i => $account)
    <option {{-- data-content="<div class='account-card row'>
    <div class='col-2 text-center'><div class='account-icon mx-auto'><span>{{ $account->accountDesc[0] }}</span></div></div>
    <div class='col-10 align-self-center'>
        <div class='font-16 font-weight-bold' style='line-height:1.2;'>{{ $account->accountDesc }}</div>
        <div class='d-flex'><div class='mr-auto font-14'>{{ $account->accountNumber }}</div>
        <div class='font-14'><span class='mr-1 ml-2'>{{ $account->currency }}</span> <span>{{ number_format($account->availableBalance, 2) }}</span></div>
    </div></div>
</div>" --}}
        data-content=" <div class='overflow-hidden'>
    <div class=' d-flex px-8 align-items-center' style='line-height: 1.5 !important'>
        <div class='d-none mr-2 d-sm-block'>
            <img style='width: 50px;' src='assets/images/logoSLCB.png' />

        </div>
        <div class='d-flex w-100 justify-content-between align-items-center'>
            <div class='font-14'>
                <span class='d-block text-dark font-weight-bold'>
                    {{ $account->accountDesc }} </span>
                <div class='text-dark'>{{ $account->accountNumber }}</div>
                <div class='font-14 font-weight-bold text-success'><span class='mr-1'>{{ $account->currency }}</span>
                    <span>{{ number_format($account->availableBalance, 2) }}</span>
                </div>
            </div>

        </div>
    </div>
</div>"
        data-account-type="{{ $account->accountType }}" data-account-number="{{ $account->accountNumber }}"
        data-account-currency="{{ $account->currency }}" data-account-balance="{{ $account->availableBalance }}"
        data-account-mandate="{{ $account->accountMandate }}" data-account-description="{{ $account->accountDesc }}"
        data-account-currency-code="{{ $account->currencyCode }}"
        value="{{ $account->accountType . '~' . $account->accountDesc . '~' . $account->accountNumber . '~' . $account->currency . '~' . $account->availableBalance . '~' . $account->currencyCode . '~' . $account->accountMandate }}">
        {{ $account->accountDesc .
            ' || ' .
            $account->accountNumber .
            ' || ' .
            $account->currency .
            ' ' .
            number_format($account->availableBalance, 2) }}
    </option>
@endforeach
