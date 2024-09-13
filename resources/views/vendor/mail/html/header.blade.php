{{-- @props(['url']) --}}
<tr>
<td class="header">
<a href="{{ config('app.url') }}" style="display: inline-block;">
{{-- @if (trim($slot) === 'Laravel') --}}
<img src="{{asset('images/logo/logo.png')}}" width="50px" height="50px" class="logo" alt="{{config('app.name')}}">
{{-- @else
{{ $slot }}
@endif --}}
</a>
</td>
</tr>
