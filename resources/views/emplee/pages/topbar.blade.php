<!-- TOPBAR -->
<div id="topbar">
    <div class="topbar-left">
        <button class="icon-btn d-xl-none" onclick="document.body.classList.toggle('sb-open')">
            <i class="fas fa-bars"></i>
        </button>
        <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search..."/>
        </div>
    </div>
    <div class="topbar-right">
      <button class="icon-btn d-none d-sm-flex" title="Notifications">
        <i class="fas fa-bell"></i>
        <span class="badge-dot">4</span>
      </button>
      <div class="user-pill">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff" alt="User"/>
        <span class="uname">{{ auth()->user()->name }}</span>
        <i class="fas fa-chevron-down ms-1" style="font-size:10px; opacity:0.5;"></i>
      </div>
    </div>
</div>
