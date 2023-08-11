@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="lg:flex lg:space-x-4">
        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('trip-index.filter') }}" data-table-search="#trip-list-table" />
        </div>

        @if ($vehicles_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" data-change-submit></x-select>
        </div>

        @endif

        @if ($devices_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="device_id" :options="$devices" value="id" text="name" placeholder="{{ __('trip-index.device') }}" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="start_at" value="{{ $REQUEST->input('start_at') }}" class="form-control form-control-lg" placeholder="{{ __('trip-index.start-at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="end_at" value="{{ $REQUEST->input('end_at') }}" class="form-control form-control-lg" placeholder="{{ __('trip-index.end-at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="shared" :options="$shared" data-change-submit></x-select>
        </div>

        <div class="lg:ml-4 mt-2 lg:mt-0 bg-white">
            <a href="{{ route('trip.search') }}" class="btn form-control-lg">{{ __('trip-index.search') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto lg:overflow-visible header-sticky">
    <table id="trip-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                @if ($vehicles_multiple)
                <th>{{ __('trip-index.vehicle') }}</th>
                @endif

                @if ($devices_multiple)
                <th>{{ __('trip-index.device') }}</th>
                @endif

                <th class="text-left">{{ __('trip-index.name') }}</th>
                <th>{{ __('trip-index.start_at') }}</th>
                <th>{{ __('trip-index.end_at') }}</th>
                <th>{{ __('trip-index.distance') }}</th>
                <th>{{ __('trip-index.time') }}</th>
                <th>{{ __('trip-index.actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('trip.update.map', $row->id))

            <tr>
                @if ($vehicles_multiple)
                <td><a href="{{ $link }}" class="block">{{ $row->vehicle->name }}</a></td>
                @endif

                @if ($devices_multiple)
                <td><a href="{{ $link }}" class="block">{{ $row->device->name }}</a></td>
                @endif

                <td class="text-left"><a href="{{ $link }}" class="d-t-m-o max-w-md" title="{{ $row->name }}">{{ $row->name }}</a></td>

                <td><a href="{{ $link }}" class="block">{{ $row->start_at }}</a></td>
                <td><a href="{{ $link }}" class="block">{{ $row->end_at }}</a></td>
                <td data-table-sort-value="{{ $row->distance }}"><a href="{{ $link }}" class="block">@unitHuman('distance', $row->distance)</a></td>
                <td data-table-sort-value="{{ $row->time }}"><a href="{{ $link }}" class="block">@timeHuman($row->time)</a></td>

                <td class="w-1">
                    <a href="{{ route('trip.update', $row->id) }}">@icon('edit', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ route('trip.update.stat', $row->id) }}">@icon('bar-chart-2', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ $link }}">@icon('map', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ route('trip.update.position', $row->id) }}">@icon('map-pin', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ route('trip.update.alarm-notification', $row->id) }}">@icon('bell', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ route('trip.update.merge', $row->id) }}">@icon('git-merge', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ route('trip.update.export', $row->id) }}">@icon('package', 'w-4 h-4')</a>
                </td>
            </tr>

            @endforeach
        </tbody>

        <tfoot class="bg-white">
            <tr>
                <th colspan="{{ 3 + (int)$vehicles_multiple + (int)$devices_multiple }}"></th>
                <th>@unitHuman('distance', $list->sum('distance'))</th>
                <th>@timeHuman($list->sum('time'))</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</div>

@stop
