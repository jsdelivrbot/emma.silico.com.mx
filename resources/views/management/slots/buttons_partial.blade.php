{{--TODO Add correct anchors to the slots list and links to previous and next slot--}}
<ul class="list-group" style="margin-top: -5px;">
    <li class="list-group-item">
        <div class="btn-group btn-group-justified">
            <a id="save_back" href="#" class="btn btn-lg btn-success">
                                    <span class="fa-lg">
                                        <i class="fa fa-chevron-circle-left fa-fw"></i>
                                        <i class="fa fa-floppy-o fa-2x"></i>
                                    </span>
            </a>
            <a href="{{ route('slots.index') }}" class="btn btn-lg btn-primary">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-list-alt fa-2x"></i>
                                    </span>
            </a>
            <a href="#" class="btn btn-lg btn-success">
                                    <span class="fa-lg">
                                        <i class="fa fa-floppy-o fa-2x"></i>
                                        <i class="fa fa-chevron-circle-right fa-fw "></i>
                                    </span>
            </a>
        </div>

    </li>
</ul>