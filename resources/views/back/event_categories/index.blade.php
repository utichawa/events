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
    {{ Breadcrumbs::render('back.event_categories.index', $menu_id) }}
@endsection

@section('content')

    @php($where = request('menu_id') ? ['menu_id' => request('menu_id')] : null)

    {!! set_box_head(__('breadcrumbs.back.event_categories.index'), false) !!}

    <a href="{{ route('back.event_categories.create', $where) }}"
       class="btn btn-primary">
        {{ __('og.button.create') }}
    </a>

    <a href="{{ route('back.events.index', $where) }}"
       class="btn btn-primary">
        Events
    </a>

    <hr>

    @include('_common.alerts.messages')

    <input type="checkbox" class="toggle-vis" data-column="id" checked/> {{__('og.event_categories.id')}} |
    <input type="checkbox" class="toggle-vis" data-column="order" checked/> {{__('og.event_categories.order')}} |
    <input type="checkbox" class="toggle-vis" data-column="translations.slug"
           checked/> {{__('og.event_category_translations.slug')}} |
    <input type="checkbox" class="toggle-vis" data-column="translations.name"
           checked/> {{__('og.event_category_translations.name')}} |
    <input type="checkbox" class="toggle-vis" data-column="translations.description"
           checked/> {{__('og.event_category_translations.description')}} |

    <hr>

    <div class="table-responsive">
        <table class="table table-bordered" id="data-table">
            <thead>
            <tr>
                <th>{{__('og.event_categories.id')}}</th>
                <th>{{__('og.event_categories.order')}}</th>
                <th>{{__('og.event_category_translations.slug')}}</th>
                <th>{{__('og.event_category_translations.name')}}</th>
                <th>{{__('og.event_category_translations.description')}}</th>
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
                ajax: '{!! route('back.event_categories.index', $where) !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'order', name: 'order'},
                    {data: 'slug', name: 'translations.slug', 'orderable': false},
                    {data: 'name', name: 'translations.name', 'orderable': false},
                    {data: 'description', name: 'translations.description', 'orderable': false},
                    {data: 'actions', name: 'actions', 'orderable': false}
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

            $("[data-column='translations.slug']").trigger("click");
            $("[data-column='translations.description']").trigger("click");

        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    </script>

    @include('back._common.datatables.toggleStatusJs', [
        'route' => 'back.event_categories.index'
    ])
@stop
