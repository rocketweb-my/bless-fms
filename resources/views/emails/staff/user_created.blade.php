@component('mail::message')
Hello and welcome to @if(systemGeneralSetting() != null && systemGeneralSetting()->help_desk_title != null) {{systemGeneralSetting()->help_desk_title}} @else {{ config('app.name') }} @endif , Your Account Successfully Created.
<br>
Following are the details:<br>
<table>
<tr>
<td><b>Email</b></td>
<td><b> : </b></td>
<td>{{ $email }}</td>
</tr>
<tr>
<td><b>Password</b></td>
<td><b> : </b></td>
<td>{{ $password }}</td>
</tr>
</table>

@component('mail::button', ['url' => route('login')])
Login To Dashboard
@endcomponent

Thanks,<br>
@if(systemGeneralSetting() != null && systemGeneralSetting()->help_desk_title != null) {{ systemGeneralSetting()->help_desk_title }} @else {{ config('app.name') }} @endif

@endcomponent


