<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    /** List members */
    public function index()
    {
        // Swap to paginate if your list grows:
        // $members = Member::orderByDesc('id')->paginate(10);
        $members = Member::orderByDesc('id')->get();

        return view('Member.indexmember', compact('members'));
    }

    /** Show create form */
    public function create()
    {
        return view('Member.createmember'); 
    }

    /** Store new member */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email:rfc,dns', 'max:255', 'unique:members,email'],
            'phone'           => ['nullable', 'string', 'max:50'],
            'membership_type' => ['required', Rule::in(['standard', 'premium'])],
            'joined_date'     => ['required', 'date'],
            'expiry_date'     => ['nullable', 'date', 'after_or_equal:joined_date'],
        ]);

        Member::create($validated);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member created successfully.');
    }

    /** Show one member */
    public function show(Member $member)
    {
        return view('Member.showmember', compact('member'));
    }

    /** Show edit form */
    public function edit(Member $member)
    {
        return view('Member.editmember', compact('member'));
    }

    /** Update member */
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email:rfc,dns', 'max:255', Rule::unique('members', 'email')->ignore($member->id)],
            'phone'           => ['nullable', 'string', 'max:50'],
            'membership_type' => ['required', Rule::in(['standard', 'premium'])],
            'joined_date'     => ['required', 'date'],
            'expiry_date'     => ['nullable', 'date', 'after_or_equal:joined_date'],
        ]);

        $member->update($validated);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member updated successfully.');
    }

    /** Delete */
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()
            ->route('members.index')
            ->with('success', 'Member deleted successfully.');
    }
}