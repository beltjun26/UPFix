<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}">
    </script>
    @yield('header')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style media="screen">
      .img-responsive{
        height: 30px;
      }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ Auth::check()? '/home' : '/' }}">
                        <img class="img-responsive" src="{{ asset('/images/upfixLogo.png') }}" alt="UPFix"/>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @auth
                          @if(Auth::user()->role == 'client')
                            <li class="
                            {{
                               (Request::route()->getName()=='home' ||
                               Request::route()->getName()=='C_requestForm')? 'active' : ''
                             }}"><a href="/home">Job Requests <span class="badge">{{ Auth::user()->getRole->getNotifNumber('job_request') }}</span></a></li>
                            <li class="{{ (Request::route()->getName()=='C_accomplishedRequests')? 'active' : '' }}">
                              <a href="/client/accomplishedRequests">Accomplished Requests
                                <span class="badge">{{ Auth::user()->getRole->getNotifNumber('accomplished_requests') }}</span>
                              </a>
                            </li>
                            <li class="{{ (Request::route()->getName()=='C_conflicts' ||
                              Request::route()->getName()=='C_conflictRequest')? 'active' : '' }}">
                              <a href="/client/conflicts">Conflicts
                                <span class="badge">{{ Auth::user()->getRole->getNotifNumber('conflict') }}</span>
                              </a>
                            </li>
                            <li class="{{ (Request::route()->getName()=='C_allRequests')? 'active' : '' }}">
                              <a href="/client/allRequests">All Request
                                <span class="badge">{{ Auth::user()->getRole->getNotifNumber('all_requests') }}</span>
                              </a>
                            </li>
                          @endif
                          @if(Auth::user()->role == 'incharge')
                            <li class="{{ (Request::route()->getName()=='home')? 'active' : '' }}">
                              <a href="/home">Unrecommend Requests
                                <span class="badge">{{ Auth::user()->getRole->getNotifNumber('unrecommend_requests') }}</span>
                              </a>
                            </li>
                            <li class="{{ (Request::route()->getName()=='I_assignRequest')? 'active' : '' }}">
                              <a href="/incharge/assignRequests">Assign Requests
                                <span class="badge">{{ Auth::user()->getRole->getNotifNumber('assign_requests') }}</span>
                              </a>
                            </li>
                            <li class="{{ (Request::route()->getName()=='I_services')? 'active' : '' }}"><a href="/incharge/services">Services</a></li>
                            <li class="{{ (Request::route()->getName()=='I_allRequest')? 'active' : '' }}">
                              <a href="/incharge/allRequests">All Requests
                                <span class="badge">{{ Auth::user()->getRole->getNotifNumber('all_requests') }}</span>
                              </a>
                            </li>
                            <li class="{{
                               (Request::route()->getName()=='I_serviceProviders' ||
                               Request::route()->getName()=='I_reports' ||
                               Request::route()->getName()=='I_ServiceProviderForm')? 'active' : ''
                             }}"><a href="/incharge/serviceProviders">Service Providers</a></li>
                          @endif
                          @if(Auth::user()->role == 'chairman')
                            <li class="{{ (Request::route()->getName()=='home')? 'active' : '' }}">
                              <a href="/home">Unapproved Requests
                                <span class="badge">{{ Auth::user()->getRole->getNotifNumber('unappoved_requests') }}</span>
                              </a>
                            </li>
                            <li class="{{ (Request::route()->getName()=='CH_allRequests')? 'active' : '' }}">
                              <a href="/chairman/allRequests">All Requests
                                <span class="badge">{{ Auth::user()->getRole->getNotifNumber('all_requests') }}</span>
                              </a>
                            </li>
                            <li class="{{
                               (Request::route()->getName()=='CH_serviceProviders' ||
                               Request::route()->getName()=='SPReport')? 'active' : ''
                             }}"><a href="/chairman/serviceProviders">Service Providers</a></li>
                          @endif
                          @if(Auth::user()->role == 'serviceProvider')
                            <li class="{{ (Request::route()->getName()=='home')? 'active' : '' }}">
                              <a href="/home">Job Requests
                                <span class="badge">{{ Auth::user()->getRole->getNotifNumber('job_requests') }}</span>
                              </a>
                            </li>
                            <li class="{{ (Request::route()->getName()=='S_allRequests')? 'active' : '' }}">
                              <a href="/serviceProvider/allRequests">All Requests
                                <span class="badge">{{ Auth::user()->getRole->getNotifNumber('all_requests') }}</span>
                              </a>
                            </li>
                            <li class="{{ (Request::route()->getName()=='S_unavailability' ||
                              Request::route()->getName()=='S_unavailabilityList')? 'active' : '' }}">
                              <a href="/serviceProvider/unavailability">Unavailability</a>
                            </li>
                          @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->

                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @auth
                          <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                  {{ Auth::user()->fullName }} <span class="caret"></span>
                              </a>

                              <ul class="dropdown-menu" role="menu">
                                  <li>
                                    <a href="/profile/{{ Auth::user()->username }}">Profile</a>
                                  </li>
                                  <li>
                                      <a href="{{ route('logout') }}"
                                          onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                          Logout
                                      </a>

                                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                          {{ csrf_field() }}
                                      </form>
                                  </li>
                              </ul>
                          </li>
                          @endauth
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
