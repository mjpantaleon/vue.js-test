<?php
use App\Http\Middleware\CustomAuth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login','HomeController@login');

Route::middleware('client')->group(function(){
    Route::post('verify', 'HomeController@verify');
    Route::post('stocks', 'HomeController@stocks');
    Route::post('changepassword', 'HomeController@changepassword');

    Route::post('agencies','AgencyController@agencies');
    Route::get('agency/info/{agency_cd}','AgencyController@info');
    Route::post('agency/create','AgencyController@create');
    Route::post('agency/update/{agency_cd}','AgencyController@update');

    Route::post('mbd', 'MBDController@search');
    Route::get('mbd/info/{sched_id}', 'MBDController@info');
    Route::get('mbd/donations/{sched_id}', 'MBDController@donations');
    Route::get('mbd/shortinfo/{sched_id}', 'MBDController@shortInfo');
    Route::post('mbd/create', 'MBDController@create');
    Route::post('mbd/addDonor', 'DonationController@mbdNewDonor');
    Route::post('mbd/assignDonor', 'DonationController@mbdAssignDonor');
    Route::post('mbd/donationRemove', 'DonationController@donationRemove');
    Route::post('mbd/checkDonationIDs', 'DonationController@checkDonationIDs');
    Route::post('mbd/updateDonationDetails', 'DonationController@updateDonationDetails');

    Route::post('donors', 'DonorController@search');
    Route::post('donor/create', 'DonorController@create');
    Route::post('donor/update', 'DonorController@update');
    Route::get('donor/{seqno}', 'DonorController@info');
    Route::get('donor/{seqno}/photo', 'DonorController@photo');
    Route::post('walkin/create', 'DonationController@newWalkIn');
    Route::post('walkin/assignDonor', 'DonationController@walkinAssignDonor');
    Route::post('walkin', 'DonationController@walkin');
    
});

Route::middleware('client')->group(function(){
    Route::get('address/regions','AddressController@regions');
    Route::get('address/provinces/{regcode}','AddressController@provinces');
    Route::get('address/cities/{provcode}','AddressController@cities');
    Route::get('address/barangays/{citycode}','AddressController@barangays');

    Route::get('keyvalues','KeyValueController@keyvalues');
    Route::get('keyvalues/nations','KeyValueController@nations');
    Route::get('keyvalues/donationtypes','KeyValueController@donationtypes');
    Route::get('keyvalues/donorstatuses','KeyValueController@donorstatuses');
    Route::get('keyvalues/collectionmethods','KeyValueController@collectionmethods');
    Route::get('keyvalues/collectionstatuses','KeyValueController@collectionstatuses');

    Route::get('dhq/questions','DHQController@questions');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});