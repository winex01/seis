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

                    @foreach($navs as $game_id => $nav)
                        <li>
                            <a href="{{ route('sport.show', [$game_id]) }}"><i class="fa fa-home fa-circle-thin"></i> {{ $nav }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>

        
        