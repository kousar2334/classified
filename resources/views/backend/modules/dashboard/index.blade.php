@extends('backend.layouts.dashboard_layout')
@section('page-content')
    <!--Page Header-->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ translation('Dashboard') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">{{ translation('Dashboard') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--End page header-->

    <section class="content">
        <div class="container-fluid">
            <!-- Stats Boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-ad"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ translation('Total Ads') }}</span>
                            <span class="info-box-number">{{ $total_ads }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ translation('Total Members') }}</span>
                            <span class="info-box-number">{{ $total_members }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-blog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ translation('Total Blogs') }}</span>
                            <span class="info-box-number">{{ $total_blogs }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-file-alt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ translation('Total Pages') }}</span>
                            <span class="info-box-number">{{ $total_page }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main row -->
            <div class="row">
                <!-- Latest Ads -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translation('Latest Ads') }}</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ translation('Title') }}</th>
                                        <th>{{ translation('Category') }}</th>
                                        <th>{{ translation('User') }}</th>
                                        <th>{{ translation('City') }}</th>
                                        <th>{{ translation('Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latest_ads as $ad)
                                        <tr>
                                            <td>{{ $ad->title ?? 'N/A' }}</td>
                                            <td>{{ $ad->categoryInfo->title ?? 'N/A' }}</td>
                                            <td>{{ $ad->userInfo->name ?? 'N/A' }}</td>
                                            <td>{{ $ad->cityInfo->name ?? 'N/A' }}</td>
                                            <td>{{ $ad->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">{{ translation('No ads found') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Latest Members -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translation('Latest Members') }}</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ translation('Name') }}</th>
                                        <th>{{ translation('Email') }}</th>
                                        <th>{{ translation('Phone') }}</th>
                                        <th>{{ translation('Joined Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latest_members as $member)
                                        <tr>
                                            <td>{{ $member->name }}</td>
                                            <td>{{ $member->email }}</td>
                                            <td>{{ $member->phone ?? 'N/A' }}</td>
                                            <td>{{ $member->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">{{ translation('No members found') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-script')
@endsection
