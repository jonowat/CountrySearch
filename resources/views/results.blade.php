@if(isset($countries))

@if($countries->count())

<table class="mr-10">
    <thead>
        <tr class="font-bold">
            <th class="text-left">Country Name</th>
            <th class="text-left">International Dialing Code</th>
            <th class="text-left">Region</th>
            <th class="text-left">Capital</th>
            <th class="text-left">Timezone</th>
            <th class="text-left">Currency</th>
            <th class="text-left">Flag</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($countries as $country)
        <tr class="align-top border-b">
            <td>{{ $country->name }}</td>
            <td>{{ $country->dialingCodes->implode('code', ', ') }}</td>
            <td>{{ $country->region }}</td>
            <td>{{ $country->capital }}</td>
            <td>
                @foreach($country->timezones as $timezone)
                    {{ $timezone->timezone }}@if (!$loop->last), <br/>@endif
                @endforeach
            </td> 
            <td>
                @foreach($country->currencies as $currency)
                    {{ $currency->code }}@if (!$loop->last), <br/>@endif
                @endforeach
            </td>   
            <td><img src="{{ $country->flag }}" alt="Flag of {{ $country->name }}" class="w-20"></td>
        </tr> 
        @endforeach
    </tbody>
</table>

@else
    <div>No Countries found with this search.</div>
@endif
@endif