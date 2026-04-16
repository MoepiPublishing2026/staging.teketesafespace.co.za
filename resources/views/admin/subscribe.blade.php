<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Subscription | Tekete SafeSpace</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --green: #c7da30;
            --blue: #38b6ff;
            --text: #545454;
            --light-bg: #f3f5f4;
        }

        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background: var(--light-bg);
            color: var(--text);
        }

        /* MAIN CONTAINER */
        .container {
            max-width: 1200px;
            margin: 80px auto;
            text-align: center;
        }

        /* TITLE */
        h1 {
            font-size: 34px;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .subtitle {
            max-width: 850px;
            margin: 0 auto 60px auto;
            font-size: 15px;
            line-height: 1.7;
        }

        /* PLANS ROW */
        .plans {
            display: flex;
            justify-content: center;
            gap: 35px;
        }

        /* CARD */
        .card {
            background: white;
            width: 290px;
            border-radius: 28px;
            padding: 40px 30px;
            border: 3px solid var(--green);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* TITLE */
        .card h3 {
            font-size: 18px;
            color: var(--blue);
            font-weight: 700;
            margin: 0;
            text-align: center;
        }

        .title-line {
            width: 170px;
            height: 3px;
            background: var(--green);
            margin: 10px auto 20px auto;
        }

        /* PRICE */
        .price {
            font-size: 28px;
            font-weight: 800;
            margin: 10px 0;
            color: var(--blue);
        }

        .price span {
            font-size: 14px;
            font-weight: 500;
        }

        /* FREE TEXT */
        .free {
            font-size: 22px;
            font-weight: 700;
            color: var(--blue);
            margin: 10px 0 20px 0;
        }

        /* GREEN HEADER INSIDE ANNUAL */
        .best-value-header {
            background: var(--green);
            color: white;
            padding: 14px 0;
            font-weight: 700;
            border-radius: 24px 24px 0 0;
            margin: -40px -30px 25px -30px;
        }

        /* FEATURE LIST */
        ul {
            list-style: none;
            padding: 0;
            text-align: left;
            margin: 20px 0;
        }

        ul li {
            margin-bottom: 12px;
            font-size: 14px;
            line-height: 1.4;
        }

        ul li {
            margin-bottom: 14px;
            font-size: 14px;
            line-height: 1.4;
            display: flex;
            align-items: flex-start;
        }

        ul li::before {
            content: "✔";
            background: var(--green);
            color: white;
            font-size: 11px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            flex-shrink: 0;
        }

        #limitationsModal ul {
            list-style: disc;
            padding-left: 20px;
        }

        #limitationsModal ul li {
            display: list-item;
            margin-bottom: 8px;
        }

        #limitationsModal ul li::before {
            content: none;
            /* removes green check */
        }

        .dashboard-link {
            display: inline-block;
            margin-top: 70px;
            /* pushes it further down */
            color: var(--blue);
            /* make blue */
            font-weight: 600;
            text-decoration: none;
            font-size: 15px;
        }

        footer {
            margin-top: 10px;
            padding: 25px;
            background: #6f6f6f;
            /* correct grey */
            color: white;
            text-align: center;
            font-size: 14px;
        }

        .limitations-note {
            font-size: 14px;
            margin-top: 15px;
            font-weight: 600;
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
        }

        .faq-link {
            color: var(--text);
            /* blackish */
            font-size: 17px;
            font-weight: 600;
            text-decoration: none;
            /* removes underline */
            transition: color 0.3s ease;
        }

        .faq-link:hover {
            color: var(--green);
        }

        /* BUTTON */
        .btn {
            margin-top: 25px;
            padding: 12px;
            border-radius: 30px;
            border: 2px solid var(--green);
            background: transparent;
            font-weight: 700;
            color: var(--blue);
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn:hover {
            background: var(--green);
            color: black;
        }
    </style>
</head>

<!-- LIMITATIONS MODAL -->
<div id="limitationsModal"
    style="
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.4);
    justify-content:center;
    align-items:center;
    z-index:1000;
">

    <div
        style="
        background:white;
        width:600px;
        max-width:90%;
        padding:35px 40px;
        border-radius:20px;
        border:4px solid var(--green);
        position:relative;
    ">

        <h3
            style="
            color:var(--blue);
            font-weight:700;
            margin-bottom:20px;
        ">
            Limitations:
        </h3>

        <ul style="margin-bottom:20px;">
            <li>Maximum of 5 active cases per term</li>
            <li>No advanced reporting or analytics</li>
            <li>No case escalation tools</li>
            <li>Limited administrator controls</li>
            <li>Email support only</li>
            <li>No training sessions included</li>
        </ul>

        <p class="limitations-note">
            The Free Plan allows schools to test Tekete SafeSpace in a controlled,
            compliant way before upgrading to a full subscription.
        </p>

        <div style="text-align:right; margin-top:20px;">
            <button onclick="closeLimitations()"
                style="
                    padding:8px 18px;
                    border-radius:20px;
                    border:2px solid var(--green);
                    background:transparent;
                    font-weight:600;
                    cursor:pointer;
                ">
                Close
            </button>
        </div>

    </div>
</div>
<script>
    function openLimitations() {
        document.getElementById('limitationsModal').style.display = 'flex';
    }

    function closeLimitations() {
        document.getElementById('limitationsModal').style.display = 'none';
    }
