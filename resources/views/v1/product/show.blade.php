@extends('layouts.theme.master')
@section('title')
    Product Saya
@endsection

@section('button')
    <div class="d-flex">
        <a href="#" class="btn btn-success btn-nav"><i class="ti ti-arrow-right me-1"></i>Back To List</a>
    </div>
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="sticky-md-top product-sticky">
                                <div id="carouselExampleCaptions" class="carousel slide ecomm-prod-slider"
                                    data-bs-ride="carousel">
                                    <div class="carousel-inner bg-light rounded position-relative">
                                        <div class="card-body position-absolute end-0 top-0">
                                            <div class="form-check prod-likes"><input type="checkbox"
                                                    class="form-check-input"> <svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="feather feather-heart prod-likes-icon">
                                                    <path
                                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                                    </path>
                                                </svg></div>
                                        </div>
                                        <div class="card-body position-absolute bottom-0 end-0">
                                            <ul class="list-inline ms-auto mb-0 prod-likes">
                                                <li class="list-inline-item m-0"><a href="#"
                                                        class="avtar avtar-xs text-white text-hover-primary"><i
                                                            class="ti ti-zoom-in f-18"></i></a></li>
                                                <li class="list-inline-item m-0"><a href="#"
                                                        class="avtar avtar-xs text-white text-hover-primary"><i
                                                            class="ti ti-zoom-out f-18"></i></a></li>
                                                <li class="list-inline-item m-0"><a href="#"
                                                        class="avtar avtar-xs text-white text-hover-primary"><i
                                                            class="ti ti-rotate-clockwise f-18"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="carousel-item"><img
                                                src="https://ableproadmin.com/assets/images/application/img-prod-3.jpg"
                                                class="d-block w-100" alt="Product images"></div>
                                        <div class="carousel-item active carousel-item-start"><img
                                                src="https://ableproadmin.com/assets/images/application/img-prod-3.jpg"
                                                class="d-block w-100" alt="Product images"></div>
                                        <div class="carousel-item carousel-item-next carousel-item-start"><img
                                                src="https://ableproadmin.com/assets/images/application/img-prod-3.jpg"
                                                class="d-block w-100" alt="Product images"></div>
                                        <div class="carousel-item"><img
                                                src="https://ableproadmin.com/assets/images/application/img-prod-3.jpg"
                                                class="d-block w-100" alt="Product images"></div>
                                    </div>
                                    <ol
                                        class="carousel-indicators position-relative product-carousel-indicators my-sm-3 mx-0">
                                        <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                                            class="w-25 h-auto"><img
                                                src="https://ableproadmin.com/assets/images/application/img-prod-3.jpg"
                                                class="d-block wid-50 rounded" alt="Product images"></li>
                                        <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                                            class="w-25 h-auto active" aria-current="true"><img
                                                src="https://ableproadmin.com/assets/images/application/img-prod-3.jpg"
                                                class="d-block wid-50 rounded" alt="Product images"></li>
                                        <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                                            class="w-25 h-auto"><img
                                                src="https://ableproadmin.com/assets/images/application/img-prod-3.jpg"
                                                class="d-block wid-50 rounded" alt="Product images"></li>
                                        <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3"
                                            class="w-25 h-auto"><img
                                                src="https://ableproadmin.com/assets/images/application/img-prod-3.jpg"
                                                class="d-block wid-50 rounded" alt="Product images"></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6"><span class="badge bg-success f-14">In stock</span>
                            <h5 class="my-3">Apple Watch SE Smartwatch (GPS, 40mm) (Heart Rate Monitoring)</h5>
                            <div class="star f-18 mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star-half-alt text-warning"></i>
                                <span class="text-sm text-muted">(4.5)</span>
                            </div>
                            <h5 class="mt-4 mb-3 f-w-500">About this item</h5>
                            <ul>
                                <li class="mb-2">Care Instructions: Hand Wash Only</li>
                                <li class="mb-2">Fit Type: Regular</li>
                                <li class="mb-2">Dark Blue Regular Women Jeans</li>
                                <li class="mb-2">Fabric : 100% Cotton</li>
                            </ul>


                            <h5 class="mt-4 mb-3 f-w-500">Harga Product</h5>
                            <h3 class="mb-4"><b>$299.00</b></h3>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-grid"><button type="button" class="btn btn-primary">Buy Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header pb-0">
                    <ul class="nav nav-tabs profile-tabs mb-0" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" id="ecomtab-tab-1"
                                data-bs-toggle="tab" href="#ecomtab-1" role="tab" aria-controls="ecomtab-1"
                                aria-selected="true">Features</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="ecomtab-tab-2"
                                data-bs-toggle="tab" href="#ecomtab-2" role="tab" aria-controls="ecomtab-2"
                                aria-selected="false" tabindex="-1">Specifications</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="ecomtab-tab-3"
                                data-bs-toggle="tab" href="#ecomtab-3" role="tab" aria-controls="ecomtab-3"
                                aria-selected="false" tabindex="-1">Overview</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="ecomtab-tab-4"
                                data-bs-toggle="tab" href="#ecomtab-4" role="tab" aria-controls="ecomtab-4"
                                aria-selected="false" tabindex="-1">Reviews<span
                                    class="badge bg-light-primary rounded-pill px-2 ms-2">275</span></a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="ecomtab-1" role="tabpanel"
                            aria-labelledby="ecomtab-tab-1">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted py-1">Band :</td>
                                            <td class="py-1">Smart Band</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted py-1">Compatible Devices :</td>
                                            <td class="py-1">Smartphones</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted py-1">Ideal For :</td>
                                            <td class="py-1">Unisex</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted py-1">Lifestyle :</td>
                                            <td class="py-1">Fitness | Indoor | Sports | Swimming | Outdoor</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted py-1">Basic Features :</td>
                                            <td class="py-1">Calendar | Date &amp; Time | Timer/Stop Watch</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted py-1">Health Tracker :</td>
                                            <td class="py-1">Heart Rate | Exercise Tracker</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="ecomtab-2" role="tabpanel" aria-labelledby="ecomtab-tab-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Product Category</h5>
                                    <hr class="my-3">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td class="text-muted py-1">Wearable Device Type:</td>
                                                    <td class="py-1">Smart Band</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted py-1">Compatible Devices :</td>
                                                    <td class="py-1">Smartphones</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted py-1">Ideal For :</td>
                                                    <td class="py-1">Unisex</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5>Manufacturer Details</h5>
                                    <hr class="my-3">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td class="text-muted py-1">Brand :</td>
                                                    <td class="py-1">Apple</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted py-1">Model Series :</td>
                                                    <td class="py-1">Watch SE</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted py-1">Model Number :</td>
                                                    <td class="py-1">MYDT2HN/A</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="ecomtab-3" role="tabpanel" aria-labelledby="ecomtab-tab-3">
                            <div class="table-responsive">
                                <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                    <strong class="text-body">“When an unknown printer took a galley of type and scrambled
                                        it to make a type specimen book.”</strong> It has survived not only five centuries,
                                    but also the leap into electronic typesetting, remaining essentially unchanged. It was
                                    popularized in the 1960s with the release of Lestrade sheets containing Lorem Ipsum
                                    passages, and more recently with desktop publishing software like PageMaker including
                                    versions of Lorem Ipsum.
                                </p>
                                <p class="text-muted">It was popularized in the 1960s with the release of Learjet sheets
                                    containing Lorem Ipsum passages, and more recently with desktop publishing software like
                                    PageMaker including versions of Lorem Ipsum.</p>
                            </div>
                        </div>
                        <div class="tab-pane" id="ecomtab-4" role="tabpanel" aria-labelledby="ecomtab-tab-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-xxl-4 col-xl-5">
                                            <h2 class="mb-3"><b>3.5<small class="text-muted f-18">/5</small></b></h2>
                                            <p class="mb-2 text-muted">Based on 275 reviews</p>
                                            <div class="star mb-3 f-20"><i class="fas fa-star text-warning"></i> <i
                                                    class="fas fa-star text-warning"></i> <i
                                                    class="fas fa-star text-warning"></i> <i
                                                    class="fas fa-star-half-alt text-warning"></i> <i
                                                    class="far fa-star text-muted"></i></div>
                                        </div>
                                        <div class="col-xxl-4 col-xl-5">
                                            <div class="d-flex align-items-center">
                                                <div class="w-100">
                                                    <div class="row align-items-center my-2">
                                                        <div class="col">
                                                            <div class="progress" style="height: 4px">
                                                                <div class="progress-bar bg-warning" style="width: 30%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <p class="mb-0 text-muted">5 Stars</p>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center my-2">
                                                        <div class="col">
                                                            <div class="progress" style="height: 4px">
                                                                <div class="progress-bar bg-warning" style="width: 60%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <p class="mb-0 text-muted">4 Stars</p>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center my-2">
                                                        <div class="col">
                                                            <div class="progress" style="height: 4px">
                                                                <div class="progress-bar bg-warning" style="width: 75%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <p class="mb-0 text-muted">3 Stars</p>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center my-2">
                                                        <div class="col">
                                                            <div class="progress" style="height: 4px">
                                                                <div class="progress-bar bg-warning" style="width: 40%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <p class="mb-0 text-muted">2 Stars</p>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <div class="progress" style="height: 4px">
                                                                <div class="progress-bar bg-warning" style="width: 55%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <p class="mb-0 text-muted">1 Stars</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="chat-avtar"><img class="img-radius img-fluid wid-40"
                                                src="../assets/images/user/avatar-1.jpg" alt="User image">
                                            <div class="bg-success chat-badge"></div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">Harriet Wilson</h6>
                                            <p class="text-muted text-sm mb-1">2 hour ago</p>
                                            <div class="star"><i class="fas fa-star text-warning"></i> <i
                                                    class="fas fa-star text-warning"></i> <i
                                                    class="fas fa-star text-warning"></i> <i
                                                    class="fas fa-star-half-alt text-warning"></i> <i
                                                    class="far fa-star text-muted"></i></div>
                                            <p class="mb-0 text-muted mt-1">Lorem Ipsum is simply dummy text of the
                                                printing and typesetting industry. Lorem Ipsum has been the industry's
                                                standard dummy text ever since the 1500.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="chat-avtar"><img class="img-radius img-fluid wid-40"
                                                src="../assets/images/user/avatar-2.jpg" alt="User image">
                                            <div class="bg-success chat-badge"></div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">Lou Olson</h6>
                                            <p class="text-muted text-sm mb-1">2 hour ago</p>
                                            <div class="star"><i class="fas fa-star text-warning"></i> <i
                                                    class="fas fa-star text-warning"></i> <i
                                                    class="fas fa-star-half-alt text-warning"></i> <i
                                                    class="far fa-star text-muted"></i> <i
                                                    class="far fa-star text-muted"></i></div>
                                            <p class="mb-2 text-muted mt-1">Lorem Ipsum is simply dummy text of the
                                                printing and typesetting industry. Lorem Ipsum has been the industry's
                                                standard dummy text ever since the 1500.</p><a href="#"
                                                class="link-primary mb-1">https://phoenixcoded.net/</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3"><button class="btn btn-link-primary">View more comments</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection
