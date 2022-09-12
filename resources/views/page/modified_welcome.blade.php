@extends('template.outer_layout')

@section('contents')
<div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
    <h1>This is the modified Welcome page</h1>

    @if (isset($totalSum))
    <h3 style="color:red">total is: {{$totalSum ?? "0"}}</h3>
    @else
    <h3 style="color:red">No Total Sum Given</h3>
    @endif
</div>

@endsection