@extends('frontend.layouts.dashboard')
@section('dash-meta')
    <title>Account Settings - {{ get_setting('site_name') }}</title>
    <style>
        .account-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            align-items: start;
        }

        .password-field {
            position: relative;
        }

        .password-field .input-style {
            padding-right: 2.75rem;
        }

        .toggle-pw {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0;
            font-size: 0.9rem;
        }

        .toggle-pw:hover {
            color: var(--primary);
        }

        .submit-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 1.5rem;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.15s;
        }

        .submit-btn:hover {
            opacity: 0.85;
        }

        .social-notice {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 1rem 1.125rem;
            font-size: 0.875rem;
            color: #1e40af;
        }

        .social-notice i {
            flex-shrink: 0;
            font-size: 1rem;
            margin-top: 0.1rem;
        }

        /* Avatar upload */
        .avatar-card {
            margin-bottom: 1.5rem;
        }

        .avatar-upload-wrap {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .avatar-preview {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--border);
            flex-shrink: 0;
        }

        .avatar-initials {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #1b3a6b;
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 3px solid var(--border);
        }

        .avatar-upload-info {
            flex: 1;
        }

        .avatar-upload-info p {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin: 0.35rem 0 0;
        }

        .avatar-file-label {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.55rem 1.1rem;
            background: var(--bg-light);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-dark);
            cursor: pointer;
            transition: border-color 0.15s, color 0.15s;
        }

        .avatar-file-label:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .avatar-file-input {
            display: none;
        }

        .avatar-save-btn {
            display: none;
            align-items: center;
            gap: 0.4rem;
            padding: 0.55rem 1.1rem;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.15s;
            margin-left: 0.5rem;
        }

        .avatar-save-btn:hover {
            opacity: 0.85;
        }

        @media (max-width: 768px) {
            .account-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('dashboard-content')
    <div class="my-listings-header">
        <h1>Account Settings</h1>
    </div>

    {{-- ── Profile Photo ── --}}
    <div class="dashboard-card avatar-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fa-solid fa-camera" style="margin-right:.5rem;color:var(--primary)"></i>Profile Photo
            </h3>
        </div>

        <form action="{{ route('member.account.update.image') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
            @csrf

            <div class="avatar-upload-wrap">
                @if ($user->image)
                    <img src="{{ asset(getFilePath($user->image)) }}" alt="{{ $user->name }}" class="avatar-preview"
                        id="avatarPreview">
                @else
                    <div class="avatar-initials" id="avatarInitials">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <img src="" alt="{{ $user->name }}" class="avatar-preview" id="avatarPreview"
                        style="display:none">
                @endif

                <div class="avatar-upload-info">
                    <label for="profileImageInput" class="avatar-file-label">
                        <i class="fa-solid fa-arrow-up-from-bracket"></i> Choose Photo
                    </label>
                    <button type="submit" class="avatar-save-btn" id="avatarSaveBtn">
                        <i class="fa-solid fa-floppy-disk"></i> Upload
                    </button>
                    <input type="file" name="profile_image" id="profileImageInput" class="avatar-file-input"
                        accept="image/jpeg,image/png,image/jpg,image/webp">
                    <p>JPG, PNG or WEBP. Max 2 MB.</p>
                    @error('profile_image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </form>
    </div>

    <div class="account-grid">

        {{-- ── Profile Information ── --}}
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa-solid fa-user" style="margin-right:.5rem;color:var(--primary)"></i>Profile Information
                </h3>
            </div>

            <form action="{{ route('member.account.update.profile') }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <div class="form-group mb-20">
                    <label>Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="input-style @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}" placeholder="Your full name">
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-20">
                    <label>Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="input-style @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}" placeholder="your@email.com">
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-20">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="input-style @error('phone') is-invalid @enderror"
                        value="{{ old('phone', $user->phone) }}" placeholder="+1 234 567 8900">
                    @error('phone')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="submit-btn">
                        <i class="fa-solid fa-floppy-disk"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>

        {{-- ── Change Password ── --}}
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa-solid fa-lock" style="margin-right:.5rem;color:var(--primary)"></i>Change Password
                </h3>
            </div>

            @if ($user->social_provider)
                <div class="social-notice">
                    <i class="fa-solid fa-circle-info"></i>
                    Your account is linked via <strong>{{ ucfirst($user->social_provider) }}</strong>.
                    Password change is not available for social login accounts.
                </div>
            @else
                <form action="{{ route('member.account.update.password') }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-20">
                        <label>Current Password <span class="text-danger">*</span></label>
                        <div class="password-field">
                            <input type="password" name="current_password" id="currentPassword"
                                class="input-style @error('current_password') is-invalid @enderror"
                                placeholder="Enter current password">
                            <button type="button" class="toggle-pw" onclick="togglePw('currentPassword', this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-20">
                        <label>New Password <span class="text-danger">*</span></label>
                        <div class="password-field">
                            <input type="password" name="new_password" id="newPassword"
                                class="input-style @error('new_password') is-invalid @enderror"
                                placeholder="Min. 8 characters">
                            <button type="button" class="toggle-pw" onclick="togglePw('newPassword', this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('new_password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-20">
                        <label>Confirm New Password <span class="text-danger">*</span></label>
                        <div class="password-field">
                            <input type="password" name="new_password_confirmation" id="confirmPassword"
                                class="input-style" placeholder="Repeat new password">
                            <button type="button" class="toggle-pw" onclick="togglePw('confirmPassword', this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="submit-btn">
                            <i class="fa-solid fa-key"></i> Update Password
                        </button>
                    </div>
                </form>
            @endif
        </div>

    </div>
@endsection

@section('dashboard-js')
    <script>
        function togglePw(id, btn) {
            const input = document.getElementById(id);
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            btn.querySelector('i').className = isText ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash';
        }

        document.getElementById('profileImageInput').addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                const initials = document.getElementById('avatarInitials');
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (initials) initials.style.display = 'none';
            };
            reader.readAsDataURL(file);

            document.getElementById('avatarSaveBtn').style.display = 'inline-flex';
        });
    </script>
@endsection
