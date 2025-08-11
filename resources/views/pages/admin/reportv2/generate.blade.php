@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/multipleselect/multiple-select.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
    <style>
        #advancedFiltersSection .select2-container {
            width: 100% !important;
        }
        #advancedFiltersSection .select2-selection {
            min-height: 38px;
        }
    </style>
@endsection

@section('page-header')
    <div>
        <h1 class="page-title">{{__('advance_report.Generate Advanced Report')}}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">{{__('advance_report.Dashboard')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('advance-report.index')}}">{{__('advance_report.Advanced Reports')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{__('advance_report.Generate Report')}}</li>
        </ol>
    </div>
@endsection

@section('content')
    <!-- FILTER FORM -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 card-title">{{__('advance_report.Report Filters')}}</h3>
                </div>
                <div class="card-body">
                    <form id="reportForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{__('advance_report.Date Range')}} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="date_range" class="form-control" id="daterange" required>
                                        <input type="hidden" name="date_from" id="date_from">
                                        <input type="hidden" name="date_to" id="date_to">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{__('advance_report.Categories')}}</label>
                                    <select name="categories[]" class="form-control select2" multiple="multiple" id="categories">
                                        <option value="all">{{__('advance_report.Select All Categories')}}</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{__('advance_report.Status')}}</label>
                                    <select name="status[]" class="form-control select2" multiple="multiple" id="status">
                                        <option value="all">{{__('advance_report.Select All Status')}}</option>
                                        @php($statusLookups = \App\Models\LookupStatusLog::where('is_active', true)->orderBy('order', 'ASC')->get())
                                        @foreach($statusLookups as $statusLookup)
                                            <option value="{{$statusLookup->id}}">{{$statusLookup->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{__('advance_report.Priority')}}</label>
                                    <select name="priority[]" class="form-control select2" multiple="multiple" id="priority">
                                        <option value="all">{{__('advance_report.Select All Priority')}}</option>
                                        <option value="1">{{__('advance_report.High')}}</option>
                                        <option value="2">{{__('advance_report.Medium')}}</option>
                                        <option value="3">{{__('advance_report.Low')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        @if($customFields->count() > 0)
                        <!-- Advanced Filters Section -->
                        <div id="advancedFiltersSection" style="display: none;">
                            <hr>
                            <h6 class="text-info"><i class="fa fa-filter"></i> {{__('advance_report.Advanced Filters')}}</h6>
                            
                            <div class="row">
                                @foreach($customFields as $field)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{$field->localized_name}}</label>
                                        <select name="custom_field_{{$field->id}}[]" class="form-control select2" multiple="multiple" id="custom_field_{{$field->id}}" data-field-id="{{$field->id}}">
                                            <option value="all">{{__('advance_report.Select All')}} {{$field->localized_name}}</option>
                                            @foreach($field->options as $option)
                                                <option value="{{$option}}">{{$option}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" id="previewBtn">
                                    <i class="fa fa-search"></i> {{__('advance_report.Filter Data')}}
                                </button>
                                <button type="button" class="btn btn-success" id="exportBtn" style="display: none;">
                                    <i class="fa fa-file-excel"></i> {{__('advance_report.Export to Excel')}}
                                </button>
                                @if($customFields->count() > 0)
                                <button type="button" class="btn btn-outline-info" id="toggleAdvancedFilters">
                                    <i class="fa fa-plus"></i> {{__('advance_report.Show Advanced Filters')}}
                                </button>
                                @endif
                                <button type="button" class="btn btn-secondary" id="resetBtn">
                                    <i class="fa fa-refresh"></i> {{__('advance_report.Reset Filters')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- PREVIEW TABLE -->
    <div class="row" id="previewSection" style="display: none;">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 card-title">{{__('advance_report.Report Preview')}}</h3>
                    <div class="card-options">
                        <span class="badge badge-primary" id="recordCount">0 {{__('advance_report.records')}}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="reportTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{__('advance_report.Reference Number')}}</th>
                                    <th>{{__('advance_report.Title')}}</th>
                                    <th>{{__('advance_report.Details')}}</th>
                                    <th>{{__('advance_report.Complaint Date')}}</th>
                                    <th>{{__('advance_report.First Response Date')}}</th>
                                    <th>{{__('advance_report.Category')}}</th>
                                    <th>{{__('advance_report.Status')}}</th>
                                    <th>{{__('advance_report.Priority')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ticket Details Modal -->
    <div class="modal fade" id="ticketDetailsModal" tabindex="-1" role="dialog" aria-labelledby="ticketDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ticketDetailsModalLabel">{{__('advance_report.Ticket Details')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="ticketDetailsContent">
                    <div class="text-center">
                        <i class="fa fa-spinner fa-spin fa-2x"></i>
                        <p class="mt-2">{{__('advance_report.Loading')}}...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('advance_report.Close')}}</button>
                    <a href="#" id="viewFullTicket" class="btn btn-primary" target="_blank">{{__('advance_report.View Full Ticket')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/moment.min.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize date range picker
            $('#daterange').daterangepicker({
                format: 'DD/MM/YYYY',
                separator: ' to ',
                showDropdowns: true,
                showWeekNumbers: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });

            // Update hidden fields when date range changes
            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                $('#date_from').val(picker.startDate.format('YYYY-MM-DD'));
                $('#date_to').val(picker.endDate.format('YYYY-MM-DD'));
            });

            // Initialize select2
            $('.select2').select2({
                placeholder: 'Select options...',
                allowClear: true,
                width: '100%'
            });

            // Handle "Select All" functionality
            function handleSelectAll(selectId) {
                $('#' + selectId).on('change', function() {
                    var selectedValues = $(this).val();
                    
                    if (selectedValues && selectedValues.includes('all')) {
                        // If "Select All" is selected, select all other options except "all"
                        var allOptions = [];
                        $('#' + selectId + ' option').each(function() {
                            if ($(this).val() !== 'all') {
                                allOptions.push($(this).val());
                            }
                        });
                        $(this).val(allOptions).trigger('change');
                    }
                });
            }

            // Apply select all functionality to all multi-select dropdowns
            handleSelectAll('categories');
            handleSelectAll('status');
            handleSelectAll('priority');
            
            // Apply select all functionality to custom field filters
            $('select[id^="custom_field_"]').each(function() {
                var fieldId = $(this).attr('id');
                handleSelectAll(fieldId);
            });

            // Advanced filter toggle functionality
            $('#toggleAdvancedFilters').click(function() {
                var section = $('#advancedFiltersSection');
                var button = $(this);
                
                if (section.is(':visible')) {
                    section.slideUp();
                    button.html('<i class="fa fa-plus"></i> {{__('advance_report.Show Advanced Filters')}}');
                    button.removeClass('btn-outline-danger').addClass('btn-outline-info');
                } else {
                    section.slideDown();
                    button.html('<i class="fa fa-minus"></i> {{__('advance_report.Hide Advanced Filters')}}');
                    button.removeClass('btn-outline-info').addClass('btn-outline-danger');
                    
                    // Reinitialize Select2 for custom fields to fix width issues
                    setTimeout(function() {
                        $('select[id^="custom_field_"]').select2('destroy').select2({
                            placeholder: 'Select options...',
                            allowClear: true,
                            width: '100%'
                        });
                    }, 300);
                }
            });

            let table;

            // Preview button click
            $('#previewBtn').click(function() {
                // Validate date range
                if (!$('#daterange').val()) {
                    alert('{{__('advance_report.Please select a date range')}}');
                    return;
                }

                // Show loading
                $(this).html('<i class="fa fa-spinner fa-spin"></i> {{__('advance_report.Loading')}}');
                $(this).prop('disabled', true);

                // Properly destroy existing table if it exists
                if (table) {
                    table.destroy();
                    table = null;
                }

                // Clear and reset table HTML
                $('#reportTable').empty();
                $('#reportTable').html(`
                    <thead>
                        <tr>
                            <th>{{__('advance_report.Reference Number')}}</th>
                            <th>{{__('advance_report.Title')}}</th>
                            <th>{{__('advance_report.Details')}}</th>
                            <th>{{__('advance_report.Complaint Date')}}</th>
                            <th>{{__('advance_report.First Response Date')}}</th>
                            <th>{{__('advance_report.Category')}}</th>
                            <th>{{__('advance_report.Status')}}</th>
                            <th>{{__('advance_report.Priority')}}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                `);

                // Initialize new DataTable
                table = $('#reportTable').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    ajax: {
                        url: '{{ route("advance-report.preview") }}',
                        type: 'POST',
                        data: function(d) {
                            var formData = {
                                _token: '{{ csrf_token() }}',
                                date_from: $('#date_from').val(),
                                date_to: $('#date_to').val(),
                                categories: $('select[name="categories[]"]').val(),
                                status: $('select[name="status[]"]').val(),
                                priority: $('select[name="priority[]"]').val()
                            };
                            
                            // Add custom field filters
                            $('select[id^="custom_field_"]').each(function() {
                                var fieldName = $(this).attr('name');
                                var fieldValue = $(this).val();
                                if (fieldValue && fieldValue.length > 0) {
                                    formData[fieldName.replace('[]', '')] = fieldValue;
                                }
                            });
                            
                            // Debug logging
                            console.log('Sending data:', formData);
                            
                            // Merge with DataTables parameters
                            return $.extend({}, d, formData);
                        },
                        error: function(xhr, error, code) {
                            console.log('Ajax error:', error);
                            alert('{{__('advance_report.Error loading data. Please try again.')}}');
                            $('#previewBtn').html('<i class="fa fa-search"></i> {{__('advance_report.Preview Data')}}');
                            $('#previewBtn').prop('disabled', false);
                        }
                    },
                    columns: [
                        { data: 'trackid', name: 'trackid' },
                        { data: 'subject', name: 'subject' },
                        { data: 'message', name: 'message' },
                        { data: 'dt', name: 'dt' },
                        { data: 'first_response_date', name: 'first_response_date' },
                        { data: 'category_name', name: 'category_name' },
                        { data: 'status_text', name: 'status_text' },
                        { data: 'priority_text', name: 'priority_text' }
                    ],
                    order: [[3, 'desc']],
                    pageLength: 25,
                    responsive: true,
                    drawCallback: function(settings) {
                        // Update record count
                        var recordCount = settings.json.recordsTotal || 0;
                        $('#recordCount').text(recordCount + ' {{__('advance_report.records')}}');
                        
                        // Show export button if there are records
                        if (recordCount > 0) {
                            $('#exportBtn').show();
                        } else {
                            $('#exportBtn').hide();
                        }
                        
                        // Reset button text
                        $('#previewBtn').html('<i class="fa fa-search"></i> Filter Data');
                        $('#previewBtn').prop('disabled', false);
                    },
                    initComplete: function(settings, json) {
                        // Show preview section when table is ready
                        $('#previewSection').show();
                        
                        // Reset button text
                        $('#previewBtn').html('<i class="fa fa-search"></i> Filter Data');
                        $('#previewBtn').prop('disabled', false);
                    }
                });
            });

            // Export button click
            $('#exportBtn').click(function() {
                // Show loading
                $(this).html('<i class="fa fa-spinner fa-spin"></i> {{__('advance_report.Generating Excel')}}');
                $(this).prop('disabled', true);

                // Create a form and submit it for file download
                var form = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route("advance-report.export") }}'
                });

                // Add CSRF token
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': '{{ csrf_token() }}'
                }));

                // Add form data
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'date_from',
                    'value': $('#date_from').val()
                }));

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'date_to',
                    'value': $('#date_to').val()
                }));

                // Add categories
                var categories = $('select[name="categories[]"]').val();
                if (categories) {
                    categories.forEach(function(cat) {
                        form.append($('<input>', {
                            'type': 'hidden',
                            'name': 'categories[]',
                            'value': cat
                        }));
                    });
                }

                // Add status
                var status = $('select[name="status[]"]').val();
                if (status) {
                    status.forEach(function(stat) {
                        form.append($('<input>', {
                            'type': 'hidden',
                            'name': 'status[]',
                            'value': stat
                        }));
                    });
                }

                // Add priority
                var priority = $('select[name="priority[]"]').val();
                if (priority) {
                    priority.forEach(function(pri) {
                        form.append($('<input>', {
                            'type': 'hidden',
                            'name': 'priority[]',
                            'value': pri
                        }));
                    });
                }

                // Add custom field filters
                $('select[id^="custom_field_"]').each(function() {
                    var fieldName = $(this).attr('name');
                    var fieldValue = $(this).val();
                    if (fieldValue && fieldValue.length > 0) {
                        fieldValue.forEach(function(value) {
                            form.append($('<input>', {
                                'type': 'hidden',
                                'name': fieldName,
                                'value': value
                            }));
                        });
                    }
                });

                // Append form to body and submit
                $('body').append(form);
                form.submit();
                form.remove();

                // Reset button text after a short delay
                setTimeout(function() {
                    $('#exportBtn').html('<i class="fa fa-file-excel"></i> {{__('advance_report.Export to Excel')}}');
                    $('#exportBtn').prop('disabled', false);
                }, 2000);
            });

            // Reset button click
            $('#resetBtn').click(function() {
                // Reset form
                $('#reportForm')[0].reset();
                
                // Clear hidden date fields
                $('#date_from').val('');
                $('#date_to').val('');
                
                // Reset select2 dropdowns
                $('.select2').val(null).trigger('change');
                
                // Hide advanced filters section and reset button
                $('#advancedFiltersSection').hide();
                $('#toggleAdvancedFilters').html('<i class="fa fa-plus"></i> {{__('advance_report.Show Advanced Filters')}}')
                    .removeClass('btn-outline-danger').addClass('btn-outline-info');
                
                // Clear date range picker
                $('#daterange').val('');
                
                // Hide preview section and export button
                $('#previewSection').hide();
                $('#exportBtn').hide();
                $('#recordCount').text('0 {{__('advance_report.records')}}');
                
                // Properly destroy and clear the table
                if (table) {
                    table.destroy();
                    table = null;
                }
                
                // Clear the table HTML
                $('#reportTable').empty();
                $('#reportTable').html(`
                    <thead>
                        <tr>
                            <th>{{__('advance_report.Reference Number')}}</th>
                            <th>{{__('advance_report.Title')}}</th>
                            <th>{{__('advance_report.Details')}}</th>
                            <th>{{__('advance_report.Complaint Date')}}</th>
                            <th>{{__('advance_report.First Response Date')}}</th>
                            <th>{{__('advance_report.Category')}}</th>
                            <th>{{__('advance_report.Status')}}</th>
                            <th>{{__('advance_report.Priority')}}</th>
                        </tr>
                    </thead>
                `);
                
                console.log('Form reset completed');
            });

            // Ticket Details Modal Functionality
            $(document).on('click', '.ticket-detail-link', function(e) {
                e.preventDefault();
                
                var trackid = $(this).data('trackid');
                
                // Show modal with loading state
                $('#ticketDetailsModal').modal('show');
                $('#ticketDetailsContent').html(`
                    <div class="text-center">
                        <i class="fa fa-spinner fa-spin fa-2x"></i>
                        <p class="mt-2">{{__('advance_report.Loading')}}...</p>
                    </div>
                `);
                
                // Update "View Full Ticket" link
                $('#viewFullTicket').attr('href', '/ticket/' + trackid);
                
                // Fetch ticket details
                $.get('{{ route("advance-report.ticket-details", ":trackid") }}'.replace(':trackid', trackid))
                    .done(function(response) {
                        var html = `
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><strong>{{__('advance_report.Reference Number')}}:</strong></h6>
                                    <p>${response.trackid}</p>
                                    
                                    <h6><strong>{{__('advance_report.Subject')}}:</strong></h6>
                                    <p>${response.subject}</p>
                                    
                                    <h6><strong>{{__('advance_report.Customer Name')}}:</strong></h6>
                                    <p>${response.name}</p>
                                    
                                    <h6><strong>{{__('advance_report.Customer Email')}}:</strong></h6>
                                    <p>${response.email}</p>
                                    
                                    <h6><strong>{{__('advance_report.Category')}}:</strong></h6>
                                    <p>${response.category}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6><strong>{{__('advance_report.Status')}}:</strong></h6>
                                    <p>${response.status}</p>
                                    
                                    <h6><strong>{{__('advance_report.Priority')}}:</strong></h6>
                                    <p>${response.priority}</p>
                                    
                                    <h6><strong>{{__('advance_report.Owner')}}:</strong></h6>
                                    <p>${response.owner}</p>
                                    
                                    <h6><strong>{{__('advance_report.Created Date')}}:</strong></h6>
                                    <p>${response.dt}</p>
                                    
                                    <h6><strong>{{__('advance_report.Last Updated')}}:</strong></h6>
                                    <p>${response.lastchange}</p>
                                    
                                    <h6><strong>{{__('advance_report.Replies Count')}}:</strong></h6>
                                    <p>${response.replies_count}</p>
                                </div>
                            </div>
                            
                            <hr>
                        `;
                        
                        // Add custom fields if any
                        if (response.custom_fields && response.custom_fields.length > 0) {
                            html += `
                                <h6><strong>{{__('advance_report.Custom Fields')}}:</strong></h6>
                                <div class="row mb-3">
                            `;
                            
                            response.custom_fields.forEach(function(field) {
                                html += `
                                    <div class="col-md-6 mb-2">
                                        <strong>${field.name}:</strong><br>
                                        <span class="text-muted">${field.value}</span>
                                    </div>
                                `;
                            });
                            
                            html += `</div><hr>`;
                        }
                        
                        html += `
                            <h6><strong>{{__('advance_report.Message')}}:</strong></h6>
                            <div class="border p-3 mb-3" style="max-height: 200px; overflow-y: auto;">
                                ${response.message}
                            </div>
                        `;
                        
                        // Add replies if any
                        if (response.replies && response.replies.length > 0) {
                            html += `
                                <hr>
                                <h6><strong>{{__('advance_report.Recent Replies')}}:</strong></h6>
                                <div style="max-height: 300px; overflow-y: auto;">
                            `;
                            
                            response.replies.slice(-3).forEach(function(reply) {
                                html += `
                                    <div class="card mb-2">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between mb-2">
                                                <strong>${reply.name}</strong>
                                                <small class="text-muted">${reply.dt}</small>
                                            </div>
                                            <div>${reply.message}</div>
                                        </div>
                                    </div>
                                `;
                            });
                            
                            html += `</div>`;
                        }
                        
                        $('#ticketDetailsContent').html(html);
                    })
                    .fail(function() {
                        $('#ticketDetailsContent').html(`
                            <div class="alert alert-danger">
                                <i class="fa fa-exclamation-triangle"></i>
                                {{__('advance_report.Error loading ticket details. Please try again.')}}
                            </div>
                        `);
                    });
            });
        });
    </script>
@endsection