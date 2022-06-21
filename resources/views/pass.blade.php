<input type="password" name="{!! $data['name']!!}" id="{!! $data['id']!!}" class="{!! $data['inputclass'] !!}"
@foreach ($data['attributes']  as $key => $value)
{!! $key !!}="{!! addslashes($value) !!}"
@endforeach
/>
