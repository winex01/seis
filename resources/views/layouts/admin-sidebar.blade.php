<div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                        </div>
                        <!-- /input-group -->
                    </li>
                    {{-- <li>
                        <a href="{{ route('home') }}"><i class="fa fa-home fa-fw"></i> Home</a>
                    </li> --}}
                    <li>
                        <a href="{{ route('event.index') }}"><i class="fa fa-list-alt fa-fw"></i> Events</a>
                    </li>

                    <li>
                        <a href="{{ route('gametype.index') }}"><i class="fa fa-th fa-fw"></i>Sports</a>
                    </li>

                    <li>
                        <a href="{{ route('team.index') }}"><i class="fa fa-users fa-fw"></i> Teams</a>
                    </li>

                    <li>
                        <a href="{{ route('manager.index') }}"><i class="fa fa-user fa-fw"></i> Sports Manager</a>
                    </li>

                    {{-- <li>
                        <a href="{{ route('user.index') }}"><i class="fa fa-user fa-fw"></i> Users</a>
                    </li> --}}

                    {{-- <li>
                        <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="flot.html">Flot Charts</a>
                            </li>
                            <li>
                                <a href="morris.html">Morris.js Charts</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                    </li> --}}
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        