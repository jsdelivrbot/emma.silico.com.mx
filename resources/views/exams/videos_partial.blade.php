{{--
/**
 * User: msantana
 * Date: 18/01/17
 * Time: 12:37 PM
 */
--}}

        {{--  $source = preg_replace('/\\.[^.\\s]{3,4}$/', '', $video->source);  --}}
    <video width="100%"  controls autoplay loop muted>
        <source src="{{ asset('videos/'.$video->source) }}" type="video/{{pathinfo($video->source, PATHINFO_EXTENSION)}}">;
       Este navegador no es compatible con la reproducción de videos
   </video> 
{{--  <video width="100%"  controls autoplay loop>
    <source src="/videos/{{ $source }}.mp4" type="video/mp4">
    <source src="/videos/{{$source}}.webm" type="video/webm">
    <source src="/videos/{{$source}}.ogg" type="video/ogg">

    El video no puede ser reproducido en este equipo por favor solicite apoyo a nuestro personal
</video>  --}}
