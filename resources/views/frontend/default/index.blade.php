@extends('frontend.default.layouts.app')

@section('content')
    @if ( get_setting('slider_section_show') == 'on')
        <section class="position-relative slider py-10 overflow-hidden">
        	<div class="absolute-full">
    			<div class="aiz-carousel aiz-carousel-full h-100" data-fade='true' data-infinite='true' data-autoplay='true'>
    				@if (get_setting('sliders') != null)
                        @foreach (explode(',', get_setting('sliders')) as $key => $value)
                            <img class="img-fit" src="{{ custom_asset($value) }}">
                        @endforeach
                    @endif
    			</div>
        	</div>
        	<div class="container">
        		<div class="row" style="float:right;direction:rtl;">
        	
        			            			<div class="col-xl-6 col-lg-8" >

    		    		<h1 style="color:#2f5e8c;float:right;"  class="fw-700 mb-3 display-4 wow slideInDown">{{ get_setting('slider_section_title') }}</h1>
    		    		<p class="lead mb-5 wow slideInDown">
                            @php
                                echo get_setting('slider_section_subtitle');
                            @endphp
                        </p>
    		    		<div class="wow slideInDown">
    		    			<a href="{{ route('register') }}" class="btn btn-primary">{{ translate('I want to Hire') }}</a>
    		    			<a href="{{ route('register') }}" class="btn btn-outline-primary">{{ translate('I want to Work') }}</a>
    		    		</div>
        			</div>
        		</div>
        	</div>
        </section>
    @endif
    
    @if( get_setting('how_it_works_show') == 'on')
        <section class="pt-7 pb-4 bg-white">
    	<div class="container">
    		<div class="text-center mb-5 w-xl-50 w-lg-75 mx-auto wow slideInDown">
    			<h2 class="fw-700">{{ get_setting('how_it_works_title') }}</h2>
    			<p class="fs-15 text-secondary">{{ get_setting('how_it_works_subtitle') }}</p>
    		</div>
    		<div class="row justify-content-center">
    			<div class="col-xl-4 col-md-6 wow slideInDown">
    				<div class="text-center mb-4 px-xl-5 px-md-3">
    					<img src="{{ custom_asset( get_setting('how_it_works_banner_1') ) }}" class="img-fluid mx-auto">
    					<div class="p-4">
    						@php
                                echo get_setting('how_it_works_description_1')
                            @endphp
    					</div>
    				</div>
    			</div>
    			<div class="col-xl-4 col-md-6 wow slideInDown">
    				<div class="text-center mb-4 px-xl-5 px-md-3">
    					<img src="{{ custom_asset( get_setting('how_it_works_banner_2') ) }}" class="img-fluid mx-auto">
    					<div class="p-4">
                            @php
                                echo get_setting('how_it_works_description_2')
                            @endphp
    					</div>
    				</div>
    			</div>
    			<div class="col-xl-4 col-md-6 wow slideInDown">
    				<div class="text-center mb-4 px-xl-5 px-md-3">
    					<img src="{{ custom_asset( get_setting('how_it_works_banner_3') ) }}" class="img-fluid mx-auto">
    					<div class="p-4">
                            @php
                                echo get_setting('how_it_works_description_3')
                            @endphp
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>
    @endif
   
     @if ( get_setting('featured_category_show') == 'on')
        <section class="pt-7 pb-5">
        	<div class="container">
        		<div class="text-center mb-5 w-lg-75 w-xl-50 lh-1-8 mx-auto wow slideInDown">
        			<h2 class="fw-700">{{ get_setting('featured_category_title') }}</h2>
        			<p class="fs-15 text-secondary">{{ get_setting('featured_category_subtitle') }}</p>
        		</div>
        		<div class="row gutters-10">
        			@if (get_setting('featured_category_list') != null)
                        @foreach (json_decode(get_setting('featured_category_list'), true) as $key => $category_id)
                            @if (($category = \App\Models\ProjectCategory::find($category_id)) != null)
                                <div class="cat col-xl-3 col-lg-3 col-md-4 col-6 wow zoomIn">
                    				<a class="text-center py-3 px-2 d-block card text-inherit shadow-none " href="{{ route('projects.category', $category->slug) }}">
                    					<img src="{{ my_asset($category->photo) }}" class="mw-100  mb-2" >
                    					<p class="mb-0 text-truncate">{{ $category->name }}</p>
                    				</a>
                    			</div>
                            @endif
                        @endforeach
                    @endif
        		</div>
        		<div class="row mt-5 gutters-10">
        			<div class="col-lg-6">
        				<img src="{{ custom_asset( get_setting('featured_category_left_banner') ) }}" class="img-fluid">
        			</div>
        			<div class="col-lg-6">
        				<img src="{{ custom_asset( get_setting('featured_category_right_banner')) }}" class="img-fluid">
        			</div>
        		</div>
        	</div>
        </section>
    @endif
    
            
    <section class="py-5 bg-white">
    <div class="container">
        	<div class="text-center mb-5 w-lg-75 w-xl-50 lh-1-8 mx-auto wow slideInDown">
        			<h2 class="fw-700">{{ translate('Services') }}</h2>
        			<p class="fs-15 text-secondary">{{ get_setting('featured_category_subtitle') }}</p>
        		</div>
        <div class="d-flex align-items-start">            

            <div class="aiz-user-panel">
             
                
                <div class="row gutters-10">
                    @foreach($freelancer_services as $service)
                        <div class="col-lg-3">
                            <div class="card wow zoomIn">
                                <a href="{{ route('service.show', $service->slug) }}"><img src="{{ custom_asset($service->image) }}" class="card-img-top" alt="service_image" height="212"></a>
                                <div class="card-body">
                                    <div class="d-flex mb-2">
                                        <span class="mr-2"><img src="{{ custom_asset($service->user->photo) }}" alt="Hello" height="35" width="35" class="rounded-circle"></span>
                                        <span class="d-flex flex-column justify-content-center">
                                            <a href="{{ route('freelancer.details', $service->user->user_name) }}" class="text-dark"><span class="font-weight-bold">{{ $service->user->name }}</span></a>
                                        </span>
                                    </div>
                                    
                                   <a href="{{ route('service.show', $service->slug) }}" class="text-dark"><h5 class="card-title">{{ \Illuminate\Support\Str::limit($service->title, 40, $end='...') }}</h5></a>
                                </div>
                                
                            </div>
                            
                        </div> 
                    @endforeach   

                            
                </div> 
                <div class="aiz-pagination aiz-pagination-center">
                  	<div class="text-center pt-5">
