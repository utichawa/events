@extends(front_dir().'.layouts.content_templates.default')

@section('meta_title'){{$menu->meta_title}}@endsection

@section('meta_description'){{$menu->meta_description}}@endsection

@section('main_content')

    <h1>{{ $menu->label }}</h1>

    @include(front_dir() . '.events.filter')
    @foreach($events as $event)

        <h2>{{ $event->name }}</h2>

        <p>
            {{ truncate_html($event->description, 500) }}
        </p>

        <p>
            Du {{ carbon($event->start_date)->format('Y-m-d') }} au {{ carbon($event->end_date)->format('Y-m-d') }} <br>
            Categorie: <a href="{{ front_category($event) }}">
                {{ $event->category->name }}
            </a>
        </p>

        @php($menu_slug = $event->menu->slug??'')

        <a href="{{ front_show($event) }}"
           class="btn btn-primary">Read more</a>

        <br>

    @endforeach

    {{ $events->appends(request()->all())->links(front_dir()  .'.layouts.app_partials.pagination') }}

@endsection

@section('head_pagination')
    {!! $events->links(front_dir() . '.layouts.app_partials.head_pagination') !!}
@endsection
