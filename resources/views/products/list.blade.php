@extends('layout.main')
@section('page-style')
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/toastr/css/toastr.min.css')}}">
@endsection
@section('content')
    <form class="form-main-list">
        <div class="card">
            <div class="card-header d-flex justify-content-start">
                <button type="button" class="btn light btn-success" id="add-product">Add new product</button>
                <button type="submit" id="deleteAll" class="btn light btn-danger ms-3">Delete</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive-md table-list">
                        <thead>
                        <tr>
                            <th style="width:50px;">
                                <input type="checkbox" class="form-check-input" id="checkall">
                            </th>
                            <th><strong>NAME</strong></th>
                            <th><strong>DESCRIPTION</strong></th>
                            <th><strong>STATUS</strong></th>
                            <th><strong>PRICE</strong></th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="main-table">

                        {{--                    <td><span class="badge light badge-warning">Pending</span></td>
                                                <td><span class="badge light badge-success">Successful</span></td>
                                                <td><span class="badge light badge-danger">Canceled</span></td>
                        --}}
                        @foreach($products as $key => $value)
                            <tr>
                                <td>
                                    <div class="form-check custom-checkbox checkbox-success check-lg me-3">
                                        <input type="checkbox" class="form-check-input" id="{{$value->id}}" name="{{$value->id}}" >
                                        <label class="form-check-label" for="{{$value->id}}"></label>
                                    </div>
                                </td>
                                <td>{{$value->name}}</td>
                                <td>{{$value->description}}</td>
                                <td>
                                    @php
                                        if($value->status == 0){
                                            echo '<span class="badge light badge-danger">Canceled</span>';
                                        }else if($value->status == 1){
                                            echo '<span class="badge light badge-warning">Pending</span>';
                                        }else{
                                            echo '<span class="badge light badge-success">Successful</span>';
                                        }
                                    @endphp
                                </td>
                                <td>${{number_format($value->price)}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-success light sharp"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                    <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                    <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                                </g>
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu" style="">
                                            <button type="button" class="dropdown-item btn-update" id="{{$value->id}}">Edit</button>
                                            <button type="button" class="dropdown-item btn-delete" id="{{$value->id}}">Delete</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
    @include('products.add')
@endsection

@section('page-script')
    <script src="{{asset('assets/vendor/toastr/js/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins-init/toastr-init.js')}}"></script>

    <script src="{{asset('assets/js/custom/ajax.js')}}"></script>
    <script src="{{asset('assets/js/custom/alert.js')}}"></script>
    <script src="{{asset('assets/js/custom/toastr-custom.js')}}"></script>
@endsection
