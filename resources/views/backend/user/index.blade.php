@extends('layouts.backend')
@section('title',isset($heading) ? $heading : 'Danh sách')
@section('head-append')
    @parent
    {{ HTML::style("assets/backend/css/plugins/dataTables/datatables.min.css") }}
@endsection
@section('body-append')
    @parent
    {{ HTML::script("assets/backend/js/plugins/dataTables/datatables.min.js") }}
    <script>
        var flash_message = '{!!session("flash_message")!!}';
        $(function(){
            renderTable('{!! isset($role->id) ? route('admin.user.data.role', $role->id) : route('admin.user.data') !!}',
                [
                    { data: 'id', name: 'id', searchable: false },
                    { data: 'name', name: 'name'},
                    { data: 'username', name: 'username'},
                    { data: 'email', orderable: true, name: 'email'},
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, sClass: "text-center"}
                ],{
                createdRow: function ( row, data, index ) {
                    $('td', row).eq(0).css('display','none');
                    if (data.actions.show) {
                        $('td', row).eq(1).html('<a title="'+data.actions.show.label+'" href="'+data.actions.show.uri+'">'+data.name+'</a>');
                    }
                    var actions = data.actions;
                    if (!actions || actions.length < 1) { return; }
                    var $actions = $('td', row).eq(4);
                    $actions.html('');
                    if (actions.edit) { $actions.append('<a title ="'+actions.edit.label+'" class="btn btn-default btn-xs" href="'+actions.edit.uri+'"><i class="fa fa-pencil"></i></a> ');}
                    if (actions.delete) {
                        var $btn = $('<a title="'+actions.delete.label+'" class="btn btn-danger btn-xs" href="'+actions.delete.uri+'"><i class="fa fa-times"></i></a> ').appendTo($actions);
                        $btn.on('click',function(event) {
                            event.preventDefault();
                            $this = $(this);
                            swal({
                                title: "Bạn chắc chắn chứ?",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Chắc chắn!",
                                cancelButtonText: "Hủy",
                                closeOnConfirm: false
                            }, function() {
                                swal("Xóa!", "Bạn đã xóa dữ liệu.", "success");
                                $.post($this.attr('href'), {_method: 'DELETE'}, function (data) {
                                    console.log(data);
                                    window.location.reload();
                                });
                            });
                        });
                    }
                }
            });
        });
    </script>
@endsection

@section('page-content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="btn-group">
                        <span class="btn btn-default">{!!$role->name or 'Tất cả' !!}</span>
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                            <i class="caret"></i>
                        </button>
                        <ul class="dropdown-menu pull-left">
                            <li><a href="{!!route('admin.user.index')!!}">Tất cả</a></li>
                            @foreach ($roles as $id => $name)
                            <li><a href="{{route('admin.user.role', $id)}}">{{$name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @can('user-write')
                    <div class="ibox-tools">
                        <a href="{{ route('admin.user.create') }}" class="btn btn-success btn-xs create-link"> <i class="fa fa-plus"></i> {{trans('repositories.create')}}</a>
                    </div>
                    @endcan
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover prome-datatables" width="100%">
                            <thead>
                                <tr>
                                    <th style="display:none">ID</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
