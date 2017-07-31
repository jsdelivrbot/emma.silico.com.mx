{{--TODO Add correct anchors to the slots list and links to previous and next slot--}}
<ul class="list-group" style="margin-top: -5px;">
    <li class="list-group-item">
        <div class="btn-group btn-group-justified">
            <a id="save_back" href="{{ route('exams.slot', ['slot' => $prev]) }}" class="btn btn-lg btn-success {{ (!$prev) ? 'disabled':null}}" style="background-color: #669A66;">
                                    <span class="fa-lg">
                                        <i class="fa fa-chevron-circle-left fa-fw"></i>
                                        <i class="fa fa-floppy-o fa-2x"></i>
                                    </span>
            </a>
            <a href="{{ route('generalIndex') }}#slot_{{ $slot_id }}" class="btn btn-lg btn-primary" style="background-color: #92CEEA;">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-list-alt fa-2x"></i>
                                    </span>
            </a>
            <a href="{{ route('exams.slot', ['slot' => $next]) }}" class="btn btn-lg btn-success {{ (!$next) ? 'disabled':null}}" style="background-color: #669A66;">
                                    <span class="fa-lg">
                                        <i class="fa fa-floppy-o fa-2x"></i>
                                        <i class="fa fa-chevron-circle-right fa-fw "></i>
                                    </span>
            </a>
        </div>

    </li>
    <li>

    </li>
</ul>
