@extends('layouts.partial')
@section('content')
<div class="content-body default-height ">
    <div class="container-fluid">
        <div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Tickets</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if(auth()->check() && auth()->user()->role !== 'admin')
                <div><button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal"
                    data-bs-target="#addTicket"><span class="btn-icon-start text-secondary"><i
                        class="fa fa-plus"></i>
                        </span>Open Ticket</button>
                </div>
                @endif
                <table class="table table-responsive-md">
                    <thead>
                        <tr>
                            <th style="width:50px;">
                                <div class="form-check custom-checkbox checkbox-success check-lg me-3">
                                    <input type="checkbox" class="form-check-input" id="checkAll" required="">
                                    <label class="form-check-label" for="checkAll"></label>
                                </div>
                            </th>
                            <th><strong>S/N</strong></th>
                            <th><strong>NAME</strong></th>
                            <th><strong>PHONE</strong></th>
                            <th><strong>EMAIL</strong></th>
                            <th><strong>SUBJECT</strong></th>
                            <th><strong>MESSAGE</strong></th>
                            <th><strong>STATUS</strong></th>
                            @if(auth()->check() && auth()->user()->role == 'admin')
                            <th><strong>ACTION</strong></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php $count =1; @endphp
                        @foreach($tickets as $ticket)
                        <tr>
                            <td>
                                <div class="form-check custom-checkbox checkbox-success check-lg me-3">
                                    <input type="checkbox" class="form-check-input" id="customCheckBox2"
                                        required="">
                                    <label class="form-check-label" for="customCheckBox2"></label>
                                </div>
                            </td>
                            <td><strong>{{$count ++}}</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . $ticket->user->photo) }}" class="rounded-lg me-2" width="24" alt="Profile Picture">
                                    <span class="w-space-no">{{$ticket->user->firstname}} {{$ticket->user->lastname}}</span>
                                </div>
                            </td>
                            <td>{{$ticket->phone}}</td>
                            <td>{{$ticket->email}}</td>
                            <td>{{$ticket->subject}}</td>
                            <td>{{$ticket->message}}</td>
                            <td>
                                <div class="d-flex align-items-center"><span class="badge light" style="background-color: 
                                    @if($ticket->status == 'pending') orange
                                    @elseif($ticket->status == 'closed') red
                                    @elseif($ticket->status == 'answered') green
                                    @endif;">{{$ticket->status}}</span></div>
                            </td>
                            @if(auth()->check() && auth()->user()->role == 'admin')
                            <td>
                                <div class="d-flex">
                                    <a href="#" class="btn  btn-primary shadow btn-xs sharp" data-bs-toggle="modal"
                                                data-bs-target=".view-ticket" onclick="readTicket({{ $ticket->id }})"><i class="fa fa-pencil"></i></a>
                                        <form action="{{route('ticket.delete', ['id'=>$ticket->id])}}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger shadow btn-xs sharp">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- {{$users->links()}} --}}
            <div class="modal fade" id="addTicket" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Open Ticket</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
            
                    <form action="{{route('ticket.open')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="compose-content">
                                    <div class="mb-3">
                                        <input type="text" name="subject" class="form-control bg-transparent"
                                            placeholder=" Subject:">
                                    </div>
                                    <div class="mb-3">
                                        <textarea id="email-compose-editor"
                                            class="textarea_editor form-control bg-transparent" name="message" rows="5"
                                            placeholder="Enter text ..."></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger light"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary"><span
                                            class="me-2"><i class="fa fa-paper-plane"></i></span>Send</button>
                                    </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        @if(session('success'))
                                            Swal.fire({
                                                icon: 'success',
                                                title: '<span style="color: white;">Success</span>',
                                                html: '<span style="color: white;">{{ session('success') }}</span>',
                                                toast: true,
                                                position: 'top-end',
                                                showConfirmButton: false,
                                                timer: 3000,
                                                background: '#28a745', // Green background
                                                iconColor: '#ffffff', // White icon
                                            });
                                        @endif
                                
                                        @if(session('error'))
                                            Swal.fire({
                                                icon: 'error',
                                                title: '<span style="color: white;">Error</span>',
                                                html: '<span style="color: white;">{{ session('error') }}</span>',
                                                toast: true,
                                                position: 'top-end',
                                                showConfirmButton: false,
                                                timer: 3000,
                                                background: '#dc3545', // Red background
                                                iconColor: '#ffffff', // White icon
                                            });
                                        @endif
                                    });
                                </script>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <div class="modal fade view-ticket" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Read Message</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
            
                    <form action="{{ isset($ticket) ? route('ticket.update', ['id' => $ticket->id]) : route('ticket.open') }}" method="POST" enctype="multipart/form-data" id="readTicketForm">
                        @csrf
                        <div class="modal-body">
                            <div class="compose-content">
                                <div class="mb-3">
                                    <input type="text" name="name" id="name" class="form-control bg-transparent">
                                </div>
                                <div class="mb-3">
                                    <img id="userPhoto" src="#" alt="User Picture" class="img-thumbnail" style="max-width: 150px;">
                                </div>  
                                    <div class="mb-3">
                                        <input type="text" name="subject" id="subject" class="form-control bg-transparent">
                                    </div>
                                    <div class="mb-3">
                                        <textarea id="message" class="textarea_editor form-control bg-transparent" name="message" rows="6" cols="6" style="height: 20%;"
                                            placeholder="Enter text ..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                    <select class="form-control" name="status" id="status">
                                        <option value="">Change Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="answered">Answered</option>
                                        <option value="closed">Closed</option>
                                    </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger light"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary"><span
                                            class="me-2"><i class="fa fa-paper-plane"></i></span>Send</button>
                                    </div>
                                <script>
                                    function readTicket(ticketId) {
                                        $.ajax({
                                            url: '/support/ticket/' +ticketId+ '/read',
                                            type: 'GET',
                                            success: function(data) {
                                                $('#name').val(data.ticket.user.firstname+ ' ' +data.ticket.user.lastname);
                                                if(data.ticket.user.photo) {
                                                        $('#userPhoto').attr('src', '/storage/' + data.ticket.user.photo).show();
                                                    } else {
                                                        $('#userPhoto').hide();
                                                    }
                                                $('#subject').val(data.ticket.subject);
                                                $('#message').val(data.ticket.message);
                                                $('#status').val(data.ticket.status);
                                                $('#readTicketForm').attr('action', '/support/ticket/' +ticketId+ '/update');
                                                $('.view-ticket').modal('show');
                                            },
                                            error: function(error){
                                                console.error('Error fetching user details:', error);
                                            }
                                        });
                                    }
                                </script>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        @if(session('success'))
                                            Swal.fire({
                                                icon: 'success',
                                                title: '<span style="color: white;">Success</span>',
                                                html: '<span style="color: white;">{{ session('success') }}</span>',
                                                toast: true,
                                                position: 'top-end',
                                                showConfirmButton: false,
                                                timer: 3000,
                                                background: '#28a745', // Green background
                                                iconColor: '#ffffff', // White icon
                                            });
                                        @endif
                                
                                        @if(session('error'))
                                            Swal.fire({
                                                icon: 'error',
                                                title: '<span style="color: white;">Error</span>',
                                                html: '<span style="color: white;">{{ session('error') }}</span>',
                                                toast: true,
                                                position: 'top-end',
                                                showConfirmButton: false,
                                                timer: 3000,
                                                background: '#dc3545', // Red background
                                                iconColor: '#ffffff', // White icon
                                            });
                                        @endif
                                    });
                                </script>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</div>
<script>
    function viewUserDetails(userId) {
        $.ajax({
            url: '/admin/users/' +userId+ '/details',
            type: 'GET',
            success: function(data) {
                $('#firstname').val(data.user.firstname);
                $('#lastname').val(data.user.lastname);
                $('#email').val(data.user.email);
                $('#role').val(data.user.role);
                $('#phone').val(data.user.phone);
                $('#verification_status').val(data.user.verification_status);
                $('#password').attr('placeholder', '••••••••').val(data.user.password);
                $('#updateUserForm').attr('action', '/admin/users/' +userId+ '/update');
                $('.view-user').modal('show');
            },
            error: function(error){
                console.error('Error fetching user details:', error);
            }
        });
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '<span style="color: white;">Success</span>',
                html: '<span style="color: white;">{{ session('success') }}</span>',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                background: '#28a745', // Green background
                iconColor: '#ffffff', // White icon
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: '<span style="color: white;">Error</span>',
                html: '<span style="color: white;">{{ session('error') }}</span>',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                background: '#dc3545', // Red background
                iconColor: '#ffffff', // White icon
            });
        @endif
    });
</script>
@endsection