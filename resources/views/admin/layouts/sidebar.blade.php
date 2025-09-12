   <div class="app-sidebar sidebar-shadow">
       <div class="app-header__logo">
           <div class="logo-src"></div>
           <div class="header__pane ml-auto">
               <div>
                   <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                       data-class="closed-sidebar">
                       <span class="hamburger-box">
                           <span class="hamburger-inner"></span>
                       </span>
                   </button>
               </div>
           </div>
       </div>
       <div class="app-header__mobile-menu">
           <div>
               <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                   <span class="hamburger-box">
                       <span class="hamburger-inner"></span>
                   </span>
               </button>
           </div>
       </div>
       <div class="app-header__menu">
           <span>
               <button type="button"
                   class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                   <span class="btn-icon-wrapper">
                       <i class="fa fa-ellipsis-v fa-w-6"></i>
                   </span>
               </button>
           </span>
       </div>
       <div class="scrollbar-sidebar">
           <div class="app-sidebar__inner">
               @php
               use Illuminate\Support\Str;

               $menus = getAdminMenus();
               $currentUrl = request()->path();
               @endphp

               <ul class="vertical-nav-menu">
                   <li class="app-sidebar__heading">Menu</li>

                   @foreach($menus as $menu)
                   @php
                   $hasChildren = $menu->children->count() > 0;
                   $isActive = Str::startsWith($currentUrl, ltrim($menu->url ?? '', '/')) ? 'mm-active' : '';
                   @endphp

                   <li class="{{ $isActive }}">
                       <a href="{{ $hasChildren ? '#' : url($menu->url) }}" class="{{ $isActive }}">
                           <i class="{{ $menu->icon_class }}"></i>
                           {{ $menu->name }}
                           @if($hasChildren)
                           <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                           @endif
                       </a>

                       @if($hasChildren)
                       <ul>
                           @foreach($menu->children as $child)
                           @php
                           $childHasChildren = $child->children->count() > 0;
                           $childActive = Str::startsWith($currentUrl, ltrim($child->url ?? '', '/')) ? 'mm-active' : '';
                           @endphp

                           <li class="{{ $childActive }}">
                               <a href="{{ $childHasChildren ? '#' : url($child->url) }}" class="{{ $childActive }}">
                                   <i class="{{ $child->icon_class }}"></i>
                                   {{ $child->name }}
                                   @if($childHasChildren)
                                   <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                   @endif
                               </a>

                               @if($childHasChildren)
                               <ul>
                                   @foreach($child->children as $subChild)
                                   @php
                                   $subActive = Str::startsWith($currentUrl, ltrim($subChild->url ?? '', '/')) ? 'mm-active' : '';
                                   @endphp
                                   <li class="{{ $subActive }}">
                                       <a href="{{ url($subChild->url) }}" class="{{ $subActive }}">
                                           <i class="{{ $subChild->icon_class }}"></i>
                                           {{ $subChild->name }}
                                       </a>
                                   </li>
                                   @endforeach
                               </ul>
                               @endif
                           </li>
                           @endforeach
                       </ul>
                       @endif
                   </li>
                   @endforeach
               </ul>


           </div>
       </div>
   </div>