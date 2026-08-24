<?php

namespace App\Http\Controllers;

use App\Models\Generation;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * User Member Dashboard.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Auto-generate API Token for Agency / Pro users if not set
        if (empty($user->api_token) && in_array($user->plan, ['agency', 'pro', 'lifetime', 'admin'])) {
            $user->generateApiToken();
        }

        $generations = Generation::where('user_id', $user->id)
            ->latest()
            ->take(15)
            ->get();

        $orders = Order::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('dashboard.index', [
            'user' => $user,
            'generations' => $generations,
            'orders' => $orders,
            'brandWorkspaces' => $user->brand_workspaces ?? [],
            'teamMembers' => $user->team_members ?? []
        ]);
    }

    /**
     * Generate or Rotate REST API Token.
     */
    public function generateApiToken(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->isAgency() && !$user->isPro()) {
            return back()->with('error', 'REST API Access is available on Pro Growth & Agency plans.');
        }

        $token = $user->generateApiToken();
        return back()->with('success', '✓ New REST API Key generated successfully! Keep it confidential.');
    }

    /**
     * Add Team Member Seat (5 Seats for Agency Plan).
     */
    public function addTeamMember(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->isAgency()) {
            return back()->with('error', '5 Team Member Seats are exclusive to the Agency & Scale Plan.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string|in:editor,creator,manager'
        ]);

        $team = $user->team_members ?? [];
        if (count($team) >= 5) {
            return back()->with('error', 'You have reached the maximum 5 team member seats included with the Agency Plan.');
        }

        // Add to team list
        $team[] = [
            'id' => uniqid('seat_'),
            'name' => $validated['name'],
            'email' => strtolower(trim($validated['email'])),
            'role' => $validated['role'],
            'added_at' => now()->format('M d, Y')
        ];

        $user->team_members = $team;
        $user->save();

        return back()->with('success', "🎉 Team seat for {$validated['name']} ({$validated['email']}) added successfully!");
    }

    /**
     * Remove Team Member.
     */
    public function removeTeamMember(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || !$user->isAgency()) {
            return back()->with('error', 'Unauthorized.');
        }

        $team = $user->team_members ?? [];
        $newTeam = array_values(array_filter($team, fn($m) => ($m['id'] ?? '') !== $id));

        $user->team_members = $newTeam;
        $user->save();

        return back()->with('success', '✓ Team member seat revoked.');
    }

    /**
     * Create / Add Client Brand Workspace.
     */
    public function saveBrandWorkspace(Request $request)
    {
        $user = Auth::user();
        if (!$user || (!$user->isAgency() && !$user->isPro())) {
            return back()->with('error', 'Client Brand Workspaces are available on Pro and Agency plans.');
        }

        $validated = $request->validate([
            'brand_name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'tone_guidelines' => 'required|string|max:1000'
        ]);

        $workspaces = $user->brand_workspaces ?? [];
        $workspaces[] = [
            'id' => uniqid('ws_'),
            'brand_name' => $validated['brand_name'],
            'industry' => $validated['industry'],
            'tone_guidelines' => $validated['tone_guidelines'],
            'created_at' => now()->format('M d, Y')
        ];

        $user->brand_workspaces = $workspaces;
        $user->save();

        return back()->with('success', "✓ Client Brand Workspace '{$validated['brand_name']}' created successfully!");
    }

    /**
     * Delete Client Brand Workspace.
     */
    public function deleteBrandWorkspace(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) return back();

        $workspaces = $user->brand_workspaces ?? [];
        $newWorkspaces = array_values(array_filter($workspaces, fn($ws) => ($ws['id'] ?? '') !== $id));

        $user->brand_workspaces = $newWorkspaces;
        $user->save();

        return back()->with('success', '✓ Brand Workspace removed.');
    }
}
