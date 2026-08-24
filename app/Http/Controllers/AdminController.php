<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\AffiliatePayout;
use App\Models\Blog;
use App\Models\Generation;
use App\Models\Order;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            function (Request $request, Closure $next) {
                if (!Auth::check() || !Auth::user()->isAdmin()) {
                    abort(403, 'Unauthorized access. Postryx Administrator role required.');
                }
                return $next($request);
            }
        ];
    }

    /**
     * Admin Overview Dashboard.
     */
    public function dashboard()
    {
        $totalRevenueINR = Order::where('status', 'completed')->where('currency', 'INR')->sum('amount');
        $totalRevenueUSD = Order::where('status', 'completed')->where('currency', 'USD')->sum('amount');
        
        $totalOrdersCount = Order::count();
        $completedOrdersCount = Order::where('status', 'completed')->count();
        
        $totalUsers = User::count();
        $paidSubscribers = User::whereIn('plan', ['starter', 'pro', 'agency', 'lifetime'])->count();

        $totalAffiliateCommissions = Affiliate::sum('total_earnings');
        $pendingAffiliatePayouts = AffiliatePayout::where('status', 'pending')->sum('amount');
        $totalPaidOut = Affiliate::sum('paid_payout');
        $totalGenerationsCount = Generation::count();
        $totalBlogsCount = Blog::count();

        $recentOrders = Order::with('user')->latest()->take(10)->get();
        $pendingPayoutRequests = AffiliatePayout::with('affiliate.user')->where('status', 'pending')->latest()->get();

        return view('admin.dashboard', [
            'totalRevenueINR' => $totalRevenueINR,
            'totalRevenueUSD' => $totalRevenueUSD,
            'totalOrdersCount' => $totalOrdersCount,
            'completedOrdersCount' => $completedOrdersCount,
            'totalUsers' => $totalUsers,
            'paidSubscribers' => $paidSubscribers,
            'totalAffiliateCommissions' => $totalAffiliateCommissions,
            'pendingAffiliatePayouts' => $pendingAffiliatePayouts,
            'totalPaidOut' => $totalPaidOut,
            'totalGenerationsCount' => $totalGenerationsCount,
            'totalBlogsCount' => $totalBlogsCount,
            'recentOrders' => $recentOrders,
            'pendingPayoutRequests' => $pendingPayoutRequests
        ]);
    }

    /**
     * Orders & Revenue Management.
     */
    public function orders()
    {
        $orders = Order::with('user', 'affiliate.user')->latest()->get();
        return view('admin.orders', ['orders' => $orders]);
    }

    /**
     * User Accounts Management.
     */
    public function users()
    {
        $users = User::with('affiliate')->withCount('generations', 'orders')->latest()->get();
        return view('admin.users', ['users' => $users]);
    }

    /**
     * Update User Plan & Role.
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'role' => 'required|in:user,admin',
            'plan' => 'required|in:free,starter,pro,agency,lifetime',
            'credits_remaining' => 'required|integer|min:0'
        ]);

        $user->role = $validated['role'];
        $user->plan = $validated['plan'];
        $user->credits_remaining = $validated['credits_remaining'];
        $user->save();

        return back()->with('success', "✓ User account for {$user->email} updated successfully!");
    }

    /**
     * Delete User Account.
     */
    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Cannot delete your own active administrator account.');
        }

        $email = $user->email;
        $user->delete();

        return back()->with('success', "✓ User account {$email} deleted successfully.");
    }

    /**
     * Affiliates Management.
     */
    public function affiliates()
    {
        $affiliates = Affiliate::with('user')->latest()->get();
        return view('admin.affiliates', ['affiliates' => $affiliates]);
    }

    /**
     * Payouts Management.
     */
    public function payouts()
    {
        $payouts = AffiliatePayout::with('affiliate.user')->latest()->get();
        return view('admin.payouts', ['payouts' => $payouts]);
    }

    /**
     * AI Generations Activity Stream.
     */
    public function generations()
    {
        $generations = Generation::with('user')->latest()->take(250)->get();
        return view('admin.generations', ['generations' => $generations]);
    }

    /**
     * ==========================================
     * BLOG MANAGEMENT (Admin CMS)
     * ==========================================
     */
    
    /**
     * List all blogs.
     */
    public function blogs()
    {
        $blogs = Blog::latest()->get();
        return view('admin.blogs.index', ['blogs' => $blogs]);
    }

    /**
     * Show Blog Creation Form.
     */
    public function createBlog()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store New Blog Article.
     */
    public function storeBlog(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'category' => 'required|string|max:100',
            'tags' => 'nullable|string|max:255',
            'author_name' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean'
        ]);

        // Auto-generate slug if empty
        $slug = !empty($validated['slug']) 
            ? Str::slug($validated['slug']) 
            : Str::slug($validated['title']);

        // Ensure unique slug
        $baseSlug = $slug;
        $counter = 1;
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        // Process Tags (convert comma-separated string to array)
        $tagsArray = [];
        if (!empty($validated['tags'])) {
            $tagsArray = array_values(array_filter(array_map('trim', explode(',', $validated['tags']))));
        }

        // Handle Image Upload to public/uploads/blogs
        $imagePath = $validated['image_url'] ?? 'images/postryx-hero-banner.png';
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/blogs');
            
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/blogs/' . $filename;
        }

        // Calculate read time
        $readTime = Blog::calculateReadTime($validated['content']);

        $blog = Blog::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'tags' => $tagsArray,
            'author_name' => $validated['author_name'] ?? (Auth::user()->name ?? 'Postryx AI Team'),
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'read_time' => $readTime,
            'meta_title' => $validated['meta_title'] ?? $validated['title'],
            'meta_description' => $validated['meta_description'] ?? ($validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160)),
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.blogs')->with('success', "🎉 Blog article '{$blog->title}' created successfully!");
    }

    /**
     * Edit Blog Article Form.
     */
    public function editBlog($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.edit', ['blog' => $blog]);
    }

    /**
     * Update Blog Article.
     */
    public function updateBlog(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => "required|string|max:255|unique:blogs,slug,{$id}",
            'category' => 'required|string|max:100',
            'tags' => 'nullable|string|max:255',
            'author_name' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean'
        ]);

        // Process Tags
        $tagsArray = [];
        if (!empty($validated['tags'])) {
            $tagsArray = array_values(array_filter(array_map('trim', explode(',', $validated['tags']))));
        }

        // Handle Image Replacement
        $imagePath = $blog->featured_image;
        if (!empty($validated['image_url'])) {
            $imagePath = $validated['image_url'];
        }
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/blogs');
            
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/blogs/' . $filename;
        }

        $readTime = Blog::calculateReadTime($validated['content']);

        $blog->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['slug']),
            'category' => $validated['category'],
            'tags' => $tagsArray,
            'author_name' => $validated['author_name'] ?? $blog->author_name,
            'excerpt' => $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160),
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'read_time' => $readTime,
            'meta_title' => $validated['meta_title'] ?? $validated['title'],
            'meta_description' => $validated['meta_description'] ?? $validated['excerpt'],
            'is_active' => $request->boolean('is_active')
        ]);

        return redirect()->route('admin.blogs')->with('success', "✓ Blog article '{$blog->title}' updated successfully!");
    }

    /**
     * 1-Click Toggle Blog Active / Inactive Status.
     */
    public function toggleBlogStatus($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->is_active = !$blog->is_active;
        $blog->save();

        $statusText = $blog->is_active ? 'ACTIVATED and is now Live' : 'DEACTIVATED (Saved as Draft)';
        return back()->with('success', "✓ Blog '{$blog->title}' {$statusText}!");
    }

    /**
     * Delete Blog Article.
     */
    public function deleteBlog($id)
    {
        $blog = Blog::findOrFail($id);
        
        // Remove uploaded image if stored locally
        if (!empty($blog->featured_image) && Str::startsWith($blog->featured_image, 'uploads/blogs/')) {
            $localPath = public_path($blog->featured_image);
            if (File::exists($localPath)) {
                File::delete($localPath);
            }
        }

        $title = $blog->title;
        $blog->delete();

        return back()->with('success', "✓ Blog article '{$title}' permanently deleted.");
    }

    /**
     * System Settings & Health.
     */
    public function settings()
    {
        $dbStatus = 'Connected (MySQL)';
        try {
            DB::connection()->getPdo();
        } catch (\Throwable $e) {
            $dbStatus = 'Connection Error: ' . $e->getMessage();
        }

        return view('admin.settings', [
            'dbStatus' => $dbStatus,
            'phpVersion' => phpversion(),
            'laravelVersion' => app()->version(),
            'serverSoftware' => $_SERVER['SERVER_SOFTWARE'] ?? 'WAMP64 Apache / PHP',
            'paypalClientId' => config('services.paypal.client_id', env('PAYPAL_CLIENT_ID')),
            'razorpayKey' => config('services.razorpay.key', env('RAZORPAY_KEY_ID', 'rzp_test_...')),
            'geminiKey' => !empty(env('GEMINI_API_KEY')) ? 'Configured (Active)' : 'Offline Heuristic Engine Mode'
        ]);
    }

    /**
     * Approve & Mark Payout as Paid.
     */
    public function processPayout(Request $request, $id)
    {
        $payout = AffiliatePayout::findOrFail($id);
        
        $validated = $request->validate([
            'transaction_ref' => 'required|string|max:255',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $payout->status = 'completed';
        $payout->transaction_ref = $validated['transaction_ref'];
        $payout->admin_notes = $validated['admin_notes'] ?? null;
        $payout->processed_at = now();
        $payout->save();

        // Increment paid balance on affiliate and decrement pending
        $affiliate = $payout->affiliate;
        if ($affiliate) {
            $affiliate->increment('paid_payout', $payout->amount);
            $affiliate->decrement('pending_payout', $payout->amount);
        }

        return back()->with('success', "✓ Payout of ₹{$payout->amount} marked as COMPLETED with Reference #{$payout->transaction_ref}!");
    }
}
