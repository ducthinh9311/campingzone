@extends('admin.layouts.master')

@section('admin_head')
    <title>{{ hwa_page_title("Hài lòng") }}</title>
    <meta content="{{ hwa_page_title("Hài lòng") }}" name="description"/>
@endsection

@section('admin_style')
    @include('admin.includes.database.style')
@endsection

@section('admin_content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"><span><i
                                            class="bx bxs-home-circle"></i> Bảng điều khiển</span></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hài lòng</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <div class="page-title-right">
                                <h4 class="card-title">Sản phẩm</h4>
                            </div>
                          
                        </div>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th class="text-center align-middle">Hình ảnh</th>
                                <th class="text-center align-middle">Tên</th>
                                <th class="text-center align-middle">Độ hài lòng</th>
                                
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($results as $result)
                                <tr>
                                    <td class="align-middle text-center">
                                        <img
                                            src="{{ !empty($result['thumb']) ? hwa_image_url('products/thumbs', $result['thumb']) : '' }}"
                                            alt="" class="img-thumbnail" width="100">
                                    </td>
                                    <td class="align-middle">
                                        <p class="text-uppercase fw-bold">
                                            <a href="{{ route('client.product.show', $result['slug']) }}"
                                               target="_blank">{{ $result['name'] ?? "" }}</a>
                                        </p>
                                        <p><span class="text-uppercase fw-bold">- SKU:</span> {{ $result['sku'] ?? "" }}
                                        </p>
                                        <p><span
                                                class="fw-bold">- Danh mục:</span> {{ $result['category']['name'] ?? "" }}
                                        </p>
                                        <p><span class="fw-bold">- Nguồn:</span> {{ $result['supplier']['name'] ?? "" }}
                                        </p>
                                        <p class="chat-time text-muted mb-2 mt-2 text-end me-2"><i
                                                class="bx bx-time-five align-middle me-1"></i>
                                            {{ ((Carbon\Carbon::parse($result['created_at'])->diffInDays(Carbon\Carbon::now())) < 3) ? Carbon\Carbon::parse($result['created_at'])->locale('vi')->diffForHumans() : Carbon\Carbon::parse($result['created_at'])->format('H:i:s d-m-Y') }}
                                        </p>
                                    </td>
                                    <td class="align-middle">
                                        <p>Đánh giá: {{$result->totalRating ?? 0}} <span class="mdi mdi-star text-primary"></span></p>
                                        <p>({{$result->totalReview ?? 0}} người)</p>
                                    </td>
                                   
                               
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
    </div>
@endsection

@section('admin_script')
    @include('admin.includes.database.script')
@endsection
