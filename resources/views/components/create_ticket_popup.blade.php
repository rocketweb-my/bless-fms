<!-- Add Ticket Modal Start-->
<div id="addTicketModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header pd-x-20">
                <h4 class="modal-title">Insert a new ticket</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-20">
                <div class="alert alert-info" role="alert">
                    <span class="alert-inner--icon"><i class="fe fe-bell"></i></span>
                    <strong>Info:</strong> Use this form to create a new ticket in a customer's name. Enter customer information in the form (customer name, customer email, ...) and NOT your name! Ticket will be created as if the customer submitted it.

                </div>
                <h7 class=" lh-3 mg-b-20">Required fields are marked with<small class="text-danger">*</small></h7>
                <form method="post" action="{{route('ticket.store')}}" id="create_ticket_form"  enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Name<small class="text-danger">*</small></label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email<small class="text-danger">*</small></label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category<small class="text-danger">*</small></label>
                        <select name="category" id="select-category" class="form-control custom-select">
                            @foreach(getCategoryList() as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Priority<small class="text-danger">*</small></label>
                        <select name="priority" id="select-priority" class="form-control custom-select">
                            @foreach($activePriorities as $priority)
                                <option value="{{ $priority->priority_value }}" {{ $priority->priority_value == 3 ? 'selected' : '' }}>
                                    {{ $priority->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subject<small class="text-danger">*</small></label>
                        <input type="text" class="form-control" name="subject">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Message<small class="text-danger">*</small></label>
                        <textarea class="form-control" name="message" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Attachment</label>
                        <input type="file" name="file[1]" size="50">
                        <br>
                        <input type="file" name="file[2]" size="50">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Options</label>
                        <div class="custom-controls-stacked">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="create_notify1" name="notify" value="1" checked="">
                                <span class="custom-control-label">Send email notification to the customer</span>
                            </label>
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="create_show1" name="show" value="1" checked="">
                                <span class="custom-control-label">Show the ticket after submission</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Assign this ticket to</label>
                        <select name="owner" id="select-owner" class="form-control custom-select">
                            <option value="-1" selected>> Unassigned <</option>
                            <option value="-2">> Auto-assign <</option>
                            @foreach( allUser() as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="openby" value="{{Illuminate\Support\Facades\Session::get('user_id')}}">
                </form>
            </div><!-- modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="create_ticket_form">Create Ticket</button>
            </div>
        </div>
    </div><!-- MODAL DIALOG -->
</div>
<!-- Add Ticket Modal End -->
