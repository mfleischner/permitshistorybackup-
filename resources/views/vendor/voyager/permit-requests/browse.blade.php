@extends('voyager::master')
<link rel="stylesheet" href="{{ asset('css/voyager-custom.css') }}" />
@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <h3><b>Permit Requests</b></h3>
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        @if ($isServerSide)
                            <form method="get" class="form-search">
                                <div id="search-input">
                                    <div class="col-2">
                                        <select id="search_key" name="key">
                                            @foreach ($searchNames as $key => $name)
                                                <option value="{{ $key }}" @if ($search->key == $key || (empty($search->key) && $key == $defaultSearchKey)) selected @endif>
                                                    {{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <select id="filter" name="filter">
                                            <option value="contains" @if ($search->filter == 'contains') selected @endif>contains</option>
                                            <option value="equals" @if ($search->filter == 'equals') selected @endif>=</option>
                                        </select>
                                    </div>
                                    <div class="input-group col-md-12">
                                        <input type="text" class="form-control"
                                            placeholder="{{ __('voyager::generic.search') }}" name="s"
                                            value="{{ $search->value }}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-lg" type="submit">
                                                <i class="voyager-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                @if (Request::has('sort_order') && Request::has('order_by'))
                                    <input type="hidden" name="sort_order" value="{{ Request::get('sort_order') }}">
                                    <input type="hidden" name="order_by" value="{{ Request::get('order_by') }}">
                                @endif
                            </form>
                        @endif
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" class="text-dark click-pending" href="#Pending">All</a>
                            </li>
                            <li><a data-toggle="tab" class="text-dark click-complete" href="#Completed">Completed</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="Pending" class="tab-pane fade in active">
                                <h3>All Permit Requests</h3>
                                <p>
                                <div class="row">
                                    {{-- <div class="col-md-2">
                                        <button class="btn btn-primary btn-xs approve-records" style="margin:0px">Approve
                                            Permits</button>
                                    </div> --}}
                                    <div class="col-md-4 mt-2 pull-left">
                                        <div class="col-md-6">
                                            <select name="cars" class=" form-control print-records-select" id="cars">
                                                Print
                                                <option value="null">Select to Print</option>
                                                <option value="3">All</option>
                                                <option value="4">Selected</option>
                                                <option value="0">Pending</option>
                                                <option value="1">In Progress</option>
                                                <option value="2">Completed</option>

                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-primary pull-left btn-xs print-records"
                                                style="margin:0px" disabled="true">Print</button>
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <span class="print_error m-0"></span>
                                    </div>
                                </div>

                                <!-- <small class="notify_error"></small> -->
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                @if ($showCheckboxColumn)
                                                    <th class="dt-not-orderable">
                                                        <!-- <input type="checkbox" class="select_all"> -->
                                                        #
                                                    </th>
                                                @endif
                                                @foreach ($dataType->browseRows as $row)
                                                    <th>
                                                        @if ($isServerSide && in_array($row->field, $sortableColumns))
                                                            <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                                        @endif
                                                        {{ $row->getTranslatedAttribute('display_name') }}
                                                        @if ($isServerSide)
                                                            @if ($row->isCurrentSortField($orderBy))
                                                                @if ($sortOrder == 'asc')
                                                                    <i class="voyager-angle-up pull-right"></i>
                                                                @else
                                                                    <i class="voyager-angle-down pull-right"></i>
                                                                @endif
                                                            @endif
                                                            </a>
                                                        @endif
                                                    </th>
                                                @endforeach
                                                <th class="actions text-right dt-not-orderable">
                                                    {{ __('voyager::generic.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dataTypeContent as $data)
                                                <!-- <tr class=""> -->
                                                    <tr class="{{ $data['status'] == 'Completed' ? 'hide' : '' }}" >
                                                    @if ($showCheckboxColumn)
                                                        <td>
                                                            <input type="checkbox" name="row_id"
                                                                id="checkbox_{{ $data->getKey() }}"
                                                                class="select-records" value="{{ $data->getKey() }}"
                                                                {{ $data['status'] == 'Completed' ? 'disabled' : '' }}>

                                                        </td>
                                                    @endif
                                                    @foreach ($dataType->browseRows as $row)
                                                        @php
                                                            if ($data->{$row->field . '_browse'}) {
                                                                $data->{$row->field} = $data->{$row->field . '_browse'};
                                                            }
                                                        @endphp
                                                        <td>
                                                            @if (isset($row->details->view))
                                                                @include($row->details->view, ['row' => $row, 'dataType' =>
                                                                $dataType, 'dataTypeContent' => $dataTypeContent, 'content'
                                                                => $data->{$row->field}, 'action' => 'browse', 'view' =>
                                                                'browse', 'options' => $row->details])
                                                            @elseif($row->type == 'image')
                                                                <img src="@if (!filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image($data->{$row->field}) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                            @elseif($row->type == 'relationship')
                                                                @include('voyager::formfields.relationship', ['view' =>
                                                                'browse','options' => $row->details])
                                                            @elseif($row->type == 'select_multiple')
                                                                @if (property_exists($row->details, 'relationship'))

                                                                    @foreach ($data->{$row->field} as $item)
                                                                        {{ $item->{$row->field} }}
                                                                    @endforeach

                                                                @elseif(property_exists($row->details, 'options'))
                                                                    @if (!empty(json_decode($data->{$row->field})))
                                                                        @foreach (json_decode($data->{$row->field}) as $item)
                                                                            @if (@$row->details->options->{$item})
                                                                                {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        {{ __('voyager::generic.none') }}
                                                                    @endif
                                                                @endif

                                                            @elseif($row->type == 'multiple_checkbox' &&
                                                                property_exists($row->details, 'options'))
                                                                @if (@count(json_decode($data->{$row->field})) > 0)
                                                                    @foreach (json_decode($data->{$row->field}) as $item)
                                                                        @if (@$row->details->options->{$item})
                                                                            {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    {{ __('voyager::generic.none') }}
                                                                @endif

                                                            @elseif(($row->type == 'select_dropdown' || $row->type ==
                                                                'radio_btn') && property_exists($row->details, 'options'))

                                                                <!-- {!! $row->details->options->{$data->{$row->field}} ?? '' !!} -->
                                                                <form action="javascript:;" class="row"
                                                                id="update_status_item" method="post">
                                                                <input type="hidden" name="permit_req_id" value="<?php echo $data['id'] ?>"
                                                                        id="permit_req_id">
                                                                        <input type="hidden" name="permit_req_idst" value="<?php echo $data['status'] ?>"
                                                                        id="permit_req_idst">
                                                                <div class="col-md-8">
                                                                    <select class="form-control statuschange statusval" data-permit_req_id="<?php echo $data['id'] ?>"  id="statusval" name="status">
                                                                    <option value="0" <?php echo (trim($data['status']) == 'Not Started') ? 'selected' : '' ?>>Not Started</option>
                                                                    <option value="1" <?php echo (trim($data['status']) == 'Submitted') ? 'selected' : '' ?>>Submitted</option>
                                                                    <option value="2" <?php echo (trim($data['status']) == 'In Review') ? 'selected' : '' ?>>In Review</option>
                                                                    <option value="3" <?php echo (trim($data['status']) == 'Completed') ? 'selected' : '' ?>>Completed</option>
                                                                    </select>
                                                                </div>
                                                            </form>

                                                            @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                @if (property_exists($row->details, 'format') && !is_null($data->{$row->field}))
                                                                    {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                @elseif ($row->display_name == 'Time Pending')
                                                                    @if((\Carbon\Carbon::parse($data->{$row->field})->diffInDays()) > 5)
                                                                        <span
                                                                        class="label label-danger">{{ \Carbon\Carbon::parse($data->{$row->field})->diffForHumans() }}</span>
                                                                    @else
                                                                        {{ \Carbon\Carbon::parse($data->{$row->field})->diffForHumans() }}
                                                                    @endif
                                                                @else
                                                                    {{ $data->{$row->field} }}
                                                                @endif
                                                            @elseif($row->type == 'checkbox')
                                                                @if (property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                    @if ($data->{$row->field})
                                                                        <span
                                                                            class="label label-info">{{ $row->details->on }}</span>
                                                                    @else
                                                                        <span
                                                                            class="label label-primary">{{ $row->details->off }}</span>
                                                                    @endif
                                                                @else
                                                                    {{ $data->{$row->field} }}
                                                                @endif
                                                            @elseif($row->type == 'color')
                                                                <span class="badge badge-lg"
                                                                    style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                            @elseif($row->type == 'text')
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <div>
                                                                    {{ mb_strlen($data->{$row->field}) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}
                                                                </div>
                                                            @elseif($row->type == 'text_area')
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <div>
                                                                    {{ mb_strlen($data->{$row->field}) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}
                                                                </div>
                                                            @elseif($row->type == 'file' && !empty($data->{$row->field})
                                                                )
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                @if (json_decode($data->{$row->field}) !== null)
                                                                    @foreach (json_decode($data->{$row->field}) as $file)
                                                                        <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}"
                                                                            target="_blank">
                                                                            {{ $file->original_name ?: '' }}
                                                                        </a>
                                                                        <br />
                                                                    @endforeach
                                                                @else
                                                                    <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}"
                                                                        target="_blank">
                                                                        Download
                                                                    </a>
                                                                @endif
                                                            @elseif($row->type == 'rich_text_box')
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <div>
                                                                    {{ mb_strlen(strip_tags($data->{$row->field}, '<b><i><u>')) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}
                                                                </div>
                                                            @elseif($row->type == 'coordinates')
                                                                @include('voyager::partials.coordinates-static-image')
                                                            @elseif($row->type == 'multiple_images')
                                                                @php $images = json_decode($data->{$row->field}); @endphp
                                                                @if ($images)
                                                                    @php $images = array_slice($images, 0, 3); @endphp
                                                                    @foreach ($images as $image)
                                                                        <img src="@if (!filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image($image) }}@else{{ $image }}@endif"
                                                                            style="width:50px">
                                                                    @endforeach
                                                                @endif
                                                            @elseif($row->type == 'media_picker')
                                                                @php
                                                                    if (is_array($data->{$row->field})) {
                                                                        $files = $data->{$row->field};
                                                                    } else {
                                                                        $files = json_decode($data->{$row->field});
                                                                    }
                                                                @endphp
                                                                @if ($files)
                                                                    @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                        @foreach (array_slice($files, 0, 3) as $file)
                                                                            <img src="@if (!filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image($file) }}@else{{ $file }}@endif"
                                                                                style="width:50px">
                                                                        @endforeach
                                                                    @else
                                                                        <ul>
                                                                            @foreach (array_slice($files, 0, 3) as $file)
                                                                                <li>{{ $file }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                    @if (count($files) > 3)
                                                                        {{ __('voyager::media.files_more', ['count' => count($files) - 3]) }}
                                                                    @endif
                                                                @elseif (is_array($files) && count($files) == 0)
                                                                    {{ trans_choice('voyager::media.files', 0) }}
                                                                @elseif ($data->{$row->field} != '')
                                                                    @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                        <img src="@if (!filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image($data->{$row->field}) }}@else{{ $data->{$row->field} }}@endif"
                                                                            style="width:50px">
                                                                    @else
                                                                        {{ $data->{$row->field} }}
                                                                    @endif
                                                                @else
                                                                    {{ trans_choice('voyager::media.files', 0) }}
                                                                @endif
                                                            @else
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <span>{{ $data->{$row->field} }}</span>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                    {{-- <td class="no-sort no-click bread-actions">
                                                        @foreach ($actions as $action)
                                                        @if (!method_exists($action, 'massAction'))
                                                        @include('voyager::bread.partials.actions', ['action' => $action])
                                                        @endif
                                                        @endforeach
                                                    </td> --}}
                                                    <td>
                                                        <a href="{{ url('admin/permit-requests/' . $data->getKey() . '/edit') }}"
                                                            title="Edit">
                                                            <i class=" text-dark voyager-edit"></i>
                                                        </a>
                                                        <a href="{{ url('admin/permit-requests/' . $data->getKey() . '') }}"
                                                            title="View"><i class=" text-dark voyager-eye"></i>
                                                        </a>
                                                        <a href="javascript:;" title="Delete" class="delete"
                                                            data-id="{{ $data->getKey() }}"
                                                            id="delete-{{ $data->getKey() }}"><i
                                                                class="voyager-trash"></i></a>
                                                        <a href="javascript:;" class="upload-files"
                                                            data-id="{{ $data->getKey() }}" data-file_id="{{ $data['permit_req_file_id']??null}}"  title="Upload">
                                                            <i class=" text-dark voyager-upload"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @if ($isServerSide)
                                    <div class="pull-left">
                                        <div role="status" class="show-res" aria-live="polite">
                                            {{ trans_choice('voyager::generic.showing_entries', $dataTypeContent->total(), [
                                                'from' => $dataTypeContent->firstItem(),
                                                'to' => $dataTypeContent->lastItem(),
                                                'all' => $dataTypeContent->total(),
                                            ]) }}
                                        </div>
                                    </div>
                                    <div class="pull-right">
                                        {{ $dataTypeContent->appends([
                                                's' => $search->value,
                                                'filter' => $search->filter,
                                                'key' => $search->key,
                                                'order_by' => $orderBy,
                                                'sort_order' => $sortOrder,
                                                'showSoftDeleted' => $showSoftDeleted,
                                            ])->links() }}
                                    </div>
                                @endif
                                {{-- <div class="row mt-5"><br>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btn-xs approve-records" style="margin:0px">Approve
                                            Permits</button>
                                    </div>
                                    <div class="col-md-4 mt-2 pull-left">
                                        <div class="col-md-4">
                                            <select name="cars" class=" form-control print-records-select" id="cars">
                                                Print
                                                <option value="3">All</option>
                                                <option value="4">Selected</option>
                                                <option value="0">Pending</option>
                                                <option value="1">In Progress</option>
                                                <option value="2">Completed</option>

                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-primary ull-left btn-xs print-records" style="margin:0px"
                                                disabled="true">Print</button>
                                        </div>

                                    </div>
                                </div>
                                <span class="print_error"></span> --}}
                                <!-- <small class="notify_error"></small> -->
                                <div class="container">
                                    <!-- modal for status                          -->
                                    <div class="modal fade" id="notifiy_error_modal" role="dialog">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" onclick="window.location.reload();"
                                                        class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Approve Permit Requests Status</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        <span class="notify_error"></span>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" onclick="window.location.reload();"
                                                        class="btn btn-primary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal For upload files history  -->
                                    <div class="modal fade" id="upload_files" role="dialog">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" onclick="window.location.reload();"
                                                        class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Permit Address Document History</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p> Select File to upload:
                                                    <form action="javascript:;" class="row"
                                                        id="upload_form_files" method="post" enctype="multipart/form-data">
                                                        <div class="col-md-8">
                                                            <input type="hidden" name="permit_req_id" value=""
                                                                id="permit_req_id">
                                                            <input type="file" class="form-input border-non form-lg"
                                                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                                                name="upload_docs" id="fileToUpload">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="submit" value="Upload"
                                                                class="btn btn-info btn-xs" name="submit">
                                                        </div>
                                                        <span class="uploaded_files_status"></span>
                                                    </form>

                                                    <ul class="list-group overflow-auto" style="overflow-y: scroll; height: 300px !important;">

                                                        <li class="list-group-item list-group-item-action active"><b>Files
                                                            </b></li>
                                                        <span class="uploaded_files_history"></span>
                                                    </ul>

                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" onclick="window.location.reload();"
                                                        class="btn btn-primary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                                </p>
                            </div>

                            <!-- +++++++++++++++++++++++++++++Completed Permits Tab+++++++++++++++++++++++ -->

                            <div id="Completed" class="tab-pane fade">
                                <h3 class="mb-3">Approved Permit Requests</h3>
                                <p>
                                <div class="table-responsive">
                                    <table id="dataTable_2" class="table table-hover border">
                                        <thead>
                                            <tr>
                                                @if ($showCheckboxColumn)
                                                    <th class="dt-not-orderable">
                                                        <!-- <input type="checkbox" class="select_all"> -->
                                                        #
                                                    </th>
                                                @endif
                                                @foreach ($dataType->browseRows as $row)
                                                    <th>
                                                        @if ($isServerSide && in_array($row->field, $sortableColumns))
                                                            <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                                        @endif
                                                        {{ $row->getTranslatedAttribute('display_name') }}
                                                        @if ($isServerSide)
                                                            @if ($row->isCurrentSortField($orderBy))
                                                                @if ($sortOrder == 'asc')
                                                                    <i class="voyager-angle-up pull-right"></i>
                                                                @else
                                                                    <i class="voyager-angle-down pull-right"></i>
                                                                @endif
                                                            @endif
                                                            </a>
                                                        @endif
                                                    </th>
                                                @endforeach
                                                <th class="actions text-right dt-not-orderable">
                                                    {{ __('voyager::generic.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dataTypeContent as $data)
                                                <tr class="{{ $data['status'] != 'Completed' ? 'hide' : '' }}">
                                                    @if ($showCheckboxColumn)
                                                        <td>
                                                            @if ($data['status'] != 'Completed')
                                                                <input type="checkbox" name="row_id"
                                                                    id="checkbox_{{ $data->getKey() }}"
                                                                    class="select-records"
                                                                    value="{{ $data->getKey() }}">
                                                            @else
                                                                <span class="badge badge-success badge-white"> Approved
                                                                </span>
                                                            @endif

                                                        </td>
                                                    @endif
                                                    @foreach ($dataType->browseRows as $row)
                                                        @php
                                                            if ($data->{$row->field . '_browse'}) {
                                                                $data->{$row->field} = $data->{$row->field . '_browse'};
                                                            }

                                                        @endphp
                                                        <td>
                                                            @if (isset($row->details->view))
                                                                @include($row->details->view, ['row' => $row, 'dataType' =>
                                                                $dataType, 'dataTypeContent' => $dataTypeContent, 'content'
                                                                => $data->{$row->field}, 'action' => 'browse', 'view' =>
                                                                'browse', 'options' => $row->details])
                                                            @elseif($row->type == 'image')
                                                                <img src="@if (!filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image($data->{$row->field}) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                            @elseif($row->type == 'relationship')
                                                                @include('voyager::formfields.relationship', ['view' =>
                                                                'browse','options' => $row->details])
                                                            @elseif($row->type == 'select_multiple')
                                                                @if (property_exists($row->details, 'relationship'))

                                                                    @foreach ($data->{$row->field} as $item)
                                                                        {{ $item->{$row->field} }}
                                                                    @endforeach

                                                                @elseif(property_exists($row->details, 'options'))
                                                                    @if (!empty(json_decode($data->{$row->field})))
                                                                        @foreach (json_decode($data->{$row->field}) as $item)
                                                                            @if (@$row->details->options->{$item})
                                                                                {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        {{ __('voyager::generic.none') }}
                                                                    @endif
                                                                @endif

                                                            @elseif($row->type == 'multiple_checkbox' &&
                                                                property_exists($row->details, 'options'))
                                                                @if (@count(json_decode($data->{$row->field})) > 0)
                                                                    @foreach (json_decode($data->{$row->field}) as $item)
                                                                        @if (@$row->details->options->{$item})
                                                                            {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    {{ __('voyager::generic.none') }}
                                                                @endif

                                                            @elseif(($row->type == 'select_dropdown' || $row->type ==
                                                                'radio_btn') && property_exists($row->details, 'options'))

                                                                <!-- {!! $row->details->options->{$data->{$row->field}} ?? '' !!} -->
                                                                <form action="javascript:;" class="row"
                                                                id="update_status_item" method="post">
                                                                <input type="hidden" name="permit_req_id" value="<?php echo $data['id'] ?>"
                                                                        class="permit_req_id">
                                                                        <input type="hidden" name="permit_req_idst" value="<?php echo $data['status'] ?>"
                                                                        id="permit_req_idst">
                                                                <div class="col-md-8">
                                                                <select class="form-control statuschange statusval" data-permit_req_id="<?php echo $data['id'] ?>"  id="statusval" name="status">
                                                                    <option value="0" <?php echo (trim($data['status']) == 'Not Started') ? 'selected' : '' ?>>Not Started</option>
                                                                    <option value="1" <?php echo (trim($data['status']) == 'Submitted') ? 'selected' : '' ?>>Submitted</option>
                                                                    <option value="2" <?php echo (trim($data['status']) == 'In Review') ? 'selected' : '' ?>>In Review</option>
                                                                    <option value="3" <?php echo (trim($data['status']) == 'Completed') ? 'selected' : '' ?>>Completed</option>
                                                                    </select>
                                                                </div>
                                                            </form>
                                                            @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                                @if (property_exists($row->details, 'format') && !is_null($data->{$row->field}))
                                                                    {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                                @elseif ($row->display_name == 'Time Pending')
                                                                    @if((\Carbon\Carbon::parse($data->{$row->field})->diffInDays()) > 5)
                                                                        <span
                                                                        class="label label-danger">{{ \Carbon\Carbon::parse($data->{$row->field})->diffForHumans() }}</span>
                                                                    @else
                                                                        {{ \Carbon\Carbon::parse($data->{$row->field})->diffForHumans() }}
                                                                    @endif
                                                                @else
                                                                    {{ $data->{$row->field} }}
                                                                @endif
                                                            @elseif($row->type == 'checkbox')
                                                                @if (property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                                    @if ($data->{$row->field})
                                                                        <span
                                                                            class="label label-info">{{ $row->details->on }}</span>
                                                                    @else
                                                                        <span
                                                                            class="label label-primary">{{ $row->details->off }}</span>
                                                                    @endif
                                                                @else
                                                                    {{ $data->{$row->field} }}
                                                                @endif
                                                            @elseif($row->type == 'color')
                                                                <span class="badge badge-lg"
                                                                    style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                            @elseif($row->type == 'text')
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <div>
                                                                    {{ mb_strlen($data->{$row->field}) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}
                                                                </div>
                                                            @elseif($row->type == 'text_area')
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <div>
                                                                    {{ mb_strlen($data->{$row->field}) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}
                                                                </div>
                                                            @elseif($row->type == 'file' && !empty($data->{$row->field})
                                                                )
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                @if (json_decode($data->{$row->field}) !== null)
                                                                    @foreach (json_decode($data->{$row->field}) as $file)
                                                                        <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}"
                                                                            target="_blank">
                                                                            {{ $file->original_name ?: '' }}
                                                                        </a>
                                                                        <br />
                                                                    @endforeach
                                                                @else
                                                                    <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}"
                                                                        target="_blank">
                                                                        Download
                                                                    </a>
                                                                @endif
                                                            @elseif($row->type == 'rich_text_box')
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <div>
                                                                    {{ mb_strlen(strip_tags($data->{$row->field}, '<b><i><u>')) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}
                                                                </div>
                                                            @elseif($row->type == 'coordinates')
                                                                @include('voyager::partials.coordinates-static-image')
                                                            @elseif($row->type == 'multiple_images')
                                                                @php $images = json_decode($data->{$row->field}); @endphp
                                                                @if ($images)
                                                                    @php $images = array_slice($images, 0, 3); @endphp
                                                                    @foreach ($images as $image)
                                                                        <img src="@if (!filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image($image) }}@else{{ $image }}@endif"
                                                                            style="width:50px">
                                                                    @endforeach
                                                                @endif
                                                            @elseif($row->type == 'media_picker')
                                                                @php
                                                                    if (is_array($data->{$row->field})) {
                                                                        $files = $data->{$row->field};
                                                                    } else {
                                                                        $files = json_decode($data->{$row->field});
                                                                    }
                                                                @endphp
                                                                @if ($files)
                                                                    @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                        @foreach (array_slice($files, 0, 3) as $file)
                                                                            <img src="@if (!filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image($file) }}@else{{ $file }}@endif"
                                                                                style="width:50px">
                                                                        @endforeach
                                                                    @else
                                                                        <ul>
                                                                            @foreach (array_slice($files, 0, 3) as $file)
                                                                                <li>{{ $file }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                    @if (count($files) > 3)
                                                                        {{ __('voyager::media.files_more', ['count' => count($files) - 3]) }}
                                                                    @endif
                                                                @elseif (is_array($files) && count($files) == 0)
                                                                    {{ trans_choice('voyager::media.files', 0) }}
                                                                @elseif ($data->{$row->field} != '')
                                                                    @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                                        <img src="@if (!filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image($data->{$row->field}) }}@else{{ $data->{$row->field} }}@endif"
                                                                            style="width:50px">
                                                                    @else
                                                                        {{ $data->{$row->field} }}
                                                                    @endif
                                                                @else
                                                                    {{ trans_choice('voyager::media.files', 0) }}
                                                                @endif
                                                            @else
                                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                                <span>{{ $data->{$row->field} }}</span>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                    {{-- <td class="no-sort no-click bread-actions">
                                                        @foreach ($actions as $action)
                                                        @if (!method_exists($action, 'massAction'))
                                                        @include('voyager::bread.partials.actions', ['action' => $action])
                                                        @endif
                                                        @endforeach
                                                    </td> --}}
                                                    <td>
                                                        <a href="{{ url('admin/permit-requests/' . $data->getKey() . '/edit') }}"
                                                            title="Edit">
                                                            <i class=" text-dark voyager-edit"></i>
                                                        </a>
                                                        <a href="{{ url('admin/permit-requests/' . $data->getKey() . '') }}"
                                                            title="View"><i class=" text-dark voyager-eye"></i>
                                                        </a>
                                                        <a href="javascript:;" title="Delete" class="delete"
                                                            data-id="{{ $data->getKey() }}"
                                                            id="delete-{{ $data->getKey() }}"><i
                                                                class="voyager-trash"></i></a>
                                                     <!--    <a href="javascript:;" class="upload-files"
                                                            data-id="{{ $data->getKey() }}" title="Upload">
                                                            <i class=" text-dark voyager-upload"></i> -->
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                </p>

                                @if ($isServerSide)
                                    <div class="pull-left">
                                        <div role="status" class="show-res" aria-live="polite">
                                            {{ trans_choice('voyager::generic.showing_entries', $dataTypeContent->total(), [
                                                'from' => $dataTypeContent->firstItem(),
                                                'to' => $dataTypeContent->lastItem(),
                                                'all' => $dataTypeContent->total(),
                                            ]) }}
                                        </div>
                                    </div>
                                    <div class="pull-right">
                                        {{ $dataTypeContent->appends([
                                                's' => $search->value,
                                                'filter' => $search->filter,
                                                'key' => $search->key,
                                                'order_by' => $orderBy,
                                                'sort_order' => $sortOrder,
                                                'showSoftDeleted' => $showSoftDeleted,
                                            ])->links() }}
                                    </div>
                                @endif
                                <!--     <button class="btn btn-primary btn-xs approve-records">Approve Permits</button>
                            <small class="notify_error"></small> -->
                            </div>

                            <div class="modal fade" id="upload_status" role="dialog">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" onclick="window.location.reload();"
                                                        class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Permit Request Status Update</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p> Select status:
                                                    <form action="javascript:;" class="row"
                                                        id="update_status_item" method="post">
                                                        <input type="hidden" name="permit_req_id" value=""
                                                                class="permit_req_id">
                                                        <div class="col-md-8">
                                                            <select class="form-control" id="statusval1" name="status">
                                                            <option value="0">Not Started</option>
                                                            <option value="1">Submitted</option>
                                                            <option value="2">In Review</option>
                                                            <option value="3">Completed</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="submit" value="Update"
                                                                class="btn btn-info btn-xs upload-btn-files" name="submit">
                                                        </div>
                                                        <span class="uploaded_files_status"></span>
                                                    </form>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" onclick="window.location.reload();"
                                                        class="btn btn-primary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i>
                        {{ __('voyager::generic.delete_question') }}
                        {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                            value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                        data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop


@section('css')
    @if (!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
    @endif
@stop

@section('javascript')
    <!-- DataTables -->
    @if (!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script>
        var storedSelectedAddress = [];
        $(document).ready(function() {
            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({!! json_encode(
    array_merge(
        [
            'order' => $orderColumn,
            'pageLength'=> 100,
            'language' => __('voyager::datatable'),
            'columnDefs' => [['targets' => 'dt-not-orderable', 'searchable' => false, 'orderable' => false]],
        ],
        config('voyager.dashboard.data_tables', []),
    ),
    true,
) !!});

                var table = $('#dataTable_2').DataTable({!! json_encode(
    array_merge(
        [
            'order' => $orderColumn,
            'pageLength'=> 100,
            'language' => __('voyager::datatable'),
            'columnDefs' => [['targets' => 'dt-not-orderable', 'searchable' => false, 'orderable' => false]],
        ],
        config('voyager.dashboard.data_tables', []),
    ),
    true,
) !!});

            @else
                $('#search-input select').select2({
                minimumResultsForSearch: Infinity
                });
            @endif

            @if ($isModelTranslatable)
                $('.side-body').multilingual();
                //Reinitialise the multilingual features when they change tab
                $('#dataTable').on('draw.dt', function(){
                $('.side-body').data('multilingual').init();
                })
                $('#dataTable_2').on('draw.dt', function(){
                $('.side-body').data('multilingual').init();
                })
            @endif
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked')).trigger('change');
                $("input:checkbox[name=row_id]:checked").each(function() {
                    storedSelectedAddress.push($(this).val());
                });
            });
        });


        var deleteFormAction;
        $('td').on('click', '.delete', function(e) {
            $('#delete_form')[0].action = '{{ route('voyager.' . $dataType->slug . '.destroy', '__id') }}'.replace(
                '__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });

        @if ($usesSoftDeletes)
            @php
                $params = [
                    's' => $search->value,
                    'filter' => $search->filter,
                    'key' => $search->key,
                    'order_by' => $orderBy,
                    'sort_order' => $sortOrder,
                ];
            @endphp
            $(function() {
            $('#show_soft_deletes').change(function() {
            if ($(this).prop('checked')) {
            $('#dataTable').before('<a id="redir"               href="{{ route('voyager.' . $dataType->slug . '.index', array_merge($params, ['showSoftDeleted' => 1]), true) }}"></a>');
            $('#dataTable_2').before('<a id="redir"                href="{{ route('voyager.' . $dataType->slug . '.index', array_merge($params, ['showSoftDeleted' => 1]), true) }}"></a>');
            }else{
            $('#dataTable').before('<a id="redir"                href="{{ route('voyager.' . $dataType->slug . '.index', array_merge($params, ['showSoftDeleted' => 0]), true) }}"></a>');
            $('#dataTable_2').before('<a id="redir"                href="{{ route('voyager.' . $dataType->slug . '.index', array_merge($params, ['showSoftDeleted' => 0]), true) }}"></a>');
            }

            $('#redir')[0].click();
            })
            })
        @endif
        var url = window.location.origin;

        $('.print-records-select').on('change', function() {
            var valIs = $('.print-records-select').val();
            if (valIs != '')
                $('.print-records').prop("disabled", false);

            if (empty(valIs))
                $('.print-records').prop("disabled", true);

        });
        $('.print-records').on('click', function() {
            var valIs = $('.print-records-select').val();

            if (storedSelectedAddress.length == 0 && valIs == 4) {
                $('.print_error').html(
                    '<br/> <span class="text-danger"><b> <i class="fa fa-spinner fa-spin " aria-hidden="true"></i></b> Please select permits to print.</span>'
                    );
                $('.print-records').prop('selectedIndex', 0);
                return true;
            }
            if (valIs != null) {
                if (storedSelectedAddress.length > 0 && valIs == 4) {
                    window.open(url + '/admin/permit-requests/print/' + valIs + '/' + storedSelectedAddress
                        .toString(), '_blank').focus();
                } else {
                    window.open(url + '/admin/permit-requests/print/' + valIs + '/');
                    $('.print_error').html(
                        '<br/> <span class="text-dark"><b> <i class="fa fa-spinner fa-spin " aria-hidden="true"></i></b></span>'
                        );
                }
            }
        });

        $('.print-records-all').on('click', function() {
            window.open(url + '/admin/permit-requests/print/');
        });

        $('.approve-records').on('click', function() {
            if (storedSelectedAddress.length > 0) {
                $('#notifiy_error_modal').modal('show');
                $('.notify_error').html(
                    '<br/> <span class="text-dark"><b> <i class="fa fa-spinner fa-spin " aria-hidden="true"></i> Processing . .</b></span>'
                    );
                var tempUrl = url + '/permit-request-approve/' + storedSelectedAddress.toString();
                $.ajax({
                    type: "GET",
                    url: tempUrl,
                    success: function(result) {
                        if (result == 1) {
                            $('.notify_error').html(
                                '<br/> <span class="text-success"><b>Sucessfully Approved and sent email notifications</b></span>'
                                );
                        } else if (result == 2) {
                            $('.notify_error').html(
                                '<br/> <span class="text-danger"><b>Requested address not matching with permit address.</b></span>'
                                );
                        } else if (result == 3) {
                            $('.notify_error').html(
                                '<br/> <span class="text-danger"><b>Not Matching with any address</b></span>'
                                );
                        } else {
                            $('.notify_error').html(
                                '<br/><span class="text-danger"><b>Problem while approving permit requests.</b></span>'
                                );
                        }

                    }
                });ppermitReq
            } else {
                $('#notifiy_error_modal').modal('show');
                $('.notify_error').html(
                    '<br/> <span class="text-danger"><b># ERROR :  Please select at list one permit request to approve.</b></span>'
                    );

            }
        });
        $('.statuschange').on('click', function(e) {
            e.preventDefault();
            var permitReqId = $(this).data('permit_req_id');
            var status = $(this).val();
            $.ajax({
                url: url + '/permit-request-status-update/' + permitReqId +'/'+ status,
                type: 'POST',
                data: { status : 'status' },
                success: function(data) {
                    console.log(permitReqId);
                    if (data == 'file not found') { // error with file upload
                        $('.uploaded_files_status').html('Status not updated.');
                        $('.uploaded_files_status').addClass('text-danger');
                        window.location.reload();
                    } else { // successfully uploaded
                        $('.uploaded_files_status').html('Status updated successfully.');
                        $('.uploaded_files_status').addClass('text-success');
                        $('#status').val("");
                        window.location.reload();
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

        $('.upload-files').on('click', function() {
            var id = $(this).attr("data-id");
            var file_id = $(this).attr("data-file_id");
            $('#permit_req_id').val(id);
            $('#upload_files').modal('show');
            getPermitRequestDocuments(id);
        });

        $('.upload-status').on('click', function() {
            var id = $(this).attr("data-id");
            $('#permit_req_id').val(id);
            $('#upload_status').modal('show');
        });


        $("form#upload_form_files").submit(function(e) {
            e.preventDefault();
            $('.uploaded_files_status').html('uploading . . .');
            var formData = new FormData(this);
            var permitReqId = $('#permit_req_id').val();
            $.ajax({
                url: url + '/permit-request-document-upload/' + permitReqId,
                type: 'POST',
                data: formData,
                success: function(data) {
                    if (data == 'file not found') { // error with file upload
                        $('.uploaded_files_status').html('File uploaded not selected.');
                        $('.uploaded_files_status').addClass('text-danger.');
                    } else { // successfully uploaded
                        $('.uploaded_files_status').html('File uploaded successfully.');
                        $('#fileToUpload').val("");
                        getPermitRequestDocuments(permitReqId);
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
        // $('#statusval').on('change', function(e) {
        //     alert("hi");
        //     e.preventDefault();
        //     var permitReqId = $('#permit_req_id').val();
        //     var status = $('#statusval').val();
        //     $.ajax({
        //         url: url + '/permit-request-status-update/' + permitReqId +'/'+ status,
        //         type: 'POST',
        //         data: { status : 'status' },
        //         success: function(data) {
        //             console.log(permitReqId);
        //             if (data == 'file not found') { // error with file upload
        //                 $('.uploaded_files_status').html('Status not updated.');
        //                 $('.uploaded_files_status').addClass('text-danger');
        //             } else { // successfully uploaded
        //                 $('.uploaded_files_status').html('Status updated successfully.');
        //                 $('.uploaded_files_status').addClass('text-success');
        //                 $('#status').val("");
        //             }
        //         },
        //         cache: false,
        //         contentType: false,
        //         processData: false
        //     });
        // });

        function getPermitRequestDocuments(id) {
            $.ajax({
                url: url + '/get-permit-request-document/' + id,
                type: 'GET',
                success: function(data) {
                    var html = '';
                    var flagMark = '';
                    var colormark = '';
                    var img_url = "{{asset('images/success_tick.png')}}";
                    var count = data.length;

                    for (var i = 0; i < count; i++) {
                        if(data[i][
                            'permit_req_file_id'] == data[i][
                            'file_id']){
                            colormark = 'border-left ';
                            flagMark    = "<b class='text-success'><img src='"+img_url+"' width='17px'> Matched </b>";

                        }else{
                            flagMark = '';
                            colormark = 'text-dark';
                        }

                        html += '<li class="list-group-item '+colormark+'">  ' + (i + 1) + '. ' + data[i][
                            'file_name'] + '  <a class="text-dark" href="' + url + '/storage/upload_docs/' +
                            data[i]['file_name'] +
                            '">  <i class=" text-dark voyager-download pull-right"></i>  </a>  <br> '+flagMark +' <small class="text-dark"> ' +
                            (data[i]['created_at'] ? ' Date :' + data[i]['created_at'] : '') +
                            ' </small>  </li>';
                    }

                    if (data.length == 0) {
                        html += '<li class="list-group-item"> No documents Found</li>';
                    }
                    $('.uploaded_files_history').html(html)
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }


        var storedSelectedAddress = [];
        $('.select-records').on('click', function() {
            if ($(this).is(':checked')) {
                storedSelectedAddress.push($(this).val())
            } else {
                const index = storedSelectedAddress.indexOf($(this).val());
                if (index > -1) {
                    storedSelectedAddress.splice(index, 1);
                }
            }

        });
    </script>
@stop
