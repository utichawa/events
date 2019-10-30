@extends(front_dir().'.layouts.content_templates.default')

@section('meta_title'){{$event->name}}@endsection

@section('meta_description'){{$event->description}}@endsection


@section('og_tags_element')
    @php $element = $event; @endphp
    @include('front.layouts.app_partials.tags',$element)
@endsection

@section('main_content')

    <h1>{{ $event->name }}</h1>

    <p>
        {{ $event->content }}
    </p>


    @if (!$event->getMedia('event_medias')->isEmpty())
        <div class="gallerie">
            <h3>{{__('og.front_filter.discover_latest_images')}}</h3>
            <div class="owl-carousel owl-theme actuality-carousel">
                @foreach($event->getMedia('event_medias') as $media)
                    <div class="item">
                        <a class="magnific-popup-image" href="{{ $media->getFullUrl() }}">
                            <img src="{{ $media->getFullUrl() }}" alt="{{ $event->name }}"/>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@endsection
