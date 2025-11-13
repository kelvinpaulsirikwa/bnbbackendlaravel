{{-- resources/views/layouts/sidebar.blade.php --}}

@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;

    $user = Auth::user();
    $role = $user->role ?? '';
    $email = $user->useremail ?? 'noemail';
    
    // Check if user has profile image and if the file actually exists
    $avatar = asset('images/static_files/nodp.png'); // Default fallback
    
    if ($user && $user->profileimage) {
        $imagePath = 'storage/' . $user->profileimage;
        $fullPath = public_path($imagePath);
        
        // Check if the file actually exists
        if (file_exists($fullPath)) {
            $avatar = asset($imagePath);
        }
        // If file doesn't exist, keep the default nodp.png
    }
        
@endphp

<section id="sidebar" class="hide">
    <!-- User Info -->
    <br><br>
    <div class="form-group d-flex align-items-center ps-4">
        <!-- User/Profile Image -->
        <img src="{{ $avatar }}" 
             alt="User" 
             class="rounded-circle me-3" 
             style="width: 50px; height: 50px; object-fit: cover;"
             onerror="handleImageError(this)">

        <!-- User Details -->
        <ul class="list-unstyled mb-0">
            <li class="text-muted small">{{ $email }}</li>
            <li class="text-muted small">{{ $role }}</li>
        </ul>
    </div>

    <ul class="side-menu">
        <!-- Common Links (user + admin) -->
        <li>
            <a href="{{ route('adminpages.dashboard') }}" class="active">
                <i class="bx bxs-dashboard icon"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="#">
                <i class="bx bxs-home icon"></i>
                Website Home
            </a>
        </li>

        <li class="divider" data-text="Finance Management"></li>
        <li>
            <a href="#">
                <i class="bx bx-transfer icon"></i>
                Finance Transactions
            </a>
        </li>
        <li>
            <a href="#">
                <i class="bx bx-bar-chart-square icon"></i>
                Finance Reports
            </a>
        </li>
        <li>
            <a href="#">
                <i class="bx bx-buildings icon"></i>
                Specific BnB
            </a>
        </li>
      
        <li class="divider" data-text="Location Management"></li>

        
        <li>
            <a href="{{ route('adminpages.countries.index') }}">
                <i class="bx bxs-flag icon"></i>
                Countries
            </a>
        </li>
        <li>
            <a href="{{ route('adminpages.regions.index') }}">
                <i class="bx bxs-map icon"></i>
                Regions
            </a>
        </li>
        <li>
            <a href="{{ route('adminpages.districts.index') }}">
                <i class="bx bxs-building icon"></i>
                Districts
            </a>
        </li>
        <li class="divider" data-text="Amenity Management"></li>

        
<li>
    <a href="{{ route('adminpages.amenities.index') }}">
        <i class="bx bx-package icon"></i>
        Amenities
    </a>
</li>
<li>
    <a href="{{ route('adminpages.motel-types.index') }}">
        <i class="bx bx-building icon"></i>
        Motel Types
    </a>
</li>
<li>
    <a href="{{ route('adminpages.room-types.index') }}">
        <i class="bx bx-bed icon"></i>
        Room Types
    </a>
</li>
        <li class="divider" data-text="Guest Messaging"></li>
<li>
    <a href="{{ route('adminpages.chats.index') }}">
        <i class="bx bx-conversation icon"></i>
        Guest Chats
    </a>
</li>
<li>
    <a href="{{ route('adminpages.contact-messages.index') }}">
        <i class="bx bx-envelope icon"></i>
        Contact Messages
    </a>
</li>
        <li class="divider" data-text="Motel Management"></li>
<li>
    <a href="{{ route('adminpages.motels.index') }}">
        <i class="bx bx-home icon"></i>
        Motels
    </a>
</li>
        <li class="divider" data-text="User Management"></li>
        <li>
            <a href="{{ route('adminpages.users.index') }}">
                <i class="bx bxs-user icon"></i>
                User Management
            </a>
        </li>
        <li class="divider" data-text="Account Management"></li>
        <li>
            <a href="{{ route('adminpages.profile.edit') }}">
                <i class="bx bxs-user-circle icon"></i>
                Profile Management
            </a>
        </li>


        <!-- Logout -->
        <div class="ads">
            <div class="wrapper">
                <a href="{{ route('logout') }}" 
                   class="btn-upgrade"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   LOGOUT
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <p>Please <span>logout</span> to keep your account safe.</p>
            </div>
        </div>
    </ul>
</section>
