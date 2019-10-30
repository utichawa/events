@extends('back.layouts.app')

@section('css')
    @include('_common.css.datatables')
    <link href="{{ asset('/back/assets/global/plugins/jquery-nestable/jquery.nestable.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('/back/assets/global/plugins/bootstrap-toastr/toastr.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <style>
        .dd-handle {
            height: 35px;
        }
    </style>
@stop

@section('breadcrumbs')
    {{ Breadcrumbs::render('back.events.index', $menu_id) }}
@endsection

@section('content')

    @php($where = request('menu_id') ? ['menu_id' => request('menu_id')] : null)

    {!! set_box_head(__('breadcrumbs.back.events.index'), false) !!}

    <a href="{{ route('back.events.create', ['menu_id' => request('menu_id')]) }}"
       class="btn btn-primary">
        {{ __('og.button.create') }}
    </a>

    <a href="{{ route('back.event_categories.index', ['menu_id' => request('menu_id')]) }}"
       class="btn btn-primary">
        Event Categories List
    </a>

    <hr>

    @include('_common.alerts.messages')

    <input type="checkbox" class="toggle-vis" data-column="id" checked/> {{__('og.events.id')}} |
    <input type="checkbox" class="toggle-vis" data-column="category.translations.name" checked/> {{__('og.events.category')}} |
    <input type="checkbox" class="toggle-vis" data-column="start_date" checked/> {{__('og.events.start_date')}} |
    <input type="checkbox" class="toggle-vis" data-column="end_date" checked/> {{__('og.events.end_date')}} |
    <input type="checkbox" class="toggle-vis" data-column="event_id"
           checked/> {{__('og.event_translations.event_id')}} |
    <input type="checkbox" class="toggle-vis" data-column="translations.name"
           checked/> {{__('og.event_translations.name')}} |
    <input type="checkbox" class="toggle-vis" data-column="translations.description"
           checked/> {{__('og.event_translations.description')}} |
    <input type="checkbox" class="toggle-vis" data-column="translations.content"
           checked/> {{__('og.event_translations.content')}} |

    <hr>

    <div class="table-responsive">
        <table class="table table-bordered" id="data-table">
            <thead>
            <tr>
                <th>{{__('og.events.id')}}</th>
                <th>{{__('og.events.category')}}</th>
                <th>{{__('og.events.start_date')}}</th>
                <th>{{__('og.events.end_date')}}</th>
                <th>{{__('og.event_translations.name')}}</th>
                <th>{{__('og.event_translations.description')}}</th>
                <th>{{__('og.event_translations.content')}}</th>
                <th>{{__('og.actions')}}</th>
            </tr>
            </thead>
        </table>
    </div>

    {!! set_box_foot() !!}

@endsection

@section('js')
    <script src="{{ asset('/back//assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"
            type="text/javascript"></script>
    @include('_common.js.datatables')
    <script>
        $(function () {

            $("[data-toggle=tooltip]").tooltip();

            var table = $('#data-table').DataTable({
                pagingType: "full_numbers",
                processing: true,
                serverSide: true,
                ajax: '{!! route('back.events.index', $where) !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'category', name: 'category.translations.name'},
                    {data: 'start_date', name: 'start_date'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'name', name: 'translations.name', 'orderable': false},
                    {data: 'description', name: 'translations.description', 'orderable': false},
                    {data: 'content', name: 'translations.content'},
                    {data: 'actions', name: 'actions'},
                    {{--
                    { data: 'created_by, name: 'created_by' },
                    { data: 'updated_by', name: 'updated_by' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    --}}
                ],
                "drawCallback": function (settings) {
                    $("[data-toggle=tooltip]").tooltip();
                }
            });

            $('.toggle-vis').on('click', function (e) {
                // Get the column API object
                var column = table.column($(this).attr('data-column') + ':name');
                // Toggle the visibility
                column.visible(!column.visible());
            });

            $("[data-column='translations.description']").trigger("click");
            $("[data-column='translations.content']").trigger("click");

        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    </script>

    @include('back._common.datatables.toggleStatusJs', [
        'route' => 'back.events.index'
    ])
@stop