</script>

<body>

    <header class="main-header">
        <img src="{{ asset('images/logo.png') }}" alt="Tekete SafeSpace" height="50">

        <a href="{{ route('faq') }}" class="faq-link">
            FAQ
        </a>
    </header>

    {{-- Session messages --}}
    @if (session('success'))
        <div style="background:#c7da30;color:#000;padding:14px 30px;text-align:center;font-weight:600;">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if (session('warning'))
        <div style="background:#f97316;color:#fff;padding:14px 30px;text-align:center;font-weight:600;">
            ⚠️ {{ session('warning') }}
        </div>
    @endif

    {{-- Current plan banner --}}
    @if ($subscription)
        <div
            style="background:#fff;border-bottom:3px solid var(--green);padding:14px 40px;display:flex;align-items:center;justify-content:center;gap:20px;font-size:14px;font-weight:600;">
            @if ($subscription->isActive())
                <span style="background:var(--green);color:#000;padding:4px 14px;border-radius:20px;">ACTIVE</span>
                <span>Current Plan: <strong>{{ $subscription->plan_label }}</strong></span>
                @if ($subscription->expires_at)
                    <span style="color:#888;">· Expires: {{ $subscription->expires_at->format('d M Y') }}</span>
                @else
                    <span style="color:#888;">· No expiry</span>
                @endif
            @elseif($subscription->isExpired())
                <span style="background:#ef4444;color:#fff;padding:4px 14px;border-radius:20px;">EXPIRED</span>
                <span>Your <strong>{{ $subscription->plan_label }}</strong> expired on
                    {{ $subscription->expires_at->format('d M Y') }}. Please renew below.</span>
            @endif
        </div>
    @endif

    <div class="container">

        <h1>Tekete SafeSpace Subscription</h1>

        <p class="subtitle">
            Our pricing plans are structured to provide schools with scalable access,
            enhanced oversight, and the level of control required to manage sensitive
            matters responsibly and effectively.
        </p>

        <div class="plans">

            <!-- STARTER -->
            <div class="card">
                <div>
                    <h3>Starter Access</h3>
                    <div class="title-line"></div>

                    <div class="free">FREE</div>

                    <ul>
                        <li>Access for 1 authorised staff members.</li>
                        <li>Ability to log up to 5 incidents per term.</li>
                        <li>Basic case tracking using case numbers.</li>
                        <li>View-only dashboard for school leadership.</li>
                        <li>Access to basic user guides.</li>
                    </ul>

                    <div style="text-align:center; margin-top:10px;">
                        <a href="javascript:void(0);" onclick="openLimitations()"
                            style="color: var(--blue); font-size:14px; text-decoration: underline;">
                            view more
                        </a>
                    </div>
                </div> <a href="{{ route('admin.checkout', ['plan' => 'starter']) }}" class="btn"
                    style="{{ isset($subscription) && $subscription->plan === 'starter' && $subscription->isActive() ? 'background:var(--green);color:#000;' : '' }}">
                    {{ isset($subscription) && $subscription->plan === 'starter' && $subscription->isActive() ? 'CURRENT PLAN' : 'SELECT' }}
                </a>
            </div>


            <!-- ANNUAL -->
            <div class="card">

                <div class="best-value-header">
                    Best Value
                </div>

                <div>
                    <h3>Annual Plan</h3>
                    <div class="title-line"></div>

                    <div class="price">R5,000 <span>/year</span></div>
                    <div style="color: var(--blue); font-weight:700; margin-bottom:15px;">
                        R0 for 3 months
                    </div>

                    <ul>
                        <li>Save compared to monthly.</li>
                        <li>Full access to all features.</li>
                        <li>Priority support.</li>
                        <li>Ideal for schools & institutions.</li>
                    </ul>
                </div> <a href="{{ route('admin.checkout', ['plan' => 'annual']) }}" class="btn"
                    style="{{ isset($subscription) && $subscription->plan === 'annual' && $subscription->isActive() ? 'background:var(--green);color:#000;' : '' }}">
                    {{ isset($subscription) && $subscription->plan === 'annual' && $subscription->isActive() ? 'CURRENT PLAN' : 'SELECT' }}
                </a>
            </div>


            <!-- MONTHLY -->
            <div class="card">
                <div>
                    <h3>Monthly Plan</h3>
                    <div class="title-line"></div>

                    <div class="price">R450 <span>/month</span></div>
                    <div style="color: var(--blue); font-weight:700; margin-bottom:15px;">
                        R0 for 3 months
                    </div>

                    <ul>
                        <li>Flexible, pay as you go.</li>
                        <li>Cancel anytime.</li>
                        <li>Full platform access.</li>
                    </ul>
                </div> <a href="{{ route('admin.checkout', ['plan' => 'monthly']) }}" class="btn"
                    style="{{ isset($subscription) && $subscription->plan === 'monthly' && $subscription->isActive() ? 'background:var(--green);color:#000;' : '' }}">
                    {{ isset($subscription) && $subscription->plan === 'monthly' && $subscription->isActive() ? 'CURRENT PLAN' : 'SELECT' }}
                </a>
            </div>

        </div>

        <a href="{{ route('admin.dashboard') }}" class="dashboard-link">
            Go to dashboard
        </a>

    </div>

    <footer>
        © {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.
    </footer>

</body>

</html>
