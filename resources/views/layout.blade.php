<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>@yield('title')</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{ elixir('css/app.css')  }}">
  <!-- Fonts -->
  <link rel="stylesheet" href="{{ elixir('css/fontawesome/css/font-awesome.min.css')  }}">
  {{--  <link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">  --}}
  @role('admin')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.15/b-1.4.0/b-print-1.4.0/fh-3.1.2/sc-1.4.2/datatables.min.css"/>
<link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
  
  @endrole
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  <div class="container-fluid" >
    <nav class="navbar navbar-default navbar-fixed-top emma-navbar">
      <div class="container">
        <div class="navbar-header">

          <!-- Collapsed Hamburger -->
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          @role('admin')
          <!-- Branding Image -->
          <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'EMMA') }}
          </a>
          @endrole
          @role('examinee')
          <a class="navbar-brand" href="{{ url('/')}}">
            {{ Auth::user()->name." ". Auth::user()->last_name }}
          </a>
          @endrole
        </div>
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
          <!-- Left Side Of Navbar -->
          <ul class="nav navbar-nav">
            &nbsp;
          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            @if (Auth::guest())
              <li><a href="{{ url('/login') }}">Ingresar</a></li>
              {{--  <li><a href="{{ url('/register') }}">Register</a></li>  --}}
            @else

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                  {{ (Auth::user()->name." ".Auth::user()->last_name) }}
                  {{-- {{ Auth::user()->name }}--}} <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">
                  @role('admin')
                  <li>
                    <a href="{{ url('/admin')}}">
                      Zona de administración
                    </a>
                  </li>
                  @endrole
                  <li>
                    {{ Auth::user()->name." ".Auth::user()->last_name}}
                    <img src="{{ Auth::user()->photo() }}" style="width: 150px;">
                  </li>
                  <li>
                    <a href="{{ url('/logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    Salir del sistema
                  </a>

                  <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </li>
              </ul>
            </li>
          @endif
        </ul>
      </div>
    </div>
  </nav>
  <div class="" style="margin-top: 50px;">
    @if(count($errors))
      <div class="alert alert-danger" role="alert">
        <ul class="list-group">
          @foreach($errors->all() as $error)
            <li class="list-group-item-danger">
              {!! $error !!}
            </li>
          @endforeach
        </ul>
      </div>
    @endif
    @include('flash::message')
    @yield('content')
  </div>

</div>

{{--  @yield('scripts')  --}}
@section('scripts')
  {{-- Javascript --}}
  <script src="{{ asset('js/all.js') }}"></script>
  <script src="{{ asset('js/bootstrap.js') }}"></script>

  {{-- /Javascript --}}
  <script>
  /* This prepares the view to recibe server mesages non-AJAX */
  $('#flash-overlay-modal').modal();
  </script>
@endsection

@yield('scripts')
@role('admin')
@section('adminScripts')
  <script src="http://cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
  {{--  <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>  --}}
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.15/b-1.4.0/b-print-1.4.0/fh-3.1.2/sc-1.4.2/datatables.min.js"></script>
  
@endsection
@endrole

@yield('adminScripts')
</body>
</html>
