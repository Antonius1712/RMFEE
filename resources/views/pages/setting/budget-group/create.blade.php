@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger text-center">
                    *{!! $error !!}
                </div>
            @endforeach

            @if( session()->has('noticication') )
            <div class="alert alert-success text-center">
                {!! session()->get('noticication') !!}
            </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <h1 class="">
                        Budget Group Setting
                    </h1>
                    <span class="text-sm">Please input data correctly.</span>
                    
                    <form action="{{ Route('setting.budget-group.store') }}" method="post" class="mt-4">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="group_id">Group ID</label>
                            <input type="text" name="group_id" id="group_id" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="broker">Broker</label>
                            <input type="text" name="broker" id="broker" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="class">Class</label>
                            <select name="class" id="class" class="form-control">
                                <option value="01">01</option>
                                <option value="02">02</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="occupation">Occupation</label>
                            <input type="text" name="occupation" id="occupation" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="percentage">Percentage</label>
                            <input type="text" name="percentage" id="percentage" class="form-control"/>
                        </div>
                        <button type="submit" class="btn btn-primary full-width">Save</button>
                        <input type="hidden" name="broker" id="broker">
                        <input type="hidden" name="occupation_code" id="occupation_code">
                        <input type="hidden" name="occupation_name" id="occupation_name">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#broker').autocomplete({
            source: function(req, res){
                $.ajax({
                    url: serach_profile_on_setting_budget_url,
                    data: {
                        keywords: req.term
                    },
                    success: function( data ) {
                        res($.map(data, function (item) {
                            return {
                                label: `${item.ID} - ${item.Name}`,
                                value: `${item.ID} - ${item.Name}`
                            };
                        }));
                    },
                });
            },
            minLength: 3,
            select: function( event, ui ) {
                let broker_id = ui.item.label.split(' - ')[0];
                $('#broker_id').val(broker_id);

                let broker_name = ui.item.label.split(' - ')[1];
                $('#broker_name').val(broker_name);
            },
        });

        $('#occupation').autocomplete({
            source: function(req, res){
                $.ajax({
                    url: serach_occupation_url,
                    data: {
                        keywords: req.term
                    },
                    success: function( data ) {
                        res($.map(data, function (item) {
                            return {
                                label: item.Occupation,
                                value: item.Occupation
                            };
                        }));
                    },
                });
            },
            minLength: 3,
            select: function( event, ui ) {
                let occupation_code = ui.item.label.split(' - ')[0];
                $('#occupation_code').val(occupation_code);

                let occupation_name = ui.item.label.split(' - ')[1];
                $('#occupation_name').val(occupation_name);
            },
        });
    </script>
@endsection