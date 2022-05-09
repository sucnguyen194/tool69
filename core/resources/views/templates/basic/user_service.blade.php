@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="all-sections pt-60">
    <div class="container-fluid p-max-sm-0">
        <div class="sections-wrapper d-flex flex-wrap justify-content-center">
            <article class="main-section">
                <div class="section-inner">
                    <div class="item-section item-overview-section">
                        <div class="container">
                            <div class="row justify-content-center mb-30-none">
                                <div class="col-xl-3 col-lg-3 mb-30">
                                    <div class="sidebar">
                                        <div class="widget mb-30">
                                            <div class="profile-widget">
                                                <div class="profile-widget-header">
                                                    <div class="profile-widget-thumb">
                                                        <img src="{{ userDefaultImage(imagePath()['profile']['user_bg']['path'].'/'. $user->bg_image,'background_image') }}" alt="item-banner">
                                                        @if($user->isOnline())
                                                            <span class="badge-offline bg--success">@lang('Online')</span>
                                                        @else
                                                            <span class="badge-offline bg--warning">@lang('Offline')</span>
                                                        @endif
                                                        @if(auth()->check())
                                                            @if(auth()->user()->following->find($user->id))
                                                                <a href="{{route('user.follow', $user->id)}}">
                                                                    <span class="badge-follow bg--success">
                                                                        @lang('Following')
                                                                    </span>
                                                                </a>
                                                            @else
                                                                <a href="{{route('user.follow', $user->id)}}">
                                                                    <span class="badge-follow bg--info">
                                                                        @lang('Follow')
                                                                    </span>
                                                                </a>
                                                            @endif
                                                        @else
                                                            <a href="{{route('user.follow', $user->id)}}">
                                                                <span class="badge-follow bg--info">
                                                                    @lang('Follow')
                                                                </span>
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div class="profile-widget-author">
                                                        <div class="thumb">
                                                            <img src="{{ userDefaultImage(imagePath()['profile']['user']['path'].'/'. $user->image, 'profile_image') }}" alt="{{__($user->username)}}">
                                                        </div>
                                                        <div class="content">
                                                            <h4 class="name">
                                                                <a href="{{route('profile', $user->username)}}">{{__($user->username)}}</a>
                                                            </h4>
                                                            <span class="designation">{{@$user->designation}}</span>
                                                            <div class="ratings">
                                                                <span><i class="las la-star text--warning"></i> {{getAmount($reviewAvg, 2)}} ({{$reviewCount}} @lang('reviews'))</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="profile-list-area">
                                                    <ul class="details-list">
                                                        <li><span>@lang('Total Service')</span> <span>{{$user->services->count()}}</span></li>
                                                        <li><span>@lang('Work Complete')</span> <span>{{$workCompleteCount}}</span></li>
                                                        <li><span>@lang('Total Software')</span> <span>{{$user->softwares->count()}}</span></li>
                                                        <li><span>@lang('Work Pending')</span> <span>{{$workPendingCount}}</span></li>
                                                        <li><span>@lang('Total Job')</span> <span>{{$user->jobs->count()}}</span></li>
                                                        <li><span>@lang('Country')</span> <span>{{@$user->address->country}}</span></li>
                                                        <li><span>@lang('Member since')</span> <span>{{showDateTime($user->created_at, 'd M Y')}}</span></li>
                                                        <li><span>@lang('Verified User')</span> 
                                                            @if($user->status == 1)
                                                                <span class="text--success">@lang('Yes')</span>
                                                            @else
                                                                <span class="text--success">@lang('No')</span>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-9 mb-30">
                                    <div class="item-details-area">
                                        <div class="product-tab">
                                                <div class="tab-pane fade show active" id="service" role="tabpanel" aria-labelledby="service-tab">
                                                    <div class="item-card-wrapper border-0 p-0 grid-view">
                                                    @foreach($userServices as $service)
                                                        <div class="item-card">
                                                            <div class="item-card-thumb">
                                                                <img src="{{getImage('assets/images/service/'.$service->image, imagePath()['service']['size']) }}" alt="@lang('Service Image')">
                                                                @if($service->featured == 1)
                                                                    <div class="item-level">@lang('Featured')</div>
                                                                @endif
                                                            </div>
                                                            <div class="item-card-content">
                                                                <div class="item-card-content-top">
                                                                    <div class="left">
                                                                        <div class="author-thumb">
                                                                            <img src="{{ userDefaultImage(imagePath()['profile']['user']['path'].'/'. $service->user->image,'profile_image') }}" alt="{{__($service->user->username)}}">
                                                                        </div>
                                                                        <div class="author-content">
                                                                            <h5 class="name"><a href="{{route('profile', $service->user->username)}}">{{__($service->user->username)}}</a> <span class="level-text"> {{__(@$service->user->rank->level)}}</span></h5>
                                                                            <div class="ratings">
                                                                                <i class="fas fa-star"></i>
                                                                                <span class="rating me-2">{{__(getAmount($service->rating, 2))}}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="right">
                                                                        <div class="item-amount">{{__($general->cur_sym)}}{{__(showAmount($service->price))}}</div>
                                                                    </div>
                                                                </div>
                                                                <h3 class="item-card-title"><a href="{{route('service.details', [slug($service->title), encrypt($service->id)])}}">{{__($service->title)}}</a></h3>
                                                            </div>
                                                            <div class="item-card-footer">
                                                                <div class="left">

                                                                    <a href="javascript:void(0)" class="item-love me-2 loveHeartAction"  data-serviceid="{{$service->id}}"><i class="fas fa-heart"></i> <span class="give-love-amount">({{__($service->favorite)}})</span></a>
                                                                    
                                                                    <a href="javascript:void(0)" class="item-like"><i class="las la-thumbs-up"></i> ({{$service->likes}})</a>
                                                                </div>
                                                                <div class="right">
                                                                    <div class="order-btn">
                                                                        <a href="{{route('user.service.booking', [slug($service->title), encrypt($service->id)])}}" class="btn--base"><i class="las la-shopping-cart"></i> @lang('Order Now')</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                {{$userServices->links()}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>
@include($activeTemplate.'partials.end_ad')
@endsection

