@extends('back.layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('back.events.show', $event->menu_id) }}
@endsection

@section('content')

    {!! set_box_head(__('breadcrumbs.back.events.show'), false) !!}

    @include('_common.alerts.messages')

    <table class="table table-bordered">
        @if($event->event_category_id)
            <tr>
                <th>{{__('og.events.category')}}</th>
                <td>
                    <a href="{{ route('back.event_categories.show', $event->event_category_id) }}">
                        {{ $event->category->name }}
                    </a>
                </td>
            </tr>
        @endif
        <tr>
            <th>{{__('og.events.is_active')}}</th>
            <td>{!! format_label_is_active($event) !!}</td>
        </tr>
        <tr>
            <th>{{__('og.events.start_date')}}</th>
            <td>{{  date('d-m-Y', strtotime($event->start_date )) }}</td>
        </tr>
        <tr>
            <th>{{__('og.events.end_date')}}</th>
            <td>{{  date('d-m-Y', strtotime($event->end_date )) }}</td>
        </tr>
        <tr>
            <th>{{__('og.events.slug')}}</th>
            <td>{{ $event->slug }}</td>
        </tr>
        <tr>
            <th>{{__('og.actions')}}</th>
            <td>
                <a class="btn btn-primary btn-xs" href="{{ route('back.events.edit', $event->id) }}"><span
                            class="glyphicon glyphicon-pencil"></span></a>
                <form style="display:inline" action="{{ route('back.events.destroy', $event->id) }}" method="POST">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="_method" value="DELETE">
                        <span data-placement="top" data-toggle="tooltip" title="Supprimer">
                            <button class="btn btn-danger btn-xs" type="submit"
                                    onclick="return confirm('{{__('og.alert.confirm_deletion')}}')">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </span>
                </form>
            </td>
        </tr>
    </table>

    <hr>

    @if (!$event->getMedia()->isEmpty())
        <p>
            <img src="{{ $event->getMedia()->first()->getFullUrl() }}" height="390px"/>
        </p>
    @endif

    <strong>{{__('og.events.name')}}:</strong>
    <p>
        {{ $event->name }}
    </p>

    <hr>
    <strong>{{__('og.events.description')}}:</strong>
    <p>
        {{ strip_tags($event->description) }}
    </p>

    {!! set_box_foot() !!}

@endsection
