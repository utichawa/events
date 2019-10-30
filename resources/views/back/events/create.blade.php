@extends('back.layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('back.events.create', $menu_id) }}
@endsection

@section('content')

    {!! set_box_head(__('breadcrumbs.back.events.create'), false) !!}

    @include('_common.alerts.messages')

    <form action="{{ route('back.events.store') }}" method="post" class="form-create" enctype="multipart/form-data">

        @csrf

        <div class="tabbable-line">
            <ul class="nav nav-tabs">
                @foreach(config('translatable.locales') as $k => $locale)
                    <li class="@if($k==0) active @endif">
                        <a href="#tab_1_{{$locale}}"
                           data-toggle="tab">{{config('translatable.active_locales.'.$locale.'.name')}}
                            <span class="label label-sm @if($k==0) label-default @else label-danger @endif circle">{{ucfirst($locale)}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach(config('translatable.locales') as $k => $locale)
                    <div class="tab-pane @if($k==0) active @endif" id="tab_1_{{$locale}}">

                        {{-- Begin translatable content --}}

                        <h1>{{config('translatable.active_locales.'.$locale.'.name')}}</h1>

                        <div class="form-group">
                            <label>{{__('og.event_translations.name')}} *</label>
                            <input type="text" class="form-control" name="{{$locale}}[name]"
                                   value="{{ old($locale.'.name') }}" id="name_{{ $locale }}"
                            >
                        </div>

                        <div class="form-group">
                            <label>{{__('og.event_translations.slug')}} *</label>
                            <input type="text" class="form-control" name="{{$locale}}[slug]"
                                   value="{{ old($locale.'.slug') }}" id="slug_{{ $locale }}"
                            >
                        </div>

                        <div class="form-group">
                            <label>{{__('og.event_translations.description')}} *</label>
                            <textarea class="form-control summernote" class="form-control"
                                      name="{{$locale}}[description]"
                                      rows="10">{{ old($locale.'.description') }}</textarea>
                        </div>


                        <div class="form-group">
                            <label>{{__('og.event_translations.meta_title')}} </label>
                            <input type="text" class="form-control" value="{{ old($locale.'.meta_title') }}"
                                   name="{{$locale}}[meta_title]">
                        </div>

                        <div class="form-group">
                            <label>{{__('og.event_translations.meta_description')}} </label>
                            <textarea class="form-control" name="{{$locale}}[meta_description]"
                                      rows="3">{{ old($locale.'.meta_description') }}</textarea>
                        </div>

                        {{-- End translatable content --}}

                    </div>
                @endforeach
            </div>
        </div>

        <input type="hidden" name="menu_id" value="{{ request('menu_id') }}">
        <div class="form-group">
            <label>{{__('og.events.event_category_id')}}</label>
            <select class="form-control" name="event_category_id">
                <option value="">---</option>
                @if($event_categories)
                    @foreach ($event_categories as $event_category)
                        <option value="{{ $event_category->id }}"
                                @if(old('event_category_id') == $event_category->id) selected @endif
                        >{{ $event_category->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="form-group">
            <label>{{__('og.events.is_active')}} *</label>
            <div class="input-group">
                <div class="icheck-inline">
                    <label>
                        <input type="radio" name="is_active" value="1" @if(old('is_active') == 1) checked
                               @endif class="icheck"> Activée </label>
                    <label>
                        <input type="radio" name="is_active" value="0"
                               @if(old('is_active') == 0) checked @endif class="icheck"> Désactivée
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>{{__('og.events.start_date')}} *</label>
            <input type="text" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}">
        </div>

        <div class="form-group">
            <label>{{__('og.events.end_date')}} *</label>
            <input type="text" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
        </div>

        <div class="form-group">
            <label>{{__('og.event_translations.image')}} *</label>
            <input type="file" class="form-control" name="image" accept="image/*"
                   value="{{ old('image') }}">
        </div>

        <div class="form-group">
            <label>{{__('og.event_translations.gallery')}} </label>
            <input type="file" class="form-control" name="gallery[]" accept="image/*,video/mp4,video/x-m4v,video/*"
                   multiple>
        </div>

        <button type="submit" class="btn btn-primary">{{__('og.button.create')}}</button>

    </form>

    {!! set_box_foot() !!}

@endsection


@section('js')
    <script src="{{asset('back/assets/apps/scripts/todo-2.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset("back/assets/global/plugins/jquery-validation/js/jquery.validate.min.js") }}"
            type="text/javascript"></script>
    <script src="{{ asset("back/assets/global/plugins/jquery-validation/js/localization/messages_".locale().".js") }}"
            type="text/javascript"></script>
    @include('back._common.js.summernote-with-lfm')
    @include('_common.js.str_slug')

    @include('_common.js.create_slug', [
        'module' => 'events',
    ])

    <script>
        $(function () {
            $("#start_date").datepicker(
                    {
                        format: 'yyyy-mm-dd'
                    }
            );
            $("#end_date").datepicker(
                    {
                        format: 'yyyy-mm-dd'
                    }
            );
        });

    </script>
@endsection
