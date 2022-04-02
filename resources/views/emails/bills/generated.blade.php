@component('mail::message')
# Hello {{ $user->name }},


Your bill has been generated.

Please confirm!

@component('mail::table')
| Bill Name | Amount | Paid | Due Date |
|:---------|:-------|:-----:|:--------:|
| {{ $bill->name }} | Rs. {{ $bill->amount }} | {{ $bill->paid ? "Yes" : "No" }} | {{ $bill->due_date }} |
@endcomponent


@component('mail::button', ['url' => ''])
Pay now!
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
