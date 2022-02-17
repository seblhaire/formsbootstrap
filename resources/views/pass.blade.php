<input type="password" name="{!! $data['name']!!}" id="{!! $data['name']!!}" class="{!! $data['inputclass'] !!}"
@foreach ($data['attributes']  as $key => $value)
{!! $key !!}="{!! addslashes($value) !!}"
@endforeach
/>
