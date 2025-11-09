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
            <a href="{{ route('bnbowner.dashboard') }}" class="active">
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

      
        <li class="divider" data-text="Hotel Management"></li>

        
        <li>
            <a href="{{ route('bnbowner.hotel-management.index') }}">
                <i class="bx bxs-flag icon"></i>
                Hotel Information
            </a>
        </li>

        <li class="divider" data-text="Guest Messaging"></li>

        <li>
            <a href="{{ route('bnbowner.chats.index') }}">
                <i class="bx bxs-message-detail icon"></i>
                Guest Chats
            </a>
        </li>

        <li class="divider" data-text="Room Management"></li>

        <li>
            <a href="{{ route('bnbowner.room-management.index') }}">
                <i class="bx bxs-bed icon"></i>
                Room Management
            </a>
        </li>

        <li class="divider" data-text="Staff Management"></li>

        <li>
            <a href="{{ route('bnbowner.staff-management.index') }}">
                <i class="bx bxs-user-badge icon"></i>
                Staff Management
            </a>
        </li>

        <li class="divider" data-text="Room Items & Images"></li>

        <li>
            <a href="#" onclick="alert('Please select a room first from Room Management')">
                <i class="bx bxs-box icon"></i>
                Room Items
            </a>
        </li>

        <li>
            <a href="#" onclick="alert('Please select a room first from Room Management')">
                <i class="bx bxs-image icon"></i>
                Room Images
            </a>
        </li>
     

        <li class="divider" data-text=" Account Management"></li>
        <li>
            <a href="{{ route('bnbowner.switch-account') }}">
                <i class="bx bxs-switch icon"></i>
                Switch Account
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
