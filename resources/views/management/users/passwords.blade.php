<!DOCTYPE html>
<html lang="es">
<head>
  @php
    header('Content-type: application/pdf',true,200);
    header('Cache-Control: public');
   @endphp
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Documentos de acceso</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
   <!-- Bootstrap -->
  <link rel="stylesheet" href="{{ elixir('css/app.css')  }}">
  <link rel="stylesheet" href="css/fontawesome/css/font-awesome.min.css">

  <!-- Fonts -->
{{--<link rel="stylesheet" href="{{ elixir('css/fontawesome/css/font-awesome.min.css')  }}"> --}}
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style media="print">
  @page {
    size: letter;
  }
  .my_page {
    page-break-inside: avoid;
    font-size: 18px;

  }
  h1, h2, h3, h4, h5 {
    page-break-after: avoid;
  }
  .row{
    page-break-inside: avoid;
  }
  </style>
</head>
<body>
  @php
  $i=1;
  @endphp
  @php
  $source = "images/".$board->logo()->first()->source ;
  $type = pathinfo($source, PATHINFO_EXTENSION);
  $data = file_get_contents($source);
  $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
  @endphp
  <div class="container">
  @foreach ($users as $user)
    <div class="my_page" style="page-break-inside: avoid; ">
      {{-- Header row --}}
      <div class="row">
        <div class="col-xs-11">
          <div class="text-center">
          <h2>
            <img src="{{ $logo }}" alt="" width="65px">
            {{ $board->name }}
          </h2>
          Examen de Certificación {{ $exam->applicated_at->year }}
          <span class="text-center"><small>{{ $exam->applicated_at->toDateString() }}</small></span>
        </div>
      </div>

        <div class="col-xs-1">
          <div class="text-right">
            <div class="panel">
              {{ $user->id }}
            </div>
          </div>
        </div>
      </div>{{-- Header row end --}}
      <div class="row">
        <div class="col-xs-4">{{-- Foto placeholder --}}
          <div class="panel">
                  <img src="{{$user->photo()}}" width="250px" />
          </div>
        </div>{{--Foto placeholder end --}}
        <div class="col-xs-8 pull-right">
                <div class="text-justify">
                        <h3>
                                Sustentante:  <strong>{{ $user->full_name(1) }}</strong>
                        </h3>
                        @if ($user->identifier != NULL)
                                <h4>Folio: {{ $user->identifier }}</h4>
                        @endif
                        @if($user->center != NULL)
                                <h4>Sede formativa: {{ $user->center->name }}</h4>
                        @endif
                        @if($user->completion_year != NULL)
                                <h4>Año de egreso: {{ $user->completion_year }}</h4>
                        @endif
                        <p>
                        <h2 class="text-justify">
                                Usuario: <strong>{{ $user->username }}</strong>
                        </h2>
                        </p>
                        <p>
                        <h2 class="text-justify">
                                Contraseña: <strong>{{ $user->username }}</strong>
                        </h2>
                        </p>

                </div>
        </div>
      </div>
      <div class="row">
              <div class="col-xs-12 text-left">
                      <h5>Instrucciones</h5>
                      <p>Espere a que nuestro personal le atienda y asigne una computadora</p>
                      <p>No ingrese al exam hasta que nuestro personal se lo indique</p>
                      <p>En caso de que su nombre esté mal escrito por favor haga la corrección en este documento y terminando su examen lo corregiremos.</p>
                      <p>Al terminar su examen debe entregar este documento firmado en la parte inferiror</p>
                      <p>En el campo de -Usuario- debe capturar el texto marcado como Usuario impreso en este documento, tal y como está escrito. Este texto está compuesto de letras mayúsculas, 6 números y una letra minúscula</p>
                      <p>En el campo de -Contraseña- debe capturar el texto marcado como Contraseña impreso en este documento tal y como está escrito. Este texto está compuesto de letras mayúsculas, 6 números y una letra minúscula</p>
                      <p>Al capturar sus datos en el sistema debe ser cuidadoso de que estén escritos tal y como los están en este documento ya que de no ser así no podrá ingresar</p>
                      <p>Su examen tendrá una duración de {{ $exam->duration }} minutos y consiste de {{ $exam->questions_count() }} preguntas.</p>
                      <h5>Consejos</h5>
                      <p>Cada pregunta tiene sólo una respuesta correcta. En caso de que usted piense que más repuestas podrían ser la correcta elija la que considere mejor.</p>
                      <p>Puede elegir dejar preguntas sin contestar y regresar a ellas más tarde</p>
                      <p>Puede cambiar sus respuestas las veces que quiera</p>
                      <p>No existe un orden obligatorio para respoonder su examen pero le recomendamos seguir el orden en que se le presenta</p>
              </div>
              <div class="col-xs-12 text-left ">
                      Cualquier violación a este reglamento amerita la cancelación del presente examen y sanción disciplinaria por parte del {{ $board->name }}.
                      <ol>
                              Limitantes
                              <li>Queda prohibido extraer cualquier información que competa a este examen</li>
                              <li>Queda prohibido copiar y otros comportamientos que no se adecuén al perfil ético del {{ $board->short_name }} y de las buenas prácticas académicas.</li>
                              <li>Usar el equipo de cómputo y sus sistemas de software para un objetivo distinto al de responder el examen</li>
                      </ol>
                      <p>Nuestro personal así como los miembros del {{ $board->name }} arbitrariamente pueden solicitar el cambio de asiento o equipo al sustentante.</p>
              </div>
      </div>
      <div class="row">
              <div class="col-xs-12 text-left">
                      He entendido el reglamento y estoy de acuerdo con él.
                      <br>
                      Recibí mi examen.
              </div>
      </div>
    </div>{{-- Container end --}}
    <div class="text-center" style="page-break-after:always;">
            {{ $i++.'/'.$exam->users->count() }}
    </div>
  @endforeach
  </div>
</body>
</html>
