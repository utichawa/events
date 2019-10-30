@extends('back.layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('back.event_categories.show', $event_category->menu_id) }}
@endsection

@section('content')

    {!! set_box_head(__('breadcrumbs.back.event_categories.show'), false) !!}

    @include('_common.alerts.messages')

    <table class="table table-bordered">
        <tr>
            <th>{{__('og.event_categories.is_active')}}</th>
            <td>{!! format_label_is_active($event_category) !!}</td>
        </tr>
        <tr>
            <th>{{__('og.event_categories.name')}}</th>
            <td>{{ $event_category->name }}</td>
        </tr>
        <tr>
            <th>{{__('og.event_categories.slug')}}</th>
            <td>{{ $event_category->slug }}</td>
        </tr>
        <tr>
            <th>{{__('og.event_categories.order')}}</th>
            <td>{{ $event_category->order }}</td>
        </tr>
        <tr>
            <th>{{__('og.event_categories.description')}}</th>
            <td>{{ $event_category->description }}</td>
        </tr>
        <tr>
            <th>{{__('og.actions')}}</th>
            <td>
                <a class="btn btn-primary btn-xs"
                   href="{{ route('back.event_categories.edit', $event_category->id) }}"><span
                            class="glyphicon glyphicon-pencil"></span></a>
                <form style="display:inline"
                      action="{{ route('back.event_categories.destroy', $event_category->id) }}"
                      method="POST">
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

    {!! set_box_foot() !!}

@endsection
