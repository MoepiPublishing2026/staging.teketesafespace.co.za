<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Published Article</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
            color: #1e293b;
        }
        .form-card-wrapper {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
        }
        .form-card {
            background: #ffffff;
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
            border-left: 5px solid #c7da30;
        }
        .form-header {
            margin-bottom: 20px;
        }
        .form-header h2 {
            color: #0f172a;
            margin: 0 0 6px 0;
            font-size: 22px;
            font-weight: 600;
            letter-spacing: -0.025em;
        }
        .form-header p {
            color: #64748b;
            font-size: 13.5px;
            margin: 0;
            line-height: 1.4;
        }
        .form-nav {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }
        .form-nav a {
            font-size: 13px;
            font-weight: 600;
            color: #4d5410;
            text-decoration: none;
        }
        .form-nav a:hover {
            text-decoration: underline;
        }
        .form-group {
            margin-bottom: 18px;
        }
        label {
            display: block;
            font-weight: 500;
            margin-bottom: 6px;
            color: #334155;
            font-size: 13.5px;
        }
        input[type="text"], input[type="date"], input[type="file"], select, textarea {
            width: 100%;
            padding: 12px 16px !important;
            text-indent: 4px;
            border: 1px solid #c7da30;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
            color: #0f172a;
            background-color: #ffffff;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        input[type="file"] {
            padding: 10px 14px !important;
            text-indent: 0px;
            cursor: pointer;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #b3c525;
            box-shadow: 0 0 0 3px rgba(199, 218, 48, 0.25);
        }
        textarea {
            height: 150px;
            padding: 14px 18px !important;
            text-indent: 0;
            resize: vertical;
            font-family: inherit;
            line-height: 1.5;
        }
        .grid-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 18px;
        }
        .btn-submit {
            background-color: #c7da30;
            color: #ffffff;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            font-size: 13.5px;
            transition: background-color 0.15s ease;
            margin-top: 4px;
        }
        .btn-submit:hover {
            background-color: #b3c525;
        }
        .btn-delete {
            background-color: #ffffff;
            color: #dc2626;
            padding: 12px 20px;
            border: 1px solid #fecaca;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            font-size: 13.5px;
            transition: background-color 0.15s ease;
            margin-top: 10px;
        }
        .btn-delete:hover {
            background-color: #fef2f2;
        }
        .error-text {
            color: #dc2626;
            font-size: 12.5px;
            margin-top: 5px;
        }
        .preview-wrapper {
            margin-top: 10px;
            max-width: fit-content;
            border-radius: 6px;
            overflow: hidden;
            border: 1px dashed #c7da30;
            background: #f8fafc;
            padding: 6px;
        }
        .preview-wrapper img {
            display: block;
            max-height: 100px;
            max-width: 130px;
            width: auto;
            height: auto;
            border-radius: 4px;
            object-fit: cover;
        }
        .help-text {
            color: #64748b;
            font-size: 12px;
            margin-top: 6px;
        }
        @media (max-width: 640px) {
            .grid-row {
                grid-template-columns: 1fr;
                gap: 18px;
            }
            .form-card {
                padding: 20px;
            }
        }
    </style>
</head>

