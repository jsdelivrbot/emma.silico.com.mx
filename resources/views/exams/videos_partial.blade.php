{{--
/**
 * User: msantana
 * Date: 18/01/17
 * Time: 12:37 PM
 */
--}}
<video width="100%"  controls autoplay loop>
    @php
        $source = preg_replace('/\\.[^.\\s]{3,4}$/', '', $video->source);
    @endphp
    <source src="/videos/{{ $video->source }}" type="video/mp4">
    <source src="videos/{{$source}}.webm" type="video/webm">
    <source src="videos/{{$source}}.ogg" type="video/ogg">

    El video no puede ser reproducido en este equipo por favor solicite apoyo a nuestro personal
</video>
