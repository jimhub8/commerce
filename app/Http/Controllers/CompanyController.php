<?php

namespace App\Http\Controllers;

use App\models\Company;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Mail\ApproveVendorMail;
use Illuminate\Support\Facades\Mail;

class CompanyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $companies = Company::all();
        // $companies->transform(function ($company) {
        //     if ($company->active == 0) {
        //         $company->active = false;
        //     } else {
        //         $company->active = true;
        //     }
        //     return $company;
        // });
        // return $companies;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return Company::find($company->id);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'company_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'required',
        ]);
        $company = new Company;
        // if ($request->location) {
        //     $location = serialize($request->location);
        //     // Location
        //     $loc = $request->location;
        //     $longitude = $loc['longitude'];
        //     $latitude = $loc['latitude'];
        //     $country = $loc['country'];

        //     if (in_array('administrative_area_level_1', $loc)) {
        //         $locality = $loc['administrative_area_level_1'];
        //     } elseif (in_array('locality', $loc)) {
        //         $locality = $loc['locality'];
        //     } else {
        //         $locality = '';
        //     }

        //     $company->longitude = $longitude;
        //     $company->latitude = $latitude;
        //     $company->country = $country;
        //     $company->locality = $locality;
        //     $company->location = $location;
        // }
        // Location
        $company->company_name = $request->company_name;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->address = $request->address;
        $company->website = $request->website;
        $company->active = true;
        // $company->admin = $request->data['admin']['id'];
        $company->user_id = Auth::id();
        $company->save();
        return $company;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        // return $request->all();
        $company = Company::find($request->id);
        // Location
        // if ($request->location) {
        //     $location = serialize($request->location);
        //     $loc = $request->location;
        //     $longitude = $loc['longitude'];
        //     $latitude = $loc['latitude'];
        //     $country = $loc['country'];

        //     if (in_array('administrative_area_level_1', $loc)) {
        //         $locality = $loc['administrative_area_level_1'];
        //     } elseif (in_array('locality', $loc)) {
        //         $locality = $loc['locality'];
        //     } else {
        //         $locality = '';
        //     }
        //     $company->longitude = $longitude;
        //     $company->latitude = $latitude;
        //     $company->country = $country;
        //     $company->locality = $locality;
        //     $company->location = $location;
        // }
        // Location
        // if ($request->data['admin']) {
        //     $admin = $request->data['admin'];
        // }
        $company->company_name = $request->company_name;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->website = $request->website;
        // $company->admin = $admin;
        $company->address = $request->address;
        $company->save();
        return $company;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }

    public function getCompanies()
    {
        return json_decode(json_encode(Company::all()), true);
    }
    public function getCompanyAdmin()
    {
        $userRoles = User::with(['roles'])->get();
        $user = [];
        $IdArr = [];
        foreach ($userRoles as $value) {
            foreach ($value->roles as $element) {
                $role_name = $element->name;
                $role_id = $element->id;
                if ($role_name == 'companyAdmin') {
                    $user[] = $value;
                }
            }
        }
        return $user;
    }

    public function logo(Request $request, $id)
    {
        $upload = Company::find($request->id);
        if ($request->hasFile('image')) {
            // return('test');
            // $imagename = time() . $request->image->getClientOriginalName();
            // $request->image->storeAs('public/test', $imagename);
            $img = $request->image;
            // $image_path = ;
            if (!empty($upload->logo)) {
                $image_file_arr = explode('/', $upload->logo);
                // dd($image_file_arr);
                $image_file = $image_file_arr[3];

                if (File::exists('storage/logo/' . $image_file)) {
                    $image_path = 'storage/logo/' . $image_file;
                    File::delete($image_path);
                }
                $imagename = Storage::disk('public')->put('logo', $img);
            } else {
                $imagename = Storage::disk('public')->put('logo', $img);
            }

            $imgArr = explode('/', $imagename);
            $image_name = $imgArr[1];
            $upload->logo = '/storage/logo/' . $image_name;
            // $upload->image = '/storage/logo/'.$image_name;
            $upload->save();
            return $upload;
            // $imagename =  Storage::disk('uploads')->put('logo', $img);
        }
        return;
    }

    public function getLogo()
    {
        return Company::where('id', Auth::user()->branch_id)->get();
    }

    public function getLogoOnly()
    {
        $companies = Company::where('id', Auth::user()->branch_id)->get();
        foreach ($companies as $company) {
            $company_logo = $company->logo;
        }
        return $company_logo;
    }

    public function company_activate(Request $request, $id)
    {
        $company = Company::find($id);
        $company->active = !$company->active;
        $company->save();
        if ($company->active == 1) {
            Mail::send(new ApproveVendorMail());
        }
        return $company;
    }
}
