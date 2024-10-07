<?php
namespace app\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\PartnerPaymentMethod;
use App\Models\Image;
use App\Models\PartnerMeta;
use Spatie\Permission\Models\Role;
use Hash;
use Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Lang;
use Illuminate\Validation\Rule;
use App\Models\TripBooking;

class UsersController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function adminAdd(Request $request)
    {
        $request->validate([
            'title'           => 'required|string',
            'name'            => 'required|string',
            'email'           => 'required|string|email|unique:users',
            'password'        => 'required|string|confirmed',
            'mobile'          => 'required',
        ]);
        $user = new User([
            'title'           => $request->title,
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'mobile'          => $request->mobile,
            'language'        => "en",
            'status'          => 1,
        ]);

        $user->save();
        if($user){
            $user->syncRoles(['admin']);
            if($request->hasFile('user_image')){
                $userImage = new Image;
                $user_image = $request->file('user_image');
                $name = uniqid().'.'.strtolower($user_image->getClientOriginalExtension());
                $path = $user_image->storeAs(
                    'users', $name, 'public'
                );
                $userImage->url = $path;
                $userImage->imageable_id = $user->id;
                $userImage->imageable_type = 'App\Models\User';
                $user->image()->save($userImage);
            }

        }

        return redirect('users')->with('success', trans('users-ts.admin_add'));
    }

    public function changePassword(Request $request){
        $this->validate($request,[
            'old_password'      => ['required', 'string', 'min:8'],
            'new_password'      => ['required', 'string', 'min:8'],
            'confirm_password'  => ['required', 'string', 'min:8'],
        ]);

        $old_password       = $request->old_password;
        $new_password       = $request->new_password;
        $confirm_password   = $request->confirm_password;


        if($new_password == $confirm_password){
            $current_password = Auth::user()->password;
            if(Hash::check($old_password, $current_password))
            {
                $id             = Auth::user()->id;
                $user           = User::findOrFail($id);
                $user->password = Hash::make($new_password);
                $user->save();
                return redirect('/change-password')->with('success', trans('users-ts.pass_update'));
            }
        }else{
            return redirect('/change-password')->with('success', trans('users-ts.pass_confirm'));
        }
    }

    public function userSignup(Request $request)
    {
    	$request->validate([
			'title'    => 'required|string',
			'name'     => 'required|string',
			'email'    => 'required|string|email|unique:users',
			'password' => 'required|string|confirmed',
			'mobile'   => 'required',
	    ]);

	    $user = new User([
	        'title'           => $request->title,
	        'name'            => $request->name,
	        'email'           => $request->email,
	        'password'        => Hash::make($request->password),
	        'mobile'          => $request->mobile,
	       // 'identity_type'   => $request->identity_type,
	       // 'identity_number' => $request->identity_number,
	        'language'        => "en",
	        'status'          => 1,
	    ]);

	    $user->save();

	    if($user){
            $user->syncRoles(['user']);
            // if($request->hasFile('user_image')){
            //     $userImage = new Image;
            //     $user_image = $request->file('user_image');
            //     $name = uniqid().'.'.strtolower($user_image->getClientOriginalExtension());
            //     $path = $user_image->storeAs(
            //         'users', $name, 'public'
            //     );
            //     $userImage->url = $path;
            //     $userImage->imageable_id = $user->id;
            //     $userImage->imageable_type = 'App\Models\User';
            //     $user->image()->save($userImage);
            // }
        }

	    return redirect()->back()->with('success', trans('users-ts.registration'));
    }

    public function partnerSignup(Request $request)
    {
        $this->validate($request, [
            'title'                   => 'required|string',
			'name'                    => 'required|string',
            'nickname'                => 'required|string|unique:partner_metas,nickname',
			'email'                   => 'required|string|email|unique:users',
			'password'                => 'required|string|confirmed',
			'mobile'                  => 'required',
			'identity_type'           => 'required',
			'identity_number'         => 'required',
			'address'                 => 'required',
			//'license_number'          => 'required',
			//'license_file'            => 'required|mimes:jpeg,bmp,png,pdf',
            'date_of_birth_hijri'     => 'required|date',
            'date_of_birth_gregorian' => 'required|date',
	    ]);	
	    $referralcodefrom = '';
        $referralcode = '';

        if(isset($request->referral_code) && !empty($request->referral_code)){
            $referralcodefrom = $request->referral_code;
            $referralcode = $this->generateReferralCode();
        }else{
            $referralcode = $this->generateReferralCode();
        }

	    $user = new User([
	        'title'           => $request->title,
	        'name'            => $request->name,
	        'email'           => $request->email,
	        'password'        => Hash::make($request->password),
	        'mobile'          => '+966' . $request->mobile,
	        'identity_type'   => $request->identity_type,
	        'identity_number' => $request->identity_number,
	        'language'        => "en",
	        'status'          => 1,
	        'referralcode'    => $referralcode,
	        'referralcodefrom'=> $referralcodefrom,
	    ]);
	    $user->save();
            // echo "<pre>"; print_r($user); die("========");
	    if($user){
	    	if($request->hasFile('license_file')){
        		$license_file = $request->file('license_file');
        		$name = uniqid().'.'.strtolower($license_file->getClientOriginalExtension());
        		$path = $license_file->storeAs(
                    'license-file', $name, 'public'
                );
        	}else{
        		$path = null;
        	}
	    	$partner                 = new PartnerMeta;
	    	$partner->user_id        = $user->id;
            $partner->nickname       = $request->nickname;
            $partner->brand_name     = $request->nickname;
            $partner->date_of_birth_hijri  = $request->date_of_birth_hijri;
            $partner->date_of_birth_gregorian  = $request->date_of_birth_gregorian;
	    	$partner->address        = $request->address;
	    	$partner->license_number = $request->license_number;
	    	$partner->license_file   = $path;

            // if(isset($request->date_of_birth_hijri) && $request->date_of_birth_hijri != null){
            //     $partner->date_of_birth_hijri = Carbon::parse($request->date_of_birth_hijri)->format('Y/m/d');
            // }

            // if(isset($request->date_of_birth_gregorian) && $request->date_of_birth_gregorian != null){
            //     $partner->date_of_birth_gregorian = Carbon::parse($request->date_of_birth_gregorian)->format('Y/m/d');
            // }

	    	$partner->license_file   = $path;
	    	$partner->save();

            $user->syncRoles(['partner']);

            if($request->hasFile('user_image')){
                $userImage = new Image;
                $user_image = $request->file('user_image');

                $name = uniqid().'.'.strtolower($user_image->getClientOriginalExtension());
                $public_path = public_path('storage/users');
                $user_image->move($public_path, $name);
                $image_url = asset('storage/users/' . $name);

                $userImage->url = $image_url;
                $userImage->imageable_id = $user->id;
                $userImage->imageable_type = 'App\Models\User';
                $user->image()->save($userImage);

        	}
        }

        return redirect()->back()->with('success', trans('users-ts.registration'));
    }
    public function generateReferralCode(){
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $referralCode = '';
        $charactersLength = strlen($characters);
        for ($i = 0; $i < $length; $i++) {
            $referralCode .= $characters[rand(0, $charactersLength - 1)];
        }
        
        return $referralCode;
    }
    public function index($type)
    {

        if($type == 'user'){
            $users = User::whereHas('roles', function($role){
                // $role->where('name', '!=', 'admin');
                $role->where('name', '=', 'user');
            })->latest()->paginate(25);
        }else{
            $users = User::whereHas('roles', function($role){
                // $role->where('name', '!=', 'admin');
                $role->where('name', '=', 'partner');
            })->latest()->paginate(25);
        }
    	
    	return view('users.index', compact('users','type'));
    }

    public function edit($id)
    {
    	$user = User::with('partnerMetas', 'image')->findOrFail($id);
    	return view('users.edit', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $deleted = User::where('id', $id)->forceDelete();
        // User::destroy($id);
        if($user && $user->hasrole('partner')){
            return redirect('users/partner')->with('success', 'Partner deleted');
        }else{
            return redirect('users/user')->with('success', 'User deleted');
        }
    }

    public function show($id)
    {
    	$user = User::with('partnerMetas', 'image')->findOrFail($id);
        $payment_method = PartnerPaymentMethod::where("user_id",$id)->get();
    	return view('users.show', compact('user','payment_method'));
    }

    public function referralShow($id)
    {
        $user = User::with('partnerMetas', 'image')->findOrFail($id);
        if(!empty($user->referralcode)){
            $referralsUser = User::where('referralcodefrom', $user->referralcode)->where('referralcodefrom', $user->referralcode)->get();
            foreach ($referralsUser as $key => $value) {
                $referralsUser[$key]->TotalTrip = $this->TotalCompleteTrip($value->id);
            }
        }else{
            $referralsUser = [];
        }

    	return view('users.referralShow', compact('user','referralsUser'));
    }

    public function TotalCompleteTrip($id)
    {
        $tripCount = TripBooking::where('partner_id', $id)->where('status', 4)->count();
        return $tripCount;
    }

    public function profileUpdate()
    {
        $user = User::with('partnerMetas', 'image')->findOrFail(Auth::id());
        // echo"<pre>"; print_r($user); die("=====");
        return view('users.update-profile', compact('user'));
    }

    public function userInactive($id)
    {
    	$user = User::findOrFail($id);
    	$user->status = 0;
    	$user->save();
    	return redirect()->back()->with('success', trans('admin-users.user_inactive_successfully'));
    }

    public function userActive($id)
    {
    	$user = User::findOrFail($id);
    	$user->status = 1;
    	$user->save();
    	return redirect()->back()->with('success', trans('admin-users.user_active_successfully'));
    }

    public function ChangePasswordView()
    {
        return view('users.change-password');
    }

    public function update(Request $request, $id)
    {
    
        $this->validate($request, [
            'name'            => 'string',
            'email'           => 'string|email|unique:users,email,'.$id,
            'password'        => 'string|min:8',
            'title'           => 'integer',
            'identity_type'   => 'integer',
            'identity_number' => 'string',
            'mobile'          => 'string',
            'user_image'      => 'mimes:jpg,jpeg,png',
            'license_file'      => 'mimes:jpg,jpeg,png,gif,pdf',
            'license_number'  => 'string',
            'address'  => 'string',
            'brand_name' => 'string'
        ]);
        $user = User::withTrashed()->find($id);
        
        if($request->hasFile('user_image')){
            $image = $user->image;
           if($image)
           {
            $userImage = Image::find($image->id);
           }
           else{
              $userImage = new Image(); 
           }
            $user_image = $request->file('user_image');

            $name = uniqid().'.'.strtolower($user_image->getClientOriginalExtension());
            $public_path = public_path('storage/sliders');
            $user_image->move($public_path, $name);
            $image_url = asset('storage/sliders/' . $name);

            $userImage->url = $image_url;
            $userImage->imageable_id = $user->id;
            $userImage->imageable_type = 'App\Models\User';



            if (!empty($image) && Storage::disk('public')->exists($image->url)) {
                Storage::disk('public')->delete($image->url);
            }
            $user->image()->save($userImage);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->title = $request->title;
        $user->identity_type = $request->identity_type;
        $user->identity_number = $request->identity_number;
        $user->mobile = $request->mobile;
        $user->save();

        if($user && $user->hasrole('partner')){
            $partner = PartnerMeta::where('user_id', $user->id)->first();
            if($partner){

                if($request->hasFile('license_file')) {
                    // استرجاع الملف المرفق
                    $license_file = $request->file('license_file');
                
                    // إنشاء اسم فريد للملف
                    $name = uniqid() . '.' . strtolower($license_file->getClientOriginalExtension());
                
                    // تحديد المسار لتخزين الملف في public/storage/license-file
                    $public_path = public_path('storage/license-file');
                
                    // نقل الملف إلى المسار المحدد
                    $license_file->move($public_path, $name);
                
                    // توليد رابط URL للوصول إلى الملف
                    $image_url = asset('storage/license-file/' . $name);
                    $path = $image_url;
                
                    // التحقق من أن المسار الحالي للملف ليس فارغًا، ثم التحقق من وجوده قبل حذفه
                    if (!empty($partner->license_file) && Storage::disk('public')->exists($partner->license_file)) {
                        Storage::disk('public')->delete($partner->license_file);
                    }
                } else {
                    // إذا لم يتم رفع ملف جديد، الاحتفاظ بالمسار القديم
                    $path = $partner->license_file;
                }
                
                // تحديث معلومات الشريك
                $partner->license_number = $request->license_number;
                $partner->license_file = $path;
                $partner->address = $request->address;
                $partner->brand_name = $request->brand_name;
                $partner->save();
                
                // إعادة التوجيه بناءً على دور المستخدم
                if ($user->hasrole('user')) {
                    return redirect('users/user')->with('success', trans('users-ts.updated'));
                } elseif ($user->hasrole('partner')) {
                    return redirect('users/partner')->with('success', trans('users-ts.updated'));
                }
            }}}                

    

    public function updateProfile(Request $request, $id)
    {
        
        $user = User::withTrashed()->find($id);
        // dd($request->all(), $id);
        // Define validation rules
        $rules = [
            'name' => 'string',
            'email' => [
                'string',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8',
            'title' => 'integer',
            'identity_type' => 'integer',
            'identity_number' => 'string',
            'mobile' => 'string',
            'user_image' => 'mimes:jpg,jpeg,png',
            'license_file' => 'nullable|mimes:jpg,jpeg,png,gif,pdf',
            'license_number' => 'string',
            'address' => 'string',
            'brand_name' => 'string',
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
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->title = $request->title;
            $user->identity_type = $request->identity_type;
            $user->identity_number = $request->identity_number;
            $user->mobile = $request->mobile;
            $user->save();
    
            if ($user->hasRole('partner')) {
                $partner = PartnerMeta::where('user_id', $user->id)->first();
                if ($partner) {
                    if ($request->hasFile('license_file')) {
                        
                        $oldLicenseFile = $partner->license_file;
                        $license_file = $request->file('license_file');
                        $name = uniqid() . '.' . strtolower($license_file->getClientOriginalExtension());
                        $path = $license_file->storeAs(
                            'license-file',
                            $name,
                            'public'
                        );
                        if (Storage::disk('public')->exists($oldLicenseFile)) {
                           
                            Storage::disk('public')->delete($oldLicenseFile);
                        }
                        $partner->license_file = $path;
                    }
                    $partner->license_number = $request->license_number;
                    $partner->address = $request->address;
                    $partner->brand_name = $request->brand_name;
                    $partner->date_of_birth_hijri = $request->date_of_birth_hijri;
                    $partner->date_of_birth_gregorian = $request->date_of_birth_gregorian;
                    $partner->save();
                }
            }
    
            return redirect('profile-update')->with('success', trans('users-ts.updated'));
        } catch (\Exception $e) {
          
            return redirect('profile-update')->with('error', trans('users-ts.update_failed') . ': ' . $e->getMessage());
        }
    }
}
