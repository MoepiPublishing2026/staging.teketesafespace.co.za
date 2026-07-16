<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Published Articles</title>
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
        .page-wrapper {
            max-width: 960px;
            width: 100%;
            margin: 0 auto;
        }
        .panel-card {
            background: #ffffff;
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
            border-left: 5px solid #c7da30;
        }
        .panel-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 24px;
        }
        .panel-header h2 {
            color: #0f172a;
            margin: 0 0 6px 0;
            font-size: 22px;
            font-weight: 600;
            letter-spacing: -0.025em;
        }
        .panel-header p {
            color: #64748b;
            font-size: 13.5px;
            margin: 0;
            line-height: 1.4;
        }
        .btn-primary {
            background-color: #c7da30;
            color: #ffffff;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 13.5px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.15s ease;
        }
        .btn-primary:hover {
            background-color: #b3c525;
        }
        .alert-success {
            background-color: #f0fdf4;
            color: #4d5410;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #bbf7d0;
            font-size: 13.5px;
            font-weight: 500;
        }
        .article-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .article-item {
            display: flex;
            gap: 16px;
            padding: 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #f8fafc;
            align-items: stretch;
        }
        .article-thumb {
            width: 96px;
            height: 96px;
            flex-shrink: 0;
            border-radius: 6px;
            overflow: hidden;
            background: #e2e8f0;
            border: 1px solid #e2e8f0;
        }
        .article-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .article-thumb-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 12px;
            text-align: center;
            padding: 8px;
        }
        .article-body {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .article-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px 12px;
            font-size: 12.5px;
            color: #64748b;
        }
        .article-category {
            display: inline-block;
            background: #eef5b8;
            color: #4d5410;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 12px;
        }
        .article-title {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
            line-height: 1.35;
            word-break: break-word;
        }
        .article-excerpt {
            margin: 0;
            font-size: 13px;
            color: #64748b;
            line-height: 1.45;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .article-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
            justify-content: center;
            flex-shrink: 0;
        }
        .btn-edit {
            background-color: #c7da30;
            color: #ffffff;
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 12.5px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.15s ease;
        }
        .btn-edit:hover {
            background-color: #b3c525;
            color: #ffffff;
        }
        .btn-delete {
            background-color: #ffffff;
            color: #dc2626;
            padding: 8px 14px;
            border: 1px solid #fecaca;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 12.5px;
            transition: background-color 0.15s ease, border-color 0.15s ease;
        }
        .btn-delete:hover {
            background-color: #fef2f2;
            border-color: #fca5a5;
        }
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #64748b;
            font-size: 14px;
        }
        @media (max-width: 640px) {
            .panel-card {
                padding: 20px;
            }
            .article-item {
                flex-direction: column;
            }
            .article-thumb {
                width: 100%;
                height: 160px;
            }
            .article-actions {
                flex-direction: row;
            }
            .btn-edit, .btn-delete {
                flex: 1;
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
            <div class="page-wrapper">

                @if(session('success'))
                    <div class="alert-success">
                        <strong>Success!</strong> {{ session('success') }}
                    </div>
                @endif

                <div class="panel-card">
                    <div class="panel-header">
                        <div>
                            <h2>Manage Published Articles</h2>
                            <p>Edit headlines, dates, body text, or cover images — or delete articles from the news feed.</p>
                        </div>
                        <a href="{{ route('admin.newsletter.create') }}" class="btn-primary">Upload New Article</a>
                        <form action="{{ route('newsletter.logout') }}" method="POST" style="display:inline; margin:0;">
                            @csrf
                            <button type="submit" class="btn-delete" style="border-color:#94a3b8; color:#475569;">Logout</button>
                        </form>
                    </div>

                    @if($newsletters->isEmpty())
                        <div class="empty-state">
                            <p>No articles published yet.</p>
                            <p style="margin-top: 8px;">
                                <a href="{{ route('admin.newsletter.create') }}" class="btn-primary">Publish your first article</a>
                            </p>
                        </div>
                    @else
                        <div class="article-list">
                            @foreach($newsletters as $item)
                                <div class="article-item">
                                    <div class="article-thumb">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                                        @else
                                            <div class="article-thumb-placeholder">No image</div>
                                        @endif
                                    </div>

                                    <div class="article-body">
                                        <div class="article-meta">
                                            <span class="article-category">{{ $item->category }}</span>
                                            <span>{{ \Carbon\Carbon::parse($item->publish_date)->format('d M Y') }}</span>
                                            @if($item->author)
                                                <span>By {{ $item->author }}</span>
                                            @endif
                                        </div>
                                        <h3 class="article-title">{{ $item->title }}</h3>
                                        <p class="article-excerpt">{{ $item->full_context }}</p>
                                    </div>

                                    <div class="article-actions">
                                        <a href="{{ route('admin.newsletter.edit', $item) }}" class="btn-edit">Edit</a>
                                        <form action="{{ route('admin.newsletter.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this article permanently? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" style="width: 100%;">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
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
        });
    </script>
</body>
</html>