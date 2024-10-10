<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserBio;
use Illuminate\Support\Facades\Storage;
use App\Models\PersonalityType;

class UserController extends Controller
{
    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->file('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $fileName = time() . '_' . $request->file('profile_photo')->getClientOriginalName();
            $filePath = $request->file('profile_photo')->storeAs('uploads/profile_photos', $fileName, 'public');

            $user->profile_photo = $filePath;
            $user->save();
        }

        return redirect()->route('profile.edit')->with('status', 'profile-photo-updated');
    }

    public function showBio()
    {
        $user = Auth::user(); // ดึงข้อมูลของผู้ใช้ที่ล็อกอินอยู่
        $bio = $user->bio; // ดึงข้อมูล Bio ที่เชื่อมโยงกับผู้ใช้
        return view('profile.show-bio', compact('user', 'bio')); // ส่งข้อมูลผู้ใช้และ Bio ไปยัง View
    }

    public function updateBio(Request $request)
    {
        $user = Auth::user(); // ดึงข้อมูลผู้ใช้ที่ล็อกอินอยู่
        $bio = $user->bio; // ดึงข้อมูล Bio ของผู้ใช้

        // ตรวจสอบว่า ฟิลด์ 'bio' ต้องเป็นข้อความและต้องกรอกข้อมูล
        $request->validate([
            'bio' => 'required|string',
        ]);

        if ($bio) {
            // ถ้าผู้ใช้มี Bio อยู่แล้ว ทำการอัปเดต Bio ด้วยข้อมูลใหม่
            $bio->update([
                'bio' => $request->input('bio'),
            ]);
        } else {
            // ถ้าผู้ใช้ยังไม่มี Bio ให้สร้าง Bio ใหม่และเชื่อมโยงกับผู้ใช้
            $user->bio()->create([
                'bio' => $request->input('bio'),
            ]);
        }

        // หลังจากอัปเดตหรือสร้าง Bio เสร็จ จะรีไดเร็กต์กลับไปที่หน้าแสดง Bio
        return redirect()->route('profile.show-bio')
            ->with('status', 'Bio updated successfully!');
    }


    /////ไม่แน่ใจ
    public function show()
    {
        $user = Auth::user()->load('personalityType');
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        $personalityTypes = PersonalityType::all(); // Retrieve all personality types
        return view('profile.edit', compact('user', 'personalityTypes'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'personality_type' => 'nullable|exists:personality_types,id',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'personality_type_id' => $request->input('personality_type'),
        ]);

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }


}