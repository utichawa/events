<form method="GET" class="form_actuality" action="{{ route('front.routes.index', $menu->slug) }}">
    <div class="row">
        <div class="form-group col-md-6">
            <input type="text" name="keywords" id="keywords" class="form-control haicop-input"
                   value="{{ request('keywords') }}" placeholder="Keywords"/>
        </div>

        @if($event_categories)
            <div class="form-group col-md-6">
                <select class="selectpicker haicop-select form-control" title="Theme"
                        id="category" name="category">
                    <option value="">---</option>
                    @foreach($event_categories as $event_category)
                        <option value="{{ $event_category->id }}"
                                {{ (request('category') == $event_category->id)?'selected':'' }}>
                            {{ $event_category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>
    <div class="row">

        <div class="form-group col-md-3">
            <div class="haicop-datepiker">
                <input type="date" class="form-control" placeholder="Date du"
                       name="start_date" id="start_date" value="{{ request('start_date') }}">
                <span class="icon"><i class="fas fa-calendar-alt"></i></span>
            </div>
        </div>
        <div class="form-group col-md-3">
            <div class="haicop-datepiker">
                <input type="date" class="form-control" placeholder="Au"
                       name="end_date" id="end_date" value="{{ request('end_date') }}">
                <span class="icon"><i class="fas fa-calendar-alt"></i></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-xs-6">
                    <button type="submit" class="btn-fill btn-black btn-block">Search</button>
                </div>
                <div class="col-xs-6">
                    <a href="{{ route('front.routes.index', $menu->slug) }}"
                       class="btn-fill btn-black btn-block">Reset</a>
                </div>
            </div>
        </div>
    </div>
</form>