<a type="button" class="btn btn btn-outline-primary bg-white" style="color: blue;" href="{{Request::root()}}/search?keyword=&type=service">{{ translate('All Services') }} </a>
</div>  
                </div>
            </div>
        </div>
    </div>
</section>        
    @if( get_setting('latest_project_show') == 'on')
        <section class="py-7">
    	<div class="container">
    		<div class="text-center mb-5 w-lg-75 w-xl-50 lh-1-8 mx-auto wow slideInDown">
    			<h2 class="fw-700">{{ get_setting('latest_project_title') }}</h2>
    			<p class="fs-15 text-secondary">{{ get_setting('latest_project_subtitle') }}</p>
    		</div>
    		<div class="row">
    			<div class="col-xl-10 mx-auto">
                    @if(\App\Models\SystemConfiguration::where('type', 'project_approval')->first()->value == 1)
                        @php $projects = \App\Models\Project::biddable()->notcancel()->open()->where('project_approval', 1)->latest()->get()->take(10); @endphp
                    @else
                        @php $projects = \App\Models\Project::biddable()->notcancel()->open()->latest()->get()->take(10); @endphp
                    @endif
                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="3" data-xl-items="2" data-md-items="1" data-arrows='true'>
    				@foreach ($projects as $similar_type_project)
                  	<div class="caorusel-box">
        							<div class="card wow slideInDown">
        								<div class="card-header border-bottom-0 pt-4 pb-0 align-items-start minw-0">
        									<h5 class="h6 fw-600 lh-1-5 text-truncate-2 h-45px">
        										<a href="{{ route('project.details', $similar_type_project->slug) }}" class="text-inherit" target="_blank">{{ $similar_type_project->name }}</a>
        									</h5>
        									<div class="text-right flex-shrink-0 pl-3">
        										<span class="small">{{ translate('Budget') }}</span>
        										<h4 class="mb-0">{{ single_price($similar_type_project->price) }}</h4>
        									</div>
        								</div>
        								<div class="card-body pt-1">

        									<ul class="list-inline opacity-70 fs-12">
        										<li class="list-inline-item">
        											<i class="las la-clock opacity-40"></i>
        											<span>{{ Carbon\Carbon::parse($similar_type_project->created_at)->diffForHumans() }}</span>
        										</li>
        										<li class="list-inline-item">
        											<a href="" target="_blank" class="text-inherit">
        												<i class="las la-stream opacity-40"></i>
        												<span>@if ($similar_type_project->project_category != null) {{ $similar_type_project->project_category->name }} @endif</span>
        											</a>
        										</li>
        										<li class="list-inline-item">
        											<i class="las la-handshake"></i>
        											<span>{{ $similar_type_project->type }}</span>
        										</li>
        									</ul>
        									<div class="text-muted lh-1-8">
        										<p class="text-truncate-2 h-50px mb-0">{{ $similar_type_project->excerpt }}</p>
        									</div>
        								</div>
        								<div class="card-footer">
        									<div class="d-flex align-items-center">
        										<a href="{{ route('client.details', $similar_type_project->client->user_name) }}" target="_blank" class="d-flex mr-3 align-items-center text-inherit">
        		                                    <span class="avatar avatar-xs">
                                                        @if($similar_type_project->client->photo != null)
                                                            <img src="{{ custom_asset($similar_type_project->client->photo) }}">
                                                        @else
                                                            <img src="{{ my_asset('assets/frontend/default/img/avatar-place.png') }}">
                                                        @endif
        		                                    </span>
        		                                    <div class="pl-2">
        		                                    	<h4 class="h6 mb-0">{{ $similar_type_project->client->name }}</h4>
        		                                    	<div class="text-secondary fs-10">
                                                            <i class="las la-star text-rating"></i>
                                                            <span class="fw-600">
                                                            </span>
                                                            <span>
                                                            </span>
        												</div>
        		                                    </div>
        		                                </a>
        									</div>
        									<div>
        										<ul class="d-flex list-inline mb-0">
        											<li>
        				                                <span class="small text-secondary">{{ translate('Total Bids') }}</span>
                                                        @if ($similar_type_project->bids > 0)
                                                            <h4 class="mb-0 h6 fs-13">{{ $similar_type_project->bids }} +</h4>
                                                        @else
                                                            <h4 class="mb-0 h6 fs-13">{{ $similar_type_project->bids }}</h4>
                                                        @endif
        											</li>
        										</ul>
        									</div>
        								</div>
        							</div>
        						</div>
                    @endforeach
    			</div>
    			</div>
    		</div>
    		<div class="text-center pt-5">
    			<a href="{{ route('search') }}?keyword=&type=project" class="btn btn btn-outline-primary">{{ translate('Check All Projects') }}</a>
    		</div>
    	</div>
    </section>
    @endif
  
   
   
    
    
     
      
    @if( get_setting('client_logo_show') == 'on')
        <section class="py-4 bg-white border-bottom">
        	<div class="container">
        	    	<div class="text-center mb-5 w-lg-75 w-xl-50 lh-1-8 mx-auto wow slideInDown">
    			<h2 class="fw-700">شركاء النجاح</h2>
    			<p class="fs-15 text-secondary">تعرف علي افضل الشركات التي تتعامل معنا</p>
    		</div>
        		<div class="row align-items-center">
    				<div class="aiz-carousel gutters-5" data-autoplay='true' data-items="7" data-xl-items="6" data-lg-items="5" data-md-items="4" data-sm-items="3" data-xs-items="2" data-infinite='true'>
                        @if (get_setting('client_logos') != null)
                            @foreach (explode(',', get_setting('client_logos')) as $key => $value)
                                <div class="caorusel-box">
            						<img class="img-fluid wow zoomIn" src="{{ custom_asset($value) }}">
            					</div>
                            @endforeach
                        @endif
    				</div>
        		</div>
        	</div>
        </section>
    @endif       
        @if ( get_setting('cta_section_show') == 'on')
        <section class="py-8">
        	<div class="container">
        		<div class="row">
    	    		<div class="col-xl-6 col-md-8 mx-auto wow slideInDown">
    	    			<div class="text-center">
    		    			<h2 class="fw-700 mb-2">{{ get_setting('cta_section_title') }}</h2>
    		    			<p class="fs-15 opacity-70 mb-4">{{ get_setting('cta_section_subtitle') }}</p>
    	    				<a href="{{ route('register') }}" class="btn btn-primary">{{ translate('Join With Us') }}</a>
    	    			</div>
    	    		</div>
        		</div>
        	</div>
        </section>
    @endif      
@endsection


