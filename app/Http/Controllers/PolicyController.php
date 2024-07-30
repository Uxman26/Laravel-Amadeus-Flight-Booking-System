<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;

class PolicyController extends Controller
{
    protected $PrivacyPolicyservice;
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $privacy_policies='';
        return view('privacy_policy.index');
    }
    public function show()
    {
        $privacy_policies = '';
        return $privacy_policies;
    }
    public function store(Request $request)
    {
        try {
            $privacy_policy = $request->all();
            if (isset($privacy_policy->id)) {
                return response([
                    'status' => 200,
                    'success' => 'Policy Created Successfully',
                    'privacy_policy_id'=>$privacy_policy->id,
                ]);
            } else {
                return response([
                    'status' => 400,
                    'error' => 'Policy Not Created'
                ]);
            }
        } catch (\PDOException $e) {
            return Helper::ajax_catch($e);
        } catch (\Exception $e) {
            return Helper::ajax_catch($e);
        }
    }
    public function update(Request $request,$privacy_policy_id)
    {
        try {
            $PrivacyPolicy = '';
            if (isset($PrivacyPolicy->id)) {
                return response([
                    'status' => 200,
                    'success' => 'Policy Created Successfully'
                ]);
            } else {
                return response([
                    'status' => 200,
                    'success' => 'Policy Created Successfully'
                ]);
            }
        } catch (\PDOException $e) {
            return Helper::ajax_catch($e);
        } catch (\Exception $e) {
            return Helper::ajax_catch($e);
        }
    }
    public function destroy($id)
    {

        $PrivacyPolicy= '';
        if(isset($PrivacyPolicy)){
            return redirect()->route('privacy_policies.index')->with([
                'status' => 200,
                'success' => 'Policy Deleted Successfully'
            ]);
        }
        else{
            return redirect()->route('privacy_policies.index')->withErrors([
                'status' => 400,
                'error' => 'Policy Not Found'
            ]);

        }
        //
    }
}
