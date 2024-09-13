@extends('layouts.partial')
@section('content')
<div class="content-body default-height ">
    <div class="container-fluid">
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-0 h-auto">
            <div class="card-body">
                <div class="row gx-0">
                    <!-- column -->
                    
                    <!-- /column -->
                    <div class="col-lg-8 col-xl-9">
                        <div class="email-right-box ms-0 ">
                            {{-- <div class="toolbar mb-4 px-3 mt-3" role="toolbar">
                                <div class="btn-group mb-1">
                                    <button type="button" class="btn btn-primary light px-3"><i
                                            class="fa fa-archive"></i></button>
                                    <button type="button" class="btn btn-primary light px-3"><i
                                            class="fa fa-exclamation-circle"></i></button>
                                    <button type="button" class="btn btn-primary light px-3"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                                <div class="btn-group mb-1">
                                    <button type="button" class="btn btn-primary light dropdown-toggle px-3"
                                        data-bs-toggle="dropdown">
                                        <i class="fa fa-folder"></i> <b class="caret m-l-5"></b>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript: void(0);">Social</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Promotions</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Updates</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Forums</a>
                                    </div>
                                </div>
                                <div class="btn-group mb-1">
                                    <button type="button" class="btn btn-primary light dropdown-toggle px-3"
                                        data-bs-toggle="dropdown">
                                        <i class="fa fa-tag"></i> <b class="caret m-l-5"></b>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript: void(0);">Updates</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Social</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Promotions</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Forums</a>
                                    </div>
                                </div>
                                <div class="btn-group mb-1">
                                    <button type="button" class="btn btn-primary light dropdown-toggle v"
                                        data-bs-toggle="dropdown">More <span class="caret m-l-5"></span>
                                    </button>
                                    <div class="dropdown-menu"> <a class="dropdown-item"
                                            href="javascript: void(0);">Mark as Unread</a> <a class="dropdown-item"
                                            href="javascript: void(0);">Add to Tasks</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Add Star</a> <a
                                            class="dropdown-item" href="javascript: void(0);">Mute</a>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="compose-wrapper " id="compose-content">
                                <div class="compose-content">
                                    <form action="#">
                                        <div class="mb-3">
                                            <input type="text" class="form-control bg-transparent"
                                                placeholder="Your Full Name">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control bg-transparent"
                                                placeholder="Your Email">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control bg-transparent"
                                                placeholder=" Subject:">
                                        </div>
                                        <div class="mb-3">
                                            <textarea id="email-compose-editor"
                                                class="textarea_editor form-control bg-transparent" rows="5"
                                                placeholder="Enter text ..."></textarea>
                                        </div>
                                    </form>
                                    <h5 class="my-3"><i class="fa fa-paperclip me-2"></i> Attatchment</h5>
                                    <form action="#" class="dropzone">
                                        <div class="fallback">
                                            <input name="file" type="file" multiple>
                                        </div>
                                    </form>
                                </div>
                                <div class="text-start mt-4 mb-3">
                                    <button class="btn btn-primary btn-sl-sm me-2" type="submit"><span
                                            class="me-2"><i class="fa fa-paper-plane"></i></span>Send</button>
                                    <button class="btn btn-danger light btn-sl-sm" type="reset"><span
                                            class="me-2"><i class="fa fa-times"></i></span>Discard</button>
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
</div>   
@endsection 