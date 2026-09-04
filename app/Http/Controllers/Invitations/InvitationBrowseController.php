<?php

namespace App\Http\Controllers\Invitations;

use App\Http\Controllers\Controller;
use App\Models\Invitations\InvitationCategory;
use App\Models\Invitations\InvitationTemplate;
use Illuminate\Http\Request;

class InvitationBrowseController extends Controller
{
    /**
     * Browse Marketplace & Curated Templates.
     */
    public function index(Request $request)
    {
        $categories = InvitationCategory::where('is_active', true)
            ->with(['subcategories' => function ($q) {
                $q->where('is_active', true);
            }])
            ->orderBy('sort_order')
            ->get();

        $selectedCategorySlug = $request->query('category');
        $selectedSubcategorySlug = $request->query('subcategory');
        $searchQuery = $request->query('q');
        $filterType = $request->query('type'); // all, free, premium

        $templatesQuery = InvitationTemplate::where('is_active', true)
            ->with(['category', 'subcategory']);

        if (!empty($selectedCategorySlug)) {
            $templatesQuery->whereHas('category', function ($q) use ($selectedCategorySlug) {
                $q->where('slug', $selectedCategorySlug);
            });
        }

        if (!empty($selectedSubcategorySlug)) {
            $templatesQuery->whereHas('subcategory', function ($q) use ($selectedSubcategorySlug) {
                $q->where('slug', $selectedSubcategorySlug);
            });
        }

        if (!empty($searchQuery)) {
            $templatesQuery->where(function ($q) use ($searchQuery) {
                $q->where('name', 'like', "%{$searchQuery}%")
                  ->orWhere('description', 'like', "%{$searchQuery}%");
            });
        }

        if ($filterType === 'free') {
            $templatesQuery->where('is_premium', false);
        } elseif ($filterType === 'premium') {
            $templatesQuery->where('is_premium', true);
        }

        $templates = $templatesQuery->orderByDesc('is_featured')
            ->orderByDesc('use_count')
            ->paginate(24)
            ->withQueryString();

        return view('invitations.browse.index', [
            'categories' => $categories,
            'templates' => $templates,
            'selectedCategory' => $selectedCategorySlug,
            'selectedSubcategory' => $selectedSubcategorySlug,
            'searchQuery' => $searchQuery,
            'filterType' => $filterType,
        ]);
    }

    /**
     * Category-specific template showcase.
     */
    public function category(string $slug)
    {
        $category = InvitationCategory::where('slug', $slug)
            ->where('is_active', true)
            ->with(['subcategories', 'activeTemplates.subcategory'])
            ->firstOrFail();

        return view('invitations.browse.category', [
            'category' => $category,
            'templates' => $category->activeTemplates,
        ]);
    }

    /**
     * Interactive Live Demo Preview of a Template.
     */
    public function preview(string $slug)
    {
        $template = InvitationTemplate::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'subcategory', 'sections'])
            ->firstOrFail();

        $template->increment('view_count');

        // Look up authentic seeded sample invitation for this template
        $sampleInvite = \App\Models\Invitations\Invitation::where('template_id', $template->id)
            ->where('status', 'published')
            ->first();

        if (!$sampleInvite) {
            $sampleInvite = \App\Models\Invitations\Invitation::where('template_id', $template->id)->first();
        }

        return view('invitations.browse.preview', [
            'template' => $template,
            'sampleInvitation' => $sampleInvite,
        ]);
    }
}
