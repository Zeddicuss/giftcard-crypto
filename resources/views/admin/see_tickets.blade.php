@extends('layouts.partial')
@section('content')
<div class="content-body default-height ">
    <div class="container-fluid">
        <div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Messages</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if(auth()->check() && auth()->user()->role !== 'admin')
                <div><button type="button" class="btn btn-outline-secondary btn-xs" data-bs-toggle="modal"
                    data-bs-target=".reply-ticket"><span class="btn-icon-start text-secondary"><i
                        class="fa fa-plus"></i>
                        </span>Open New Ticket</button>
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
                                    @elseif($ticket->status == 'rejected') red
                                    @elseif($ticket->status == 'verified') green
                                    @endif;">{{$ticket->status}}</span></div>
                            </td>
                            @if(auth()->check() && auth()->user()->role == 'admin')
                            <td>
                                <div class="d-flex">
                                    <a href="#" class="btn  btn-primary shadow btn-xs sharp" data-bs-toggle="modal"
                                                data-bs-target="#readTicket"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="btn btn-danger shadow btn-xs sharp"><i
                                            class="fa fa-trash"></i></a>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal fade reply-ticket" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Open Ticket</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="compose-content">
                                <form action="{{route('ticket.open')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
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
                                </form>
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
                </div>
            </div>
            <div class="modal fade" id="readTicket" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Open Ticket</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="compose-content">
                                <form action="{{route('ticket.open')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
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
                                </form>
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
                </div>
            </div>
        </div>
    </div>
            </div>
        </div>
    </div>
</div>
@endsection