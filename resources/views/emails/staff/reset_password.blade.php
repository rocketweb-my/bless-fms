@component('mail::message')
Hello, Your password has been changed successfully.<br>
<br>
Following are the details:<br>
<table>
<tr>
<td><b>New Password</b></td>
<td><b> : </b></td>
<td>{{ $password }}</td>
</tr>
</table>
<br>
Your old password cannot being used anymore. Please change the password from your profile page.<br>

@component('mail::button', ['url' => route('login')])
Dashboard
@endcomponent

Thanks,<br>
@if(systemGeneralSetting() != null && systemGeneralSetting()->help_desk_title != null) {{ systemGeneralSetting()->help_desk_title }} @else {{ config('app.name') }} @endif

@endcomponent


