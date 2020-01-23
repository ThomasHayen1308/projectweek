@extends('layouts.template')

@section('title', 'Users')

@section('main')
    <h1>Docenten</h1>
    @include('shared.alert')
    <form method="get" action="/admin/users" id="searchForm">
        <div class="row">
            <div class="col-sm-8 mb-2">
                <input type="text" class="form-control" name="name" id="name"
                       value="{{ request()->user }}"
                       placeholder="Filter Name Or Email">
            </div>
            <div class="col-sm-4 mb-2">
                <select class="form-control" name="sort" id="sort">
                    <option value="0">Name (A=>Z)</option>
                    <option value="1">Name (Z=>A)</option>
                    <option value="2">Email (A=>Z)</option>
                    <option value="3">Email (Z=>A)</option>
                    <option value="4">Not Active</option>
                    <option value="5">Admin</option>
                </select>
            </div>
        </div>
    </form>
    <hr>
    @if ($users->count() == 0)
        <div class="alert alert-danger alert-dismissible fade show">
            Can't find any user with <b>'{{ request()->name }}'</b> for this search
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Active</th>
                <th>Admin</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{$user->email}}</td>
                    <td id="icon">{{$user->active}}</td>
                    <td id="icon">{{$user->admin}}</td>
                    <td>
                        <form action="/admin/users/{{ $user->id }}" method="post" class="deleteForm">
                            @method('delete')
                            @csrf
                            <div class="btn-group btn-group-sm">
                                <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-outline-success"
                                   data-toggle="tooltip"
                                   title="Edit {{ $user->name }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger"
                                        data-toggle="tooltip"
                                        @if($user->admin == 1) disabled @endif
                                        data-username="{{$user->name}}"
                                        data-id="{{$user->id}}"
                                        title="Delete {{ $user->name }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{--Page Selector van Paginate--}}
    {{ $users->links() }}
@endsection
@section("script_after")
    <script>

        /*Enable bootstrap Tooltips*/
        $(function () {
            $('body').tooltip({
                selector: '[data-toggle="tooltip"]',
                html: true,
            });
        });
        /*End Enable bootstrap Tooltips*/

        /*Change to Checkmarks*/
        $(function () {
            const listItems = document.querySelectorAll('#icon')
            var i;
            for (i = 0; i < listItems.length; i++) {
                if (listItems[i].textContent == 1) {
                    listItems[i].outerHTML = "<td><i class=\"fas fa-check\"></i></td>";
                } else {
                    listItems[i].textContent = " ";
                }
            }
        });
        /*End Change to Checkmarks*/

        /*Delete a User*/
        $(function () {
            $('.deleteForm button').click(function () {
                let username = $(this).data('username');
                let id = $(this).data('id');
                let text = `<p>Delete <b>${username}</b>?</p>`;
                let form = $(this).closest('form');

                // show Noty
                let modal = new Noty({
                    timeout: false,
                    layout: 'center',
                    modal: true,
                    type: 'warning',
                    text: text,
                    buttons: [
                        Noty.button('Delete user', ' btn btn-success', function () {
                            //Delete user and close modal
                            deleteUser(id);
                            modal.close();

                        }),
                        Noty.button('Cancel', 'btn btn-secondary ml-2', function () {
                            modal.close();
                        })
                    ]
                }).show();
            });

            function deleteUser(id) {
                // Delete the user from the database
                let pars = {
                    '_token': '{{ csrf_token() }}',
                    '_method': 'delete'
                };
                $.post(`/admin/users/${id}`, pars, 'json')
                    .done(function (data) {
                        console.log('data', data);
                        // Show toast
                        new Noty({
                            type: data.type,
                            text: data.text
                        }).show();
                    })
                    .fail(function (e) {
                        console.log('error', e);
                        console.log('error', e.responseJSON.errors);
                    });
            }
        });

        /*End Delete User*/
    </script>
@endsection
