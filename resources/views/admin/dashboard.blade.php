@extends('admin.layouts.app')
@section('content')


<div class="page-wrapper">
<div class="page-content container-fluid">
                 <center>
                        @if(session('success'))
                        <p class="text-success pulse animated">{{ session('success') }}</p>
                        {{ session()->forget('success') }}
                        @elseif(session('failed'))
                        <p class="text-danger pulse animated">{{ session('failed') }}</p>
                        {{ session()->forget('failed') }}
                        @endif
                        </center>

</div>
</div>


@endsection
