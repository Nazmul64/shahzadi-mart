<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Register as a seller on our multi-vendor marketplace">
    <title>Become a Seller - Multi-Vendor Marketplace</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #FF6B35;
            --secondary-color: #FF8C42;
            --text-primary: #2c3e50;
            --text-secondary: #7f8c8d;
            --border-color: #e0e6ed;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
            line-height: 1.6;
        }

        .header {
            background: white;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
        }

        .logo:hover {
            color: var(--secondary-color);
            transform: scale(1.02);
        }

        .logo i {
            font-size: 28px;
        }

        .registration-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .hero-section {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-section h1 {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 15px;
        }

        .registration-form {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            animation: fadeInUp 0.6s ease 0.2s both;
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h2 {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 10px;
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
            padding: 0 20px;
        }

        .step-indicator::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            height: 2px;
            background: var(--border-color);
            z-index: 0;
        }

        .step-progress {
            position: absolute;
            top: 20px;
            left: 20px;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            z-index: 1;
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 8px;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .step.active .step-circle {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-color: var(--primary-color);
            color: white;
            transform: scale(1.1);
        }

        .step.completed .step-circle {
            background: var(--success-color);
            border-color: var(--success-color);
            color: white;
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .required {
            color: var(--danger-color);
        }

        .form-control, .form-select {
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 14px;
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
            outline: none;
        }

        .btn-group-custom {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-custom {
            flex: 1;
            padding: 14px 30px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 53, 0.4);
        }

        .btn-secondary-custom {
            background: #e9ecef;
            color: var(--text-primary);
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }

        .category-card {
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 20px 15px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .category-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
        }

        .category-card.selected {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(255, 140, 66, 0.1));
        }

        .file-upload-wrapper {
            border: 2px dashed var(--border-color);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .file-upload-wrapper:hover {
            border-color: var(--primary-color);
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <a href="/" class="logo">
                <i class="bi bi-shop"></i>
                <span>Marketplace</span>
            </a>
        </div>
    </header>

    <main class="registration-container">
        <section class="hero-section">
            <h1>Start Selling Today! 🚀</h1>
            <p>Join thousands of successful sellers and grow your business with our platform</p>
        </section>

        <section class="registration-form">
            <div class="form-header">
                <h2>Seller Registration</h2>
                <p>Fill in the details below to create your seller account</p>
            </div>

            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="step-indicator">
                <div class="step-progress" id="stepProgress" style="width: 0%"></div>
                <div class="step active" data-step="1">
                    <div class="step-circle">1</div>
                    <span class="step-label">Basic Info</span>
                </div>
                <div class="step" data-step="2">
                    <div class="step-circle">2</div>
                    <span class="step-label">Business</span>
                </div>
                <div class="step" data-step="3">
                    <div class="step-circle">3</div>
                    <span class="step-label">Store</span>
                </div>
                <div class="step" data-step="4">
                    <div class="step-circle">4</div>
                    <span class="step-label">Documents</span>
                </div>
            </div>

            <form id="sellerRegistrationForm" method="POST" action="{{ route('saller.register.submit') }}" enctype="multipart/form-data">
                @csrf

                <!-- Step 1: Basic Information -->
                <div class="form-step active" data-step="1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="firstName">
                                    First Name <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="lastName">
                                    Last Name <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" id="lastName" name="lastName" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email <span class="required">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">Phone <span class="required">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password <span class="required">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Confirm Password <span class="required">*</span></label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <!-- Step 2: Business Details -->
                <div class="form-step" data-step="2">
                    <div class="form-group">
                        <label class="form-label">Business Type <span class="required">*</span></label>
                        <select class="form-select" name="businessType" required>
                            <option value="">Select type</option>
                            <option value="individual">Individual</option>
                            <option value="proprietorship">Proprietorship</option>
                            <option value="partnership">Partnership</option>
                            <option value="company">Company</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Business Name <span class="required">*</span></label>
                        <input type="text" class="form-control" name="businessName" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Business Address <span class="required">*</span></label>
                        <textarea class="form-control" name="businessAddress" rows="3" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">City <span class="required">*</span></label>
                                <input type="text" class="form-control" name="city" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Postal Code <span class="required">*</span></label>
                                <input type="text" class="form-control" name="postalCode" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Store Info -->
                <div class="form-step" data-step="3">
                    <div class="form-group">
                        <label class="form-label">Store Name <span class="required">*</span></label>
                        <input type="text" class="form-control" name="storeName" id="storeName" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Store URL <span class="required">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">marketplace.com/store/</span>
                            <input type="text" class="form-control" name="storeUrl" id="storeUrl" required pattern="[a-z0-9-]+">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Store Description <span class="required">*</span></label>
                        <textarea class="form-control" name="storeDescription" rows="4" required maxlength="500"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Categories <span class="required">*</span></label>
                        <div class="category-grid">
                            <div class="category-card" onclick="toggleCategory(this)">
                                <input type="checkbox" name="categories[]" value="electronics" hidden>
                                <i class="bi bi-laptop"></i>
                                <label>Electronics</label>
                            </div>
                            <div class="category-card" onclick="toggleCategory(this)">
                                <input type="checkbox" name="categories[]" value="fashion" hidden>
                                <i class="bi bi-bag"></i>
                                <label>Fashion</label>
                            </div>
                            <div class="category-card" onclick="toggleCategory(this)">
                                <input type="checkbox" name="categories[]" value="home" hidden>
                                <i class="bi bi-house"></i>
                                <label>Home</label>
                            </div>
                            <div class="category-card" onclick="toggleCategory(this)">
                                <input type="checkbox" name="categories[]" value="sports" hidden>
                                <i class="bi bi-trophy"></i>
                                <label>Sports</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Store Logo</label>
                        <div class="file-upload-wrapper">
                            <input type="file" name="storeLogo" accept="image/*">
                            <i class="bi bi-cloud-upload"></i>
                            <p>Click to upload logo</p>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Documents -->
                <div class="form-step" data-step="4">
                    <div class="form-group">
                        <label class="form-label">National ID <span class="required">*</span></label>
                        <div class="file-upload-wrapper">
                            <input type="file" name="nationalId" accept="image/*,.pdf" required>
                            <i class="bi bi-file-earmark-person"></i>
                            <p>Upload National ID</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Bank Name <span class="required">*</span></label>
                                <select class="form-select" name="bankName" required>
                                    <option value="">Select Bank</option>
                                    <option value="dutch-bangla">Dutch-Bangla</option>
                                    <option value="brac">BRAC</option>
                                    <option value="city">City Bank</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Branch <span class="required">*</span></label>
                                <input type="text" class="form-control" name="branchName" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Account Number <span class="required">*</span></label>
                                <input type="text" class="form-control" name="accountNumber" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Account Holder <span class="required">*</span></label>
                                <input type="text" class="form-control" name="accountHolder" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to Terms & Conditions <span class="required">*</span>
                        </label>
                    </div>
                </div>

                <!-- Success Step -->
                <div class="form-step" data-step="5">
                    <div class="text-center">
                        <div class="success-icon mb-4">
                            <i class="bi bi-check-circle text-success" style="font-size: 80px;"></i>
                        </div>
                        <h3>Registration Successful! 🎉</h3>
                        <p class="mb-3">Thank you for registering. Your account is pending approval.</p>

                        <div class="alert alert-info d-inline-block mb-4" style="max-width: 500px;">
                            <strong>What's Next?</strong><br>
                            <small>
                                1. Your documents will be reviewed (24-48 hours)<br>
                                2. You'll receive approval notification<br>
                                3. Then you can login and start selling!
                            </small>
                        </div>

                        <div class="mb-3">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Redirecting...</span>
                            </div>
                            <p class="mt-2 text-muted">Redirecting to login page...</p>
                        </div>

                        <p class="text-muted">
                            If not redirected automatically,
                            <a href="{{ route('saller.login', ['registered' => 'true']) }}" class="fw-bold text-decoration-none">click here</a>
                        </p>
                    </div>
                </div>

                <div class="btn-group-custom" id="navigationButtons">
                    <button type="button" class="btn-secondary-custom btn-custom" id="prevBtn" style="display:none;" onclick="changeStep(-1)">
                        <i class="bi bi-arrow-left"></i> Previous
                    </button>
                    <button type="button" class="btn-primary-custom btn-custom" id="nextBtn" onclick="changeStep(1)">
                        Next <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </form>
        </section>
    </main>

    <script>
        let currentStep = 1;
        const totalSteps = 4;

        function updateStepIndicator() {
            const steps = document.querySelectorAll('.step');
            const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
            document.getElementById('stepProgress').style.width = progress + '%';

            steps.forEach((step, index) => {
                const stepNum = index + 1;
                step.classList.remove('active', 'completed');

                if (stepNum === currentStep) {
                    step.classList.add('active');
                } else if (stepNum < currentStep) {
                    step.classList.add('completed');
                }
            });
        }

        function changeStep(direction) {
            const formSteps = document.querySelectorAll('.form-step');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            if (direction === 1 && !validateStep()) {
                return;
            }

            if (currentStep + direction === 5) {
                submitForm();
                return;
            }

            if (currentStep + direction >= 1 && currentStep + direction <= totalSteps) {
                formSteps[currentStep - 1].classList.remove('active');
                currentStep += direction;
                formSteps[currentStep - 1].classList.add('active');

                prevBtn.style.display = currentStep === 1 ? 'none' : 'flex';
                nextBtn.innerHTML = currentStep === totalSteps
                    ? 'Submit <i class="bi bi-check-circle"></i>'
                    : 'Next <i class="bi bi-arrow-right"></i>';

                updateStepIndicator();
                window.scrollTo(0, 0);
            }
        }

        function validateStep() {
            const currentStepElement = document.querySelector(`.form-step[data-step="${currentStep}"]`);
            const requiredInputs = currentStepElement.querySelectorAll('[required]');
            let isValid = true;

            requiredInputs.forEach(input => {
                if (!input.value.trim() && input.type !== 'checkbox') {
                    input.style.borderColor = 'var(--danger-color)';
                    isValid = false;
                } else if (input.type === 'checkbox' && !input.checked) {
                    isValid = false;
                }
            });

            if (!isValid) {
                alert('Please fill all required fields');
            }

            return isValid;
        }

        function submitForm() {
            const nextBtn = document.getElementById('nextBtn');
            const navigationButtons = document.getElementById('navigationButtons');
            const formData = new FormData(document.getElementById('sellerRegistrationForm'));

            // Show loading on button
            if (nextBtn) {
                nextBtn.disabled = true;
                nextBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Submitting...';
            }

            // Submit via AJAX
            fetch('{{ route("saller.register.submit") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hide navigation buttons
                    if (navigationButtons) {
                        navigationButtons.style.display = 'none';
                    }

                    // Show success step
                    document.querySelector('.form-step.active').classList.remove('active');
                    document.querySelector('.form-step[data-step="5"]').classList.add('active');

                    // Update all steps to completed
                    document.querySelectorAll('.step').forEach(step => {
                        step.classList.add('completed');
                        step.classList.remove('active');
                    });

                    document.getElementById('stepProgress').style.width = '100%';

                    // Redirect to login after 2 seconds
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 2000);
                } else {
                    // Show errors
                    if (nextBtn) {
                        nextBtn.disabled = false;
                        nextBtn.innerHTML = 'Submit <i class="bi bi-check-circle"></i>';
                    }

                    let errorMessage = data.message || 'Registration failed. Please try again.';

                    if (data.errors) {
                        errorMessage += '\n\nErrors:\n';
                        Object.keys(data.errors).forEach(key => {
                            errorMessage += `- ${data.errors[key].join(', ')}\n`;
                        });
                    }

                    alert(errorMessage);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (nextBtn) {
                    nextBtn.disabled = false;
                    nextBtn.innerHTML = 'Submit <i class="bi bi-check-circle"></i>';
                }
                alert('An error occurred. Please try again.');
            });
        }

        function toggleCategory(card) {
            const checkbox = card.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            card.classList.toggle('selected');
        }

        // Auto-generate store URL from store name
        document.getElementById('storeName')?.addEventListener('input', function() {
            const storeUrl = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-');
            document.getElementById('storeUrl').value = storeUrl;
        });

        updateStepIndicator();
    </script>
</body>
</html>
