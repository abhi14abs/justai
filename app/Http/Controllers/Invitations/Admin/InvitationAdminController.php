<?php

namespace App\Http\Controllers\Invitations\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationCategory;
use App\Models\Invitations\InvitationCoupon;
use App\Models\Invitations\InvitationFeature;
use App\Models\Invitations\InvitationFormResponse;
use App\Models\Invitations\InvitationGuest;
use App\Models\Invitations\InvitationOrder;
use App\Models\Invitations\InvitationTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvitationAdminController extends Controller
{
    /**
     * Admin Overview & Metrics.
     */
    public function dashboard()
    {
        $metrics = [
            'total_invitations' => Invitation::count(),
            'published_invitations' => Invitation::where('status', 'published')->count(),
            'total_templates' => InvitationTemplate::count(),
            'total_categories' => InvitationCategory::count(),
            'total_orders' => InvitationOrder::count(),
            'total_revenue' => InvitationOrder::where('status', 'completed')->sum('final_amount'),
            'total_rsvps' => InvitationFormResponse::count(),
            'total_guests' => InvitationGuest::count(),
        ];

        $recentInvitations = Invitation::with(['user', 'template'])
            ->withCount('formResponses')
            ->latest()
            ->take(8)
            ->get();

        $recentOrders = InvitationOrder::with(['user', 'template'])
            ->latest()
            ->take(8)
            ->get();

        return view('admin.invitations.dashboard', [
            'metrics' => $metrics,
            'recentInvitations' => $recentInvitations,
            'recentOrders' => $recentOrders,
        ]);
    }

    /**
     * Manage Categories.
     */
    public function categories()
    {
        $categories = InvitationCategory::withCount('templates')
            ->orderBy('sort_order')
            ->get();

        return view('admin.invitations.categories', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store Category.
     */
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:invitation_categories,slug',
            'icon' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        InvitationCategory::create($validated);

        return back()->with('success', 'Category created successfully.');
    }

    /**
     * Manage Templates.
     */
    public function templates()
    {
        $templates = InvitationTemplate::with(['category', 'subcategory'])
            ->withCount('invitations')
            ->latest()
            ->paginate(20);

        $categories = InvitationCategory::where('is_active', true)->get();

        return view('admin.invitations.templates', [
            'templates' => $templates,
            'categories' => $categories,
        ]);
    }

    /**
     * Store Template.
     */
    public function storeTemplate(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:invitation_categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:invitation_templates,slug',
            'description' => 'nullable|string',
            'thumbnail_url' => 'nullable|string|max:1000',
            'is_premium' => 'nullable|boolean',
            'base_price_inr' => 'nullable|numeric',
            'base_price_usd' => 'nullable|numeric',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $template = InvitationTemplate::create($validated);

        return back()->with('success', 'Template created successfully.');
    }

    /**
     * Manage Features & Pricing.
     */
    public function features()
    {
        $features = InvitationFeature::with('prices')->orderBy('sort_order')->get();
        return view('admin.invitations.features', ['features' => $features]);
    }

    /**
     * Manage Invitation Orders.
     */
    public function orders()
    {
        $orders = InvitationOrder::with(['user', 'template', 'invitation'])
            ->latest()
            ->paginate(25);

        return view('admin.invitations.orders', ['orders' => $orders]);
    }

    /**
     * Manage RSVP Submissions Across All Invites.
     */
    public function rsvpSubmissions()
    {
        $submissions = InvitationFormResponse::with(['invitation', 'form'])
            ->latest('submitted_at')
            ->paginate(30);

        return view('admin.invitations.submissions', ['submissions' => $submissions]);
    }

    /**
     * Manage Coupons.
     */
    public function coupons()
    {
        $coupons = InvitationCoupon::latest()->paginate(25);
        return view('admin.invitations.coupons', ['coupons' => $coupons]);
    }
}
