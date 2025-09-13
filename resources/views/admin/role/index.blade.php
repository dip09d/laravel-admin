@extends('admin.layouts.app')
@section('content')
<div class="app-main__inner">

    <!-- Page Header -->
    <div class="app-page-title">
        <div class="page-title-wrapper d-flex justify-content-between align-items-center">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-medal icon-gradient bg-tempting-azure"></i>
                </div>
                <div>
                    {{$title}}
                    <div class="page-title-subheading">{{$title}} > {{$pagename}}</div>
                </div>
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}">{{$title}}</a> → {{$pagename}}
            </div>
        </div>
    </div>

    <!-- Card -->
    <div class="main-card mb-3 card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <!-- Left: Search + Per Page -->
            <div class="d-flex align-items-center">
                <!-- Per-page selector -->
                <form method="GET" action="{{ route('admin.role.view') }}" class="mr-3 d-flex align-items-center">
                    <label for="perPage" class="mr-1 mb-0">Show:</label>
                    <select name="perPage" id="perPage" class="form-control form-control-sm" onchange="this.form.submit()">
                        @foreach([10,25,50,100] as $size)
                        <option value="{{ $size }}" {{ request('perPage', 25) == $size ? 'selected' : '' }}>
                            {{ $size }}
                        </option>
                        @endforeach
                    </select>
                </form>

                <!-- Search form -->
                <form method="GET" action="{{ route('admin.role.view') }}" class="d-flex">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control form-control-sm" placeholder="Search...">
                    <button class="btn btn-info btn-sm ml-1" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Right: Add Role Button -->
            <button class="btn btn-info btn-sm" id="addRoleBtn">
                <i class="fa fa-plus"></i> {{$add_button}}
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Guard</th>
                            <th>Created At</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $index => $role)
                        <tr>
                            <td>{{ $roles->firstItem() + $index }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->guard_name }}</td>
                            <td>{{ $role->created_at->format('Y-m-d') }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No roles found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>



            <!-- Pagination links -->
            <div>
                {{ $roles->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
            </div>


        </div>
    </div>


</div>
@endsection
@push('scripts')

@endpush