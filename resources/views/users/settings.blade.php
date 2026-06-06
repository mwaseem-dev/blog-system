@extends('layouts.app')

@section('content')
<div class="dashboard-container max-w-2xl">
    <div class="mb-8">
        <h1 class="dashboard-title">⚙️ Settings</h1>
        <p class="dashboard-subtitle mt-2">Manage your account preferences</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 font-medium">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <ul class="text-red-700 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg p-8 space-y-8">
        <!-- Profile Information -->
        <div class="border-b border-slate-200 pb-8">
            <h2 class="text-2xl font-bold text-slate-900 mb-6">👤 Profile Information</h2>

            <form id="settingsForm" action="{{ route('settings') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ $user->name }}" placeholder="Your name" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ $user->email }}" placeholder="your@email.com" class="form-input" required>
                </div>

                <!-- Profile Picture Upload -->
                <div class="form-group">
                    <label for="profile_picture" class="form-label">Profile Picture (Optional)</label>
                    <div class="flex items-center gap-6">
                        <!-- Current Profile Picture -->
                        <div class="flex-shrink-0">
                            <img src="{{ $user->getProfilePictureUrl() }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover border-2 border-blue-200">
                        </div>
                        
                        <!-- File Input -->
                        <div class="flex-1">
                            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="form-input" onchange="previewImage(event)">
                            <p class="text-sm text-slate-500 mt-2">Max 2MB. Formats: JPEG, PNG, JPG, GIF</p>
                        </div>
                    </div>
                    
                    <!-- Image Preview -->
                    <img id="preview" style="display: none;" class="mt-4 w-32 h-32 rounded-lg object-cover border-2 border-blue-200">

                </div>

                <button id="saveBtn" type="submit" class="mt-6 px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-md hover:shadow-lg">
                    💾 Save Changes
                </button>
            </form>

            <!-- Remove Picture Form - OUTSIDE main form to prevent nesting -->
            @if($user->profile_picture)
                <form action="{{ route('remove-profile-picture') }}" method="POST" style="display: inline-block; margin-top: 1rem;">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 transition-colors duration-200" onclick="return confirm('Are you sure you want to remove your profile picture?')">
                        🗑️ Remove Picture
                    </button>
                </form>
            @endif
        </div>
        </div>

        <!-- Account Information -->
        <div>
            <h2 class="text-2xl font-bold text-slate-900 mb-4">ℹ️ Account Information</h2>
            <div class="space-y-3 text-slate-600">
                <p><strong>Member Since:</strong> {{ $user->created_at->format('F d, Y') }}</p>
                <p><strong>Total Posts:</strong> {{ $user->posts()->count() }}</p>
                <p><strong>Last Updated:</strong> {{ $user->updated_at->format('F d, Y \\a\\t h:i A') }}</p>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
}

// Add loading animation to Save button
document.getElementById('settingsForm').addEventListener('submit', function(e) {
    const btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.style.opacity = '0.75';
    btn.style.cursor = 'not-allowed';
    btn.innerHTML = '⏳ Saving Changes...';
});
</script>
@endsection
