@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet">
@endsection
@section('page-header')
						<!-- PAGE-HEADER -->
							<div>
								<h1 class="page-title">{{__('custom_field.Custom Fields')}}</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">{{__('custom_field.Custom Fields')}}</a></li>
								</ol>
							</div>
						<!-- PAGE-HEADER END -->
@endsection
@section('content')

						<!-- ROW-1 OPEN -->
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                @if (count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <i class="fa fa-exclamation mr-2" aria-hidden="true"></i> {{ $error }}
                                        </div>
                                    @endforeach
                                @endif
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"></h3>
                                        <div class="card-options">
                                            <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#addCustomFieldModal">{{__('custom_field.New Custom Field')}}</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="custom_field_table" class="table table-striped table-bordered text-nowrap display" style="width:100% !important;">
                                                <thead>
                                                <tr>
                                                    <th class="">No</th>
                                                    <th class="">{{__('custom_field.Field Name')}}</th>
                                                    <th class="">{{__('custom_field.Type')}}</th>
                                                    <th class="">{{__('custom_field.Visibility')}}</th>
                                                    <th class="">{{__('custom_field.Required')}}</th>
                                                    <th class="">{{__('custom_field.Category')}}</th>
                                                    <th class="">{{__('custom_field.Position')}}</th>
                                                    <th class="">{{__('custom_field.Action')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					<!-- CONTAINER CLOSED -->
                    <!-- ADD CUSTOM FIELD MODAL -->
                    <div class="modal fade" id="addCustomFieldModal" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="example-Modal3">{{__('custom_field.New Custom Field')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{route('custom_field.store')}}" id="addCustomField">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">{{__('custom_field.Field Name')}}:</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">{{__('custom_field.Type')}}:</label>
                                            <select name="type" id="type" class="form-control custom-select"  v-on:change="typeChange($event)">
                                                <option value="text" selected>Text Field</option>
                                                <option value="textarea">Large Text Box</option>
                                                <option value="radio">Radio Button</option>
                                                <option value="select">Select Box</option>
                                                <option value="checkbox">Checkbox</option>
                                                <option value="date">Date</option>
                                                <option value="email">Email</option>
                                                <option value="hidden">Hidden</option>
                                            </select>
                                        </div>
                                        <!-- Type == Text Start-->
                                        <div v-if="type === 'text'">
                                            <div class="form-group">
                                                <label class="form-control-label">{{__('custom_field.Maximum length (chars)')}}:</label>
                                                <input type="text" name="max_length" value="255" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-control-label">{{__('custom_field.Default value')}}:</label>
                                                <input type="text" class="form-control" name="default_value" value="">
                                            </div>
                                        </div>
                                        <!-- Type == Text End-->

                                        <!-- Type == TextArea Start-->
                                        <div v-if="type === 'textarea'">
                                            <div class="form-group">
                                                <label class="form-control-label">{{__('custom_field.Rows (height)')}}</label>
                                                <input type="text" class="form-control" name="rows" value="12">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-control-label">{{__('custom_field.Columns (width)')}}</label>
                                                <input type="text" class="form-control" name="cols" value="60">
                                            </div>
                                        </div>
                                        <!-- Type == TextArea End-->

                                        <!-- Type == Radio Start-->
                                        <div v-if="type === 'radio'">
                                            <p>{{__('custom_field.Options for this radio button, enter one option per line (each line will create a new radio button value to choose from). You need to enter at least two options!')}}</p>
                                            <textarea name="radio_options" class="form-control " rows="8" cols="40" style="height: inherit;"></textarea>
                                            <br>
                                        </div>
                                        <!-- Type == Radio End-->

                                        <!-- Type == Select Start-->
                                        <div v-if="type === 'select'">
                                            <p>{{__('custom_field.Options for this select box, enter one option per line (each line will be a choice your customers can choose from). You need to enter at least two options!')}}</p>
                                            <textarea name="select_options" class="form-control " rows="8" cols="40" style="height: inherit;"></textarea>
                                            <br>
                                        </div>
                                        <!-- Type == Select End-->

                                        <!-- Type == CheckBox Start-->
                                        <div v-if="type === 'checkbox'">
                                            <p>{{__('custom_field.Options for this checkbox, enter one option per line. Each line will be a choice your customers can choose from, multiple choices are possible.')}}</p>
                                            <textarea name="checkbox_options" class="form-control " rows="8" cols="40" style="height: inherit;"></textarea>
                                            <br>
                                        </div>
                                        <!-- Type == CheckBox End-->

                                        <!-- Type == Hidden Start-->
                                        <div v-if="type === 'hidden'">

                                            <div class="form-group">
                                                <label class="form-control-label">{{__('custom_field.Default value')}}:</label>
                                                <input type="text" class="form-control" name="hidden_default_value" value="">
                                            </div>
                                        </div>
                                        <!-- Type == Hidden End-->

                                        <!-- Default For All Start-->

                                        <div class="form-group form-elements">
                                            <label class="form-control-label">{{__('custom_field.Visibility')}}:</label>
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="use" value="1" checked>
                                                    <span class="custom-control-label">{{__('custom_field.Public')}}</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="use" value="2">
                                                    <span class="custom-control-label">S{{__('custom_field.Staff Only')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group form-elements">
                                            <label class="form-control-label">{{__('custom_field.Required')}}:</label>
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="req" value="0" checked>
                                                    <span class="custom-control-label">{{__('custom_field.No')}}</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="req" value="2">
                                                    <span class="custom-control-label">{{__('custom_field.Yes')}}</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="req" value="1">
                                                    <span class="custom-control-label">{{__('custom_field.For customers')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group form-elements">
                                            <label class="form-control-label">{{__('custom_field.Position')}}:</label>
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="place" value="0" checked>
                                                    <span class="custom-control-label">{{__('custom_field.Before Message')}}</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="place" value="1">
                                                    <span class="custom-control-label">{{__('custom_field.After Message')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group form-elements">
                                            <label class="form-control-label">{{__('custom_field.Category')}}:</label>
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="category" value="0" checked>
                                                    <span class="custom-control-label">{{__('custom_field.All')}}</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="category" value="1">
                                                    <span class="custom-control-label">{{__('custom_field.Selected')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- Default For All End-->

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('custom_field.Close')}}</button>
                                    <button type="submit" form="addCustomField" class="btn btn-primary">{{__('custom_field.Save Custom Field')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ADD CUSTOM FIELD MODAL CLOSED -->
                    <!-- ADD CUSTOM FIELD MODAL -->
                    <div class="modal fade" ref="editmodal" id="editCustomFieldModal" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="example-Modal3">{{__('custom_field.Edit Custom Field')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{route('custom_field.update')}}" id="editCustomField">
                                        @csrf
                                        <input type="hidden" name="id" v-model="editId">
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">{{__('custom_field.Field Name')}}:</label>
                                            <input type="text" class="form-control" id="name" name="name" v-model="editName">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">{{__('custom_field.Type')}}:</label>
                                            <select name="type" id="type_edit" class="form-control custom-select" v-model="editType" v-on:change="edittypeChange($event)">
                                                <option value="text" selected>Text Field</option>
                                                <option value="textarea">Large Text Box</option>
                                                <option value="radio">Radio Button</option>
                                                <option value="select">Select Box</option>
                                                <option value="checkbox">Checkbox</option>
                                                <option value="date">Date</option>
                                                <option value="email">Email</option>
                                                <option value="hidden">Hidden</option>
                                            </select>
                                        </div>
                                        <!-- Type == Text Start-->
                                        <div v-if="editType === 'text'">
                                            <div class="form-group">
                                                <label class="form-control-label">{{__('custom_field.Maximum length (chars)')}}:</label>
                                                <input type="text" name="max_length" value="255" v-model="editMaxLength" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-control-label">{{__('custom_field.Default value')}}:</label>
                                                <input type="text" class="form-control" name="default_value" v-model="editDefaultValue" value="">
                                            </div>
                                        </div>
                                        <!-- Type == Text End-->

                                        <!-- Type == TextArea Start-->
                                        <div v-if="editType === 'textarea'">
                                            <div class="form-group">
                                                <label class="form-control-label">{{__('custom_field.Rows (height)')}}</label>
                                                <input type="text" class="form-control" name="rows" v-model="editRows" value="12">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-control-label">{{__('custom_field.Columns (width)')}}</label>
                                                <input type="text" class="form-control" name="cols" v-model="editColumns" value="60">
                                            </div>
                                        </div>
                                        <!-- Type == TextArea End-->

                                        <!-- Type == Radio Start-->
                                        <div v-if="editType === 'radio'">
                                            <p>{{__('custom_field.Options for this radio button, enter one option per line (each line will create a new radio button value to choose from). You need to enter at least two options!')}}</p>
                                            <textarea name="radio_options" class="form-control " rows="8" cols="40" style="height: inherit;" v-html="editRadioOptions"></textarea>
                                            <br>
                                        </div>
                                        <!-- Type == Radio End-->

                                        <!-- Type == Select Start-->
                                        <div v-if="editType === 'select'">
                                            <p>{{__('custom_field.Options for this select box, enter one option per line (each line will be a choice your customers can choose from). You need to enter at least two options!')}}</p>
                                            <textarea name="select_options" class="form-control " rows="8" cols="40" style="height: inherit;" v-html="editSelectOptions"></textarea>
                                            <br>
                                        </div>
                                        <!-- Type == Select End-->

                                        <!-- Type == CheckBox Start-->
                                        <div v-if="editType === 'checkbox'">
                                            <p>{{__('custom_field.Options for this checkbox, enter one option per line. Each line will be a choice your customers can choose from, multiple choices are possible.')}}</p>
                                            <textarea name="checkbox_options" class="form-control " rows="8" cols="40" style="height: inherit;" v-html="editCheckBoxOptions"></textarea>
                                            <br>
                                        </div>
                                        <!-- Type == CheckBox End-->

                                        <!-- Type == Hidden Start-->
                                        <div v-if="editType === 'hidden'">

                                            <div class="form-group">
                                                <label class="form-control-label">{{__('custom_field.Default value')}}:</label>
                                                <input type="text" class="form-control" name="hidden_default_value" value="" v-model="editDefaultValueHidden">
                                            </div>
                                        </div>
                                        <!-- Type == Hidden End-->

                                        <!-- Default For All Start-->

                                        <div class="form-group form-elements">
                                            <label class="form-control-label">{{__('custom_field.Visibility')}}:</label>
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="use" v-model="editUse" value="1" checked>
                                                    <span class="custom-control-label">{{__('custom_field.Public')}}</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="use" v-model="editUse" value="2">
                                                    <span class="custom-control-label">{{__('custom_field.Staff Only')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group form-elements">
                                            <label class="form-control-label">{{__('custom_field.Required')}}:</label>
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="req" v-model="editReq" value="0" checked>
                                                    <span class="custom-control-label">{{__('custom_field.No')}}</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="req" v-model="editReq" value="2">
                                                    <span class="custom-control-label">{{__('custom_field.Yes')}}</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="req" v-model="editReq" value="1">
                                                    <span class="custom-control-label">{{__('custom_field.For customers')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group form-elements">
                                            <label class="form-control-label">{{__('custom_field.Position')}}:</label>
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="place" value="0" v-model="editPlace" checked>
                                                    <span class="custom-control-label">{{__('custom_field.Before Message')}}</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="place" v-model="editPlace" value="1">
                                                    <span class="custom-control-label">{{__('custom_field.After Message')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group form-elements">
                                            <label class="form-control-label">{{__('custom_field.Category')}}:</label>
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="category" value="0"checked>
                                                    <span class="custom-control-label">{{__('custom_field.All')}}</span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="category" value="1">
                                                    <span class="custom-control-label">{{__('custom_field.Selected')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- Default For All End-->

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('custom_field.Close')}}</button>
                                    <button type="submit" form="editCustomField" class="btn btn-primary">{{__('custom_field.Save Custom Field')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ADD CUSTOM FIELD MODAL CLOSED -->
				</div>
			</div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

    <script type="text/javascript">
        $(function () {

            var table = $('#custom_field_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/custom_fields',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'field_name', name: 'field_name'},
                    {data: 'field_type', name: 'field_type'},
                    {data: 'visibility', name: 'visibility'},
                    {data: 'required', name: 'required'},
                    {data: 'category', name: 'category'},
                    {data: 'position', name: 'position'},
                    {data: 'action', name: 'action'},
                ]
            });

            $('#custom_field_table tbody').on('click', 'td button#delete', function (){
                Swal.fire({
                    title: "Confirm",
                    text: "Are you sure you want to delete?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/custom_fields/delete', {
                            id: $(this).data('id'),
                        })
                            .then(function (response) {
                                location.reload();
                            })
                            .catch(function (error) {
                                console.log(error);
                            });

                    }
                });
            });

        });

    </script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                    type : 'text',

                    editType : '',
                    editId : '',
                    editName : '',
                    editPlace : '',
                    editUse : '',
                    editReq : '',
                    //Text//
                    editDefaultValue : '',
                    editMaxLength : '',
                    //TextArea//
                    editRows : '',
                    editColumns : '',
                    //Radio Button //
                    editRadioOptions : '',
                    //Select Option //
                    editSelectOptions : '',
                    //CheckBox//
                    editCheckBoxOptions : '',
                    //Hidden//
                    editDefaultValueHidden : '',
            },
            methods: {
                typeChange: function (event) {
                    console.log(this.type)
                    this.type = event.target.value;
                },
                edittypeChange: function (event) {
                    console.log(this.editType)
                    this.editType = event.target.value;
                },
            },
            mounted: function () {
                $(this.$refs.editmodal).on("show.bs.modal", function (event) {
                    var button = $(event.relatedTarget)
                    var self = this;
                    axios.post('/custom_fields/get_data', {
                        id: button.data('id'),
                    }).then(function (response) {
                            console.log(response);
                            console.log(response.data);
                            var name = JSON.parse(response.data.name);
                            self.editId = response.data.id;
                            self.editName = name.English;
                            self.editType = response.data.type;
                            self.editPlace = response.data.place;
                            self.editReq = response.data.req;
                            self.editUse = response.data.use;
                            var value = JSON.parse(response.data.value);
                            switch(self.editType) {
                                case 'text':
                                    self.editDefaultValue = value.default_value
                                    self.editMaxLength = value.max_length
                                    console.log('text')
                                    break;
                                case 'textarea':
                                    self.editColumns = value.cols
                                    self.editRows = value.rows
                                    console.log('textarea')
                                    break;
                                case 'radio':
                                    self.editRadioOptions = value.radio_options.toString().replaceAll(",", "&#13;&#10");
                                    console.log('radio')
                                    break;
                                case 'select':
                                    self.editSelectOptions = value.select_options.toString().replaceAll(",", "&#13;&#10");
                                    console.log('select')
                                    break;
                                case 'checkbox':
                                    self.editCheckBoxOptions = value.checkbox_options.toString().replaceAll(",", "&#13;&#10");
                                    console.log('checkbox')
                                    break;
                                case 'hidden':
                                    self.editDefaultValueHidden = value.default_value;
                                    console.log('hidden')
                                    break;
                                default:
                                // code block
                            }
                    }).catch(function (error) {
                            console.log(error);
                    });

                }.bind(this))
            }

        })
    </script>
@endsection