<body class="bg-white font-[Inter]">

    <div class="min-h-screen bg-white flex flex-col w-full overflow-x-hidden">

        <header style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ffffff; z-index: 150; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
            <div class="flex flex-row justify-between items-center px-8 py-2" style="max-width: 1280px; margin: 0 auto;">

                <div>
                    <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="w-[143px] h-auto flex-shrink-0">
                </div>

                <div style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    <div class="hidden md:flex gap-8">
                        <a href="javascript:void(0);" onclick="window.history.back();" class="transition-colors hover:text-[#c7da30]" style="color: black; text-decoration: none;">
                            Back
                        </a>
                        <a href="{{ route('landing-page') }}" class="transition-colors hover:text-[#c7da30]" style="color: black; text-decoration: none;">
                            Home
                        </a>
                        <a href="{{ route('about-us') }}" class="transition-colors hover:text-[#c7da30]" style="color: black; text-decoration: none;">
                            About Us
                        </a>
                        <a href="{{ route('contact-us') }}" class="transition-colors hover:text-[#c7da30]" style="color: black; text-decoration: none;">
                            Contact Us
                        </a>
                        <a href="{{ route('news') }}" class="transition-colors hover:text-[#c7da30]" style="color: black; text-decoration: none;">News</a>
                    </div>

                    <div class="md:hidden flex items-center relative z-[160]">
                        <button id="mobile-menu-button" type="button" class="p-2 rounded-md text-black hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30] cursor-pointer">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div id="mobile-menu" class="fixed top-0 right-0 h-full w-[280px] bg-white shadow-2xl z-[200] transform translate-x-full transition-transform duration-300 ease-in-out p-6 flex flex-col gap-6 border-l border-gray-100">
                <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                    <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="w-[110px] h-auto">
                    <button id="mobile-menu-close" type="button" class="text-gray-500 hover:text-black focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav class="flex flex-col gap-5 text-[16px] font-medium" style="font-family: 'Montserrat', sans-serif;">
                    <a href="javascript:void(0);" onclick="window.history.back();" class="text-black hover:text-[#c7da30] transition-colors" style="text-decoration: none;">Back</a>
                    <a href="{{ route('landing-page') }}" class="text-black hover:text-[#c7da30] transition-colors" style="text-decoration: none;">Home</a>
                    <a href="{{ route('about-us') }}" class="text-black hover:text-[#c7da30] transition-colors" style="text-decoration: none;">About Us</a>
                    <a href="{{ route('contact-us') }}" class="text-black hover:text-[#c7da30] transition-colors" style="text-decoration: none;">Contact Us</a>
                    <a href="{{ route('news') }}" class="text-black hover:text-[#c7da30] transition-colors" style="text-decoration: none">News</a>
                </nav>
            </div>

            <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/40 z-[190] hidden transition-opacity duration-300"></div>
        </header>

        <div class="w-full flex-grow bg-white pt-24 pb-12 px-4">
            <div class="form-card-wrapper">

                <div class="form-nav">
                    <a href="{{ route('admin.newsletter.index') }}">&larr; Back to published articles</a>
                    <a href="{{ route('admin.newsletter.create') }}">Upload new article</a>
                </div>

                <div class="form-card">
                    <div class="form-header">
                        <h2>Edit Published Article</h2>
                        <p>Update the date, headline, body, author, category, or cover image. Changes appear on the public news feed immediately.</p>
                    </div>

                    <form action="{{ route('admin.newsletter.update', $newsletter) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">Newsletter / Article Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $newsletter->title) }}" required>
                            @error('title') <p class="error-text">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid-row">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label for="category">Display Category</label>
                                <select id="category" name="category" required>
                                    @php $currentCategory = old('category', $newsletter->category); @endphp
                                    <option value="News" {{ $currentCategory === 'News' ? 'selected' : '' }}>News</option>
                                    <option value="Press Release" {{ $currentCategory === 'Press Release' ? 'selected' : '' }}>Press Release</option>
                                    <option value="Article" {{ $currentCategory === 'Article' ? 'selected' : '' }}>Article</option>
                                    <option value="Event" {{ $currentCategory === 'Event' ? 'selected' : '' }}>Event</option>
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 0;">
                                <label for="publish_date">Publish Date</label>
                                <input type="date" id="publish_date" name="publish_date" required value="{{ old('publish_date', \Carbon\Carbon::parse($newsletter->publish_date)->format('Y-m-d')) }}">
                                @error('publish_date') <p class="error-text">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="author" id="authorLabel">Author Byline</label>
                            <input type="text" id="author" name="author" value="{{ old('author', $newsletter->author) }}">
                            @error('author') <p class="error-text">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Featured Cover Image</label>
                            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                            <p class="help-text">Leave empty to keep the current image. Upload a new file to replace it.</p>
                            @error('image') <p class="error-text">{{ $message }}</p> @enderror

                            <div class="preview-wrapper" id="imagePreviewContainer" @if(!$newsletter->image) style="display: none;" @endif>
                                <img id="imagePreview" src="{{ $newsletter->image ? asset('storage/' . $newsletter->image) : '#' }}" alt="Image Preview Layout">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="full_context">"Read More" Extended Body Text</label>
                            <textarea id="full_context" name="full_context" required>{{ old('full_context', $newsletter->full_context) }}</textarea>
                            @error('full_context') <p class="error-text">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="btn-submit">
                            Save Changes
                        </button>
                    </form>

                    <form action="{{ route('admin.newsletter.destroy', $newsletter) }}" method="POST" onsubmit="return confirm('Delete this article permanently? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Delete Article</button>
                    </form>
                </div>

            </div>
        </div>

        <footer class="mt-auto" style="width: 100%; background-color: #808080; color: white; padding: 1.5rem 0;">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-6"
                style="max-width: 1280px; margin: 0 auto; font-family: 'Montserrat', sans-serif; font-size: 16px;">
                <div>
                    <p>&copy; {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank">
                        <img src="{{ asset('images/youtube.png') }}" alt="YouTube Icon" style="width: 30px; height: 30px;">
                    </a>
                    <a href="https://www.X.com/moepipublishing" target="_blank">
                        <img src="{{ asset('images/X.png') }}" alt="X Icon" style="width: 30px; height: 30px;">
                    </a>
                    <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                        <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn Icon" style="width: 30px; height: 30px;">
                    </a>
                    <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                        <img src="{{ asset('images/facebook.png') }}" alt="Facebook Icon" style="width: 35.2px; height: 30px;">
                    </a>
                    <a href="https://www.instagram.com/moepipublishing" target="_blank">
                        <img src="{{ asset('images/instagram.png') }}" alt="Instagram Icon" style="width: 35.2px; height: 30px;">
                    </a>
                    <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                        <img src="{{ asset('images/tiktok.png') }}" alt="TikTok Icon" style="width: 35.2px; height: 30px;">
                    </a>
                </div>
            </div>
        </footer>
    </div>

    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const overlay = document.getElementById('mobile-menu-overlay');
            if (!mobileMenu || !overlay) return;

            const isOpen = mobileMenu.classList.contains('translate-x-0');

            if (!isOpen) {
                mobileMenu.classList.remove('translate-x-full');
                mobileMenu.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                mobileMenu.classList.remove('translate-x-0');
                mobileMenu.classList.add('translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const closeMenuButton = document.getElementById('mobile-menu-close');
            const overlay = document.getElementById('mobile-menu-overlay');

            if (mobileMenuButton) mobileMenuButton.addEventListener('click', toggleMobileMenu);
            if (closeMenuButton) closeMenuButton.addEventListener('click', toggleMobileMenu);
            if (overlay) overlay.addEventListener('click', toggleMobileMenu);

            const categorySelect = document.getElementById('category');
            const authorInput = document.getElementById('author');
            const authorLabel = document.getElementById('authorLabel');

            function checkAuthorStatus() {
                if (categorySelect.value === 'Press Release') {
                    authorInput.value = '';
                    authorInput.disabled = true;
                    authorInput.removeAttribute('required');
                    authorLabel.innerHTML = 'Author Byline <span style="color: #64748b; font-size: 12px; font-weight: normal;">(Not applicable for Press Releases)</span>';
                } else {
                    authorInput.disabled = false;
                    authorInput.setAttribute('required', 'required');
                    authorLabel.innerHTML = 'Author Byline';
                }
            }

            if (categorySelect && authorInput) {
                categorySelect.addEventListener('change', checkAuthorStatus);
                checkAuthorStatus();
            }
        });

        function previewImage(event) {
            const input = event.target;
            const container = document.getElementById('imagePreviewContainer');
            const preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>