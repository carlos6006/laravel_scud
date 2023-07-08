@extends('adminlte::page')

@section('title', 'Resgitro de cambios')

@section('content_header')
<div class="container-fluid">
    </div>
@endsection

@section('content')
@include('sweetalert::alert')
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                            <div class="col-sm-8">
                                <span id="card_title">
                                    <h2 class="mb-1"><i class="fas fa-laptop-code"></i> @yield('title')</h2>
                                </span>
                                <div class="text-muted fw-bold">
                                    <a href="{{ url('/index') }}">{{ __('Inicio') }}</a> <span class="mx-3">|</span> <a href="" class="breadcrumb-item active">@yield('title')</a> <span class="mx-3">|</span> {{ number_format(floatval(str_replace(['[', ']', '"'], '', $tableSize)), 2) }} kB <span class="mx-3">|</span> {{count($changelogs)}} registros
                                </div>
                            </div>
                            <div class="col-sm-4 d-flex align-items-center justify-content-end">
                                <a href="{{ route('changelogs.create') }}" class="btn btn-primary float-right"  data-placement="left">
                                    <i class="fas fa-plus-circle"></i>   {{ __('Crear nuevo') }}
                                  </a>
                        </div>

                            </div>
                            </div>
                            </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                          <div id="accordion">
                            @foreach ($changelogs->sortByDesc('fecha_actualizacion')->groupBy('fecha_actualizacion') as $fecha => $registros)
                                <div class="card">
                                    <div class="card-header" id="heading{{ $loop->iteration }}">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                                                {{ __('SCUD v') }}{{ $registros->first()->version }}{{ __(' - ') }}{{ \Carbon\Carbon::parse($fecha)->isoFormat('D [de] MMMM [del] YYYY') }}
                                            </button>
                                        </h5>
                                    </div>

                                    <div id="collapse{{ $loop->iteration }}" class="collapse" aria-labelledby="heading{{ $loop->iteration }}" data-parent="#accordion">
                                        <div class="card-body">
                                            @foreach ($registros->groupBy('tipo_id') as $tipo => $registrosTipo)
                                                <h6 class="fs-6 fw-bold mb-1">{{ $registrosTipo->first()->type->nombre }}</h6>
                                                <ul class="my-0 py-0">
                                                    @foreach ($registrosTipo as $registro)
                                                        <li class="py-2">{{ $registro->descripcion }}</li>
                                                    @endforeach
                                                </ul>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                    </div>
                </div>
                {!! $changelogs->links() !!}
            </div>
        </div>
    </div>
@endsection
