<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequently Asked Questions</title>

    <style>
        :root {
            --green: #b7d531;
            --blue: #38b6ff;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f4f4;
        }

        .faq-container {
            max-width: 1000px;
            margin: 80px auto;
            background: white;
            border-radius: 25px;
            padding: 50px;
            border: 3px solid var(--green);
        }

        .faq-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .faq-item {
            border-bottom: 1px solid #e5e5e5;
            padding: 18px 0;
            cursor: pointer;
        }

        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            font-size: 15px;
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, margin 0.3s ease;
            margin-top: 0;
            font-size: 14px;
            line-height: 1.7;
            color: #555;
        }

        .faq-item.active .faq-answer {
            max-height: 300px;
            margin-top: 12px;
        }

        .faq-icon {
            font-size: 14px;
            transition: transform 0.3s ease;
        }

        .faq-item.active .faq-icon {
            transform: rotate(90deg);
        }

        .back-btn {
    /* Apply same styling as .btn */
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

.back-btn:hover {
    background: var(--green);
    color: black;
}
    </style>
</head>
<body>

<div class="faq-container">
    <div class="faq-title">Frequently asked questions</div>

    <div class="faq-item">
        <div class="faq-question">
            <span>1.Who can subscribe?</span>
            <span class="faq-icon">></span>
        </div>
        <div class="faq-answer">
            Tekete Safe Space is available to public and private primary and secondary schools.
            Subscriptions are usually taken up by school management, principals, or School Governing Bodies (SGBs)
            on behalf of the school.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question">
            <span>2.Can we switch from monthly to annual?</span>
            <span class="faq-icon">></span>
        </div>
        <div class="faq-answer">
            Yes. Schools may switch from a monthly subscription to an annual plan at any time.
            The annual plan offers better value and long-term cost savings.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question">
            <span>3.Is our data secure?</span>
            <span class="faq-icon">></span>
        </div>
        <div class="faq-answer">
            Yes. Data security and confidentiality are a top priority.
            All reports and case information are securely stored and only accessible to authorised users, ensuring
            learner and staff information remains protected at all times.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question">
            <span>4.How does the free 3-month trial work?</span>
            <span class="faq-icon">></span>
        </div>
        <div class="faq-answer">
            Selected schools receive full access to Tekete Safe Space for three months at no cost.
            During the trial, schools can use all features, log and track cases, and receive support to fully
            experience the platform before committing to a subscription.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question">
            <span>5.Is training provided?</span>
            <span class="faq-icon">></span>
        </div>
        <div class="faq-answer">
            Yes. Training and onboarding support are provided to ensure staff understand how to use the platform
            effectively. This includes guided demonstrations, webinars, and user support materials.
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question">
            <span>6.Can multiple staff members access the platform?</span>
            <span class="faq-icon">></span>
        </div>
        <div class="faq-answer">
            Yes. Multiple authorised staff members can access Tekete Safe Space. Different access levels can
            be assigned based on roles, ensuring appropriate and secure use across the school.
        </div>
    </div>

    <a href="{{ route('admin.subscribe') }}" class="back-btn">
        ← Back
    </a>
</div>

<script>
document.querySelectorAll('.faq-item').forEach(item => {
    item.addEventListener('click', () => {

        // Close other open questions
        document.querySelectorAll('.faq-item').forEach(i => {
            if(i !== item) i.classList.remove('active');
        });

        item.classList.toggle('active');
    });
});
</script>

</body>
</html>