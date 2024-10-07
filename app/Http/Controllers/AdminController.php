<?php
namespace App\Http\Controllers;



use App\Models\Image;

use App\Models\PartnerMeta;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Permission;

use Illuminate\Validation\Rule;

use App\Models\TripBooking;

use App\Models\Trip;

class AdminController extends Controller

{

    public function index()

    {

        $admins = User::whereHas('roles', function ($role) {

            // $role->whereNotIn('name', '!=', 'admin');

            $role->whereIn('name', ['admin', 'sub_admin']);
        })->latest()->paginate(25);

        return view('admins.index', compact('admins'));
    }



    public function create()

    {

        return view('admins.create');
    }



    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users'),
            ],
            'password' => 'required|string|min:8|confirmed',
            'mobile' => 'required|string',
            'user_image' => 'nullable',
        ]);
    
        try {
            $user = new User([
                'title' => $request->title,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'mobile' => $request->mobile,
                'language' => 'en',
                'status' => 1,
            ]);
    
            $user->save();
    
            if ($user) {
                $user->syncRoles(['sub_admin']);
    
                if ($request->hasFile('user_image')) {
                    $userImage = new Image();
                    
                    $image = $request->file('user_image');
                    $name = uniqid() . '.' . strtolower($image->getClientOriginalExtension());
                    $public_path = public_path('storage/sliders');
                    $image->move($public_path, $name);
                    $image_url = asset('storage/sliders/' . $name);
                    
                    $userImage->url = $image_url;
                    $userImage->imageable_id = $user->id;
                    $userImage->imageable_type = 'App\Models\User';
                    $userImage->save();
                }
            }
    
            return redirect('admins')->with('success', 'Admin created');
        } catch (\Exception $e) {
            return redirect('admins')->with('error', 'Admin creation failed: ' . $e->getMessage());
        }
    }



    public function show($id)

    {

        $user = User::with('roles', 'permissions', 'image')->findOrFail($id);

        return view('admins.show', compact('user'));
    }



    public function edit($id)

    {

        $user = User::with(['roles', 'partnerMetas', 'image'])->findOrFail($id);

        return view('admins.edit', compact('user'));
    }



    public function update(Request $request, $id)
    {
        $user = User::withTrashed()->find($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'title' => 'integer',
            'mobile' => 'string',
            'user_image' => 'nullable',
        ];

        $request->validate($rules);

        try {
            if ($request->hasFile('user_image')) {
                $oldUserImage = $user->image;
                if ($oldUserImage) {
                    Storage::disk('public')->delete($oldUserImage->url);
                    $oldUserImage->delete();
                }

                $userImage = new Image();
                $image = $request->file('user_image');
                $name = uniqid() . '.' . strtolower($image->getClientOriginalExtension());
                $public_path = public_path('storage/sliders');
                $image->move($public_path, $name);
                $image_url = asset('storage/sliders/' . $name);

                $userImage->url = $image_url;
                $userImage->imageable_id = $user->id;
                $userImage->imageable_type = 'App\Models\User';
                $userImage->save();
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->title = $request->title;
            $user->mobile = $request->mobile;
            $user->save();

            return redirect('admins')->with('success', 'Admin Updated Successfully.');
        } catch (\Exception $e) {
            return redirect('admins')->with('error', 'Admin update failed: ' . $e->getMessage());
        }
    }



    public function userInactive($id)

    {

        $user = User::findOrFail($id);

        $user->status = 0;

        $user->save();

        return redirect('admins')->with('success', 'Admin Inactive Successfully.');
    }



    public function userActive($id)

    {

        $user = User::findOrFail($id);

        $user->status = 1;

        $user->save();

        return redirect('admins')->with('success', 'Admin Active Successfully.');
    }



    public function permissionView($id)

    {

        $permissions = Permission::get();
        
        $admin = User::with(['permissions'])->findOrFail($id);

        $user_permission_ids = [];

        foreach ($admin->permissions as $permission) {

            array_push($user_permission_ids, $permission->id);
        }

        return view('admins.permission', compact('admin', 'permissions', 'user_permission_ids'));
    }



    public function updatePermission(Request $request)

    {
        
        $this->validate($request, [

            'user_id' => 'required|exists:users,id',

            'permission_id' => 'required|array'

        ]);
        // dd($request->all());


        $admin = User::with(['permissions'])->findOrFail($request->user_id);
        $permissions = Permission::whereIn('id', $request->permission_id)->pluck('id')->toArray();
        // dd($permissions);
        if (count($permissions) !== count($request->permission_id)) {
            return redirect()->back()->withErrors('One or more permissions do not exist.');
        }

        $admin->syncPermissions($permissions);



        return redirect('admins')->with('success', 'Permission Updated');
    }

    public function referralsAll()
    {
        $users = User::whereHas('roles', function($role){
            $role->where('name', '=', 'partner');
        })->latest()->paginate(25);

        foreach($users as $user){
            if(!empty($user->referralcode)){
                $referralsUser = User::where('referralcodefrom', $user->referralcode)->get();
                $TotalCompleteTrip = 0;
                $TotalTrip = 0;
                $TotalReferralUser = 0;
                foreach ($referralsUser as $referralUser) {
                    $TotalCompleteTrip += $this->TotalCompleteTrip($referralUser->id);
                    $TotalTrip += $this->TotalTrip($referralUser->id);
                    $TotalReferralUser += 1;
                }
                $user->TotalCompleteTrip = $TotalCompleteTrip;
                $user->TotalTrip = $TotalTrip;
                $user->TotalReferralUser = $TotalReferralUser;

            } else {
                $user->TotalCompleteTrip = 0;
                $user->TotalTrip = 0;
                $user->TotalReferralUser = 0;
            }
        }
        return view('referrals.index', compact('users'));
    }

    public function TotalCompleteTrip($id)
    {
        $tripCount = TripBooking::where('partner_id', $id)->where('status', 4)->count();
        return $tripCount;
    }

    public function TotalTrip($id)
    {
        $tripCount = Trip::where('user_id', $id)->count();
        return $tripCount;
    }
}
