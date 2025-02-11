<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use stdClass;

class DashboardController extends Controller
{
    use GeneralTrait;

    // public function index()
    // {
    //     $userId = Auth::guard('user')->user();
    //     $userName = $userId->name;
    //     $doctors = DB::table('doctors')
    //         ->join('survey', 'doctors.survey_id', '=', 'survey.survey_id')
    //         ->join('users', 'doctors.user_id', '=', 'users.id')
    //         ->where('doctors.user_id', $userId->id)
    //         ->select('doctors.*', 'survey.title', 'users.employee_pos')
    //         ->get();

    //     $surveyList = DB::table('survey')
    //         ->where('sector_id', $userId->sector_id)
    //         ->where('status', 2)
    //         ->where('type', 0)
    //         ->where('is_survey', 0)
    //         ->where('is_del', 0)
    //         ->get();

    //     foreach ($doctors as $doctor) {
    //         $doctor->encrypted_id = base64_encode(Crypt::encrypt($doctor->id));
    //     }

    //     $uniqueNumber = $this->get_unique_number('doctors', 'send_code', 5, false);

    //     return view('user.dashboard', compact('userName', 'doctors', 'uniqueNumber', 'surveyList'));
    // }

    //survey dashboard function
    // public function index()
    // {
    //     $user = Auth::guard('user')->user();
    //     $userId = $user->id;
    //     $userName = $user->name;
    //     $employeePos = $user->employee_pos;

    //     $query = DB::table('doctors')
    //         ->join('survey', 'doctors.survey_id', '=', 'survey.survey_id')
    //         ->join('users as users1', 'doctors.user_id', '=', 'users1.id')
    //         ->leftJoin('users as users2', 'users1.parent_employee_code', '=', 'users2.employee_code')
    //         ->leftJoin('users as users3', 'users2.parent_employee_code', '=', 'users3.employee_code')
    //         ->leftJoin('users as users4', 'users3.parent_employee_code', '=', 'users4.employee_code')
    //         ->select('doctors.*', 'survey.title as survey_title', 'survey.type as survey_type', 'users1.employee_pos', 'survey.survey_id')
    //         ->where('doctors.is_deleted', 0)
    //         ->where(function ($query) use ($userId, $employeePos) {
    //             if ($employeePos == 3) {
    //                 $query->where(function ($query) use ($userId) {
    //                     $query->where('users3.id', $userId)
    //                         ->orWhere('users1.id', $userId)
    //                         ->orWhere('users2.id', $userId)
    //                         ->orWhere('users4.id', $userId);
    //                 });
    //             } elseif ($employeePos == 2) {
    //                 $query->where(function ($query) use ($userId) {
    //                     $query->where('users3.id', $userId)
    //                         ->orWhere('users1.id', $userId)
    //                         ->orWhere('users2.id', $userId);
    //                 });
    //             } elseif ($employeePos == 1) {
    //                 $query->where(function ($query) use ($userId) {
    //                     $query->where('users2.id', $userId)
    //                         ->orWhere('users1.id', $userId);
    //                 });
    //             } else {
    //                 $query->where('doctors.user_id', $userId);
    //             }
    //         })
    //         ->where(function ($query) {
    //             $query->where('survey.status', 2)
    //                 ->orWhere('doctors.is_test', 1);
    //         })
    //         ->where('survey.type', 0)
    //         ->where('survey.is_survey', 0)
    //         ->orderBy('doctors.is_accept', 'asc')
    //         ->orderBy('doctors.updated_date', 'desc');

    //     $doctors = $query->get();

    //     foreach ($doctors as $doctor) {
    //         $doctor->encrypted_id = base64_encode(Crypt::encrypt($doctor->id));
    //     }

    //     $surveyList = DB::table('survey')
    //         ->where('sector_id', $user->sector_id)
    //         ->where('status', 2)
    //         ->where('type', 0)
    //         ->where('is_survey', 0)
    //         ->where('is_del', 0)
    //         ->orderBy('survey_id', 'asc')
    //         ->get();

    //     $uniqueNumber = $this->get_unique_number('doctors', 'send_code', 5, false);

    //     return view('user.dashboard', compact('userName', 'doctors', 'uniqueNumber', 'surveyList'));
    // }


    public function index(Request $request)
    {
        $user = Auth::guard('user')->user();
        $userId = $user->id;
        $employeePos = $user->employee_pos;

        $surveyType = $request->get('dashboard', 0);

        $query = DB::table('doctors')
            ->join('survey', 'doctors.survey_id', '=', 'survey.survey_id')
            ->join('users as users1', 'doctors.user_id', '=', 'users1.id')
            ->leftJoin('users as users2', 'users1.parent_employee_code', '=', 'users2.employee_code')
            ->leftJoin('users as users3', 'users2.parent_employee_code', '=', 'users3.parent_employee_code')
            ->leftJoin('users as users4', 'users3.parent_employee_code', '=', 'users4.parent_employee_code')
            ->select('doctors.*', 'survey.title as survey_title', 'survey.type as survey_type', 'users1.employee_pos', 'survey.survey_id')
            ->where('doctors.is_deleted', 0)
            ->where(function ($query) use ($userId, $employeePos) {
                if ($employeePos == 3) {
                    $query->where('users4.id', $userId);
                } elseif ($employeePos == 2) {
                    $query->where('users3.id', $userId);
                } elseif ($employeePos == 1) {
                    $query->where('users2.id', $userId);
                } else {
                    $query->where('doctors.user_id', $userId);
                }
            })
            ->where(function ($query) {
                $query->where('survey.status', 2)
                    ->orWhere('doctors.is_test', 1);
            })
            ->where('survey.type', 0)
            ->where('survey.is_survey', $surveyType)
            ->orderBy('doctors.is_accept', 'asc')
            ->orderBy('doctors.updated_date', 'desc');

        $doctors = $query->get();

        foreach ($doctors as $doctor) {
            $doctor->encrypted_id = base64_encode(Crypt::encrypt($doctor->id));
        }

        $surveyList = DB::table('survey')
            ->where('sector_id', $user->sector_id)
            ->where('status', 2)
            ->where('type', 0)
            ->where('is_survey', $surveyType)
            ->where('is_del', 0)
            ->orderBy('survey_id', 'asc')
            ->get();

        $uniqueNumber = $this->get_unique_number('doctors', 'send_code', 5, false);

        return view('user.dashboard', compact('user', 'doctors', 'surveyList', 'uniqueNumber'));
    }

    //non-survey dashboard function
    // public function index2(Request $request)
    // {
    //     $user = Auth::guard('user')->user();
    //     $userId = $user->id;
    //     $userName = $user->name;
    //     $employeePos = $user->employee_pos;

    //     $query = DB::table('doctors')
    //         ->join('survey', 'doctors.survey_id', '=', 'survey.survey_id')
    //         ->join('users as users1', 'doctors.user_id', '=', 'users1.id')
    //         ->leftJoin('users as users2', 'users1.parent_employee_code', '=', 'users2.employee_code')
    //         ->leftJoin('users as users3', 'users2.parent_employee_code', '=', 'users3.employee_code')
    //         ->leftJoin('users as users4', 'users3.parent_employee_code', '=', 'users4.employee_code')
    //         ->select('doctors.*', 'survey.name as survey_name', 'survey.type as survey_type', 'users1.employee_pos', 'survey.survey_id')
    //         ->where('doctors.is_deleted', 0)
    //         ->where(function ($query) use ($userId, $employeePos) {
    //             if ($employeePos == 3) {
    //                 $query->where('users4.id', $userId);
    //             } elseif ($employeePos == 2) {
    //                 $query->where('users3.id', $userId);
    //             } elseif ($employeePos == 1) {
    //                 $query->where('users2.id', $userId);
    //             } else {
    //                 $query->where('doctors.user_id', $userId);
    //             }
    //         })
    //         ->where(function ($query) {
    //             $query->where('survey.status', 2)
    //                 ->orWhere('doctors.is_test', 1);
    //         })
    //         ->where('survey.type', 0)
    //         ->where('survey.is_survey', 1)
    //         ->orderBy('doctors.is_accept', 'asc')
    //         ->orderBy('doctors.updated_date', 'desc');

    //     $doctors = $query->get();

    //     foreach ($doctors as $doctor) {
    //         $doctor->encrypted_id = base64_encode(Crypt::encrypt($doctor->id));
    //     }

    //     $surveyList = DB::table('survey')
    //         ->where('sector_id', $user->sector_id)
    //         ->where('status', 2)
    //         ->where('type', 0)
    //         ->where('is_survey', 1)
    //         ->where('is_del', 0)
    //         ->orderBy('survey_id', 'asc')
    //         ->get();

    //         $uniqueNumber = $this->get_unique_number('doctors', 'send_code', 5, false);

    //     return view('user.dashboard', compact('userName', 'doctors', 'surveyList','uniqueNumber'));
    // }

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('login');
    }

    public function getAgreementPage(Request $request, $doctor_id)
    {
        try {;
            $user = Auth::guard('user')->user();
            $decodedDoctorId = base64_decode($doctor_id);
            $decryptedDoctorId = Crypt::decryptString($decodedDoctorId);

            $decryptedDoctorId = unserialize($decryptedDoctorId) ?? (int) $decryptedDoctorId;

            $response = [];
            $response['csrf'] = [
                'name' => csrf_token(),
                'hash' => csrf_token(),
            ];

            $doctorId = is_numeric($decryptedDoctorId) ? $decryptedDoctorId : 0;

            $is_check = $request->query('is_check', 0);
            $is_check = is_numeric($is_check) ? $is_check : 0;

            $doctor = DB::table('doctors')->where('id', $doctorId)->where('is_deleted', 0)->first();

            if ($doctor) {
                if ($doctor->is_agreement_verified && !$is_check) {
                    $encryptedDoctorId = base64_encode(Crypt::encryptString($doctorId));
                    return redirect()->route('dashboard');
                } else {
                    $response['doctor'] = $doctor;
                    $survey_id = $doctor->survey_id;

                    $survey = DB::table('survey')->where('survey_id', $survey_id)->first();
                    if (!$survey) {
                        return redirect()->route('dashboard');
                    }

                    $response['survey'] = $survey;
                    $sector_id = $survey->sector_id;

                    $sector = DB::table('sectors')->where('sector_id', $sector_id)->first();

                    if ($survey->agreement_type == 1 && now()->gt(\Carbon\Carbon::parse($survey->agreement_date)->addDays(364))) {
                        $isExpired = $this->checkDoctorExpiration($doctor, $sector_id);
                        $response['isExpired'] = $isExpired;
                    }

                    if ($survey->agreement_type == 4 && now()->gt(\Carbon\Carbon::parse($doctor->agreement_date)->addDays(364))) {
                        $isExpired = $this->checkDoctorExpiration($doctor, $sector_id);
                        $response['isExpired'] = $isExpired;
                    }
                    $convertedAmount = $this->getIndianCurrency($doctor->honorarium);
                    return view('user.agreement', compact('response', 'user', 'convertedAmount', 'decodedDoctorId'));
                }
            } else {
                return redirect()->route('dashboard');
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('dashboard');
        }
    }

    private function checkDoctorExpiration($doctor, $sector_id)
    {
        $existingDoctor = DB::table('doctors')
            ->join('survey', 'doctors.survey_id', '=', 'survey.survey_id')
            ->where('doctors.id', '!=', $doctor->id)
            ->where('doctors.doctor_uid', $doctor->doctor_uid)
            ->where('doctors.doctor_type', $doctor->doctor_type)
            ->where('survey.sector_id', $sector_id)
            ->where('doctors.otp_verified', 1)
            ->where('survey.is_survey', 1)
            ->where('doctors.is_deleted', 0)
            ->limit(1)
            ->first();

        return $existingDoctor ? 1 : 0;
    }

    public function storeAgreementData(Request $request, $doctor_id)
    {
        $request->validate([
            'is_agree' => 'required',
        ], [
            'is_agree.required' => 'Please click on the accept button.'
        ]);
        $decryptedDoctorId = Crypt::decryptString($doctor_id);
        $decryptedDoctorId = unserialize($decryptedDoctorId) ?? (int) $decryptedDoctorId;
        if (isset($decryptedDoctorId) && is_numeric($decryptedDoctorId)) {
            if ($request->has('is_agree')) {
                $insertedFields = [
                    'is_agreement_verified' => 1,
                    'updated_date' => now(),
                    'browser' => $this->getIPDetail()
                ];

                $updated = DB::table('doctors')
                    ->where('id', $decryptedDoctorId)
                    ->update($insertedFields);

                if (isset($updated['statuscode']) && $updated['statuscode'] == 1) {
                    return redirect()->route('agreement', ['doctor_id' => $doctor_id]);
                }
                return redirect()->route('get.survey', ['doctor_id' => $doctor_id]);
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function getConfirmationPage(Request $request, $doctor_id)
    {
        try {
            $user = Auth::guard('user')->user();
            if ($user) {
                $data = [];
                $decodedDoctorId = base64_decode($doctor_id);
                $decryptedDoctorId = Crypt::decryptString(base64_decode($doctor_id));
                $doctor_id = unserialize($decryptedDoctorId) ?? (int) $decryptedDoctorId;

                if (is_numeric($doctor_id)) {
                    $doctor = DB::table('doctors as d')
                        ->leftJoin('main_doctors as md', 'md.uin', '=', 'd.doctor_uid')
                        ->select('d.*', 'md.qualification as qu', 'md.experience as exp', 'md.mci_registration as mci')
                        ->where('d.id', $doctor_id)
                        ->where('d.is_deleted', 0)
                        ->first();

                    if ($doctor) {
                        $uin = $doctor->uin;
                        $d_id = $doctor->id;
                        $survey_id = $doctor->survey_id;

                        $doctorDetails = DB::table('doctors as d')
                            ->leftJoin('main_doctors as md', 'md.uin', '=', 'd.doctor_uid')
                            ->select('d.*', 'md.qualification as qu', 'md.experience as exp', 'md.mci_registration as mci')
                            ->where(function ($query) use ($uin, $d_id) {
                                $query->where('d.uin', $uin)
                                    ->orWhere('d.id', $d_id);
                            })
                            ->where(function ($query) {
                                $query->whereNotNull('d.pan_number')
                                    ->orWhere('d.pan_number', '');
                            })
                            ->where(function ($query) {
                                $query->whereNotNull('d.registration_no')
                                    ->orWhereNull('d.registration_no');
                            })
                            ->where('d.is_deleted', 0)
                            ->first();

                        if ($doctorDetails) {
                            $survey = DB::table('survey')
                                ->where('survey_id', $survey_id)
                                ->first();
                            if ($survey) {
                                $data = [
                                    'csrf' => [
                                        'name' => csrf_token(),
                                        'hash' => csrf_token(),
                                    ],
                                    'logged_in' => $user,
                                    'doctor' => $doctor,
                                    'doctorDetails' => $doctorDetails,
                                    'survey' => $survey,
                                ];
                                return view('user.doc_confirm', compact('data', 'user', 'decodedDoctorId'));
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('admin');
        }
    }

    public function storeConfirmationData(Request $request, $doctor_id)
    {
        try {
            $user = Auth::guard('user')->user();
            $decryptedDoctorId = Crypt::decryptString($doctor_id);
            $decryptedDoctorId = unserialize($decryptedDoctorId) ?? (int) $decryptedDoctorId;

            $doctor = DB::table('doctors')
                ->where('id', $decryptedDoctorId)
                ->where('is_deleted', 0)
                ->first();

            if ($doctor && $request->has(['mobile', 'name'])) {
                $credentials = $request->validate([
                    'name' => 'required|regex:/^[a-zA-Z\s\-\'\.]+$/u|max:80',
                    'mobile' => [
                        'required',
                        'regex:/^[0-9]{10}$/',
                        Rule::unique('doctors')->ignore($decryptedDoctorId),
                    ],
                    'address' => 'required|regex:/^[a-zA-Z0-9\s,.\'\/\-\()\[\]]+$/|max:500',
                    'email' => 'required|email',
                    'pin_code' => 'required|regex:/^[0-9]{6}$/',
                    'registration_no' => 'required|max:80',
                ]);

                $updateData = [
                    'is_confirm' => 1,
                    'is_agree' => $request->has('agree') ? 1 : 0,
                    'pin_code' => trim($request->input('pin_code')),
                    'name' => trim($request->input('name')),
                    'mobile' => trim($request->input('mobile')),
                    'email' => trim($request->input('email')),
                    'registration_no' => trim($request->input('registration_no')),
                    'registration_state' => trim($request->input('registration_state')),
                    'address' => trim($request->input('address')),
                    'updated_date' => now(),
                ];

                $data = DB::table('doctors')
                    ->where('id', $decryptedDoctorId)
                    ->update($updateData);
                return response()->json([
                    'success' => true,
                    'redirect_url' => route('accountDetail', ['doctor_id' => $doctor_id]),
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors(),], 422);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json(['success' => false, 'message' => 'Something went wrong.', 'redirect_url' => route('confirmation', ['doctor_id' => $doctor_id]), 'error' => $e->getMessage(),], 500);
        }
    }

    public function getAccountDetailPage(Request $request, $doctor_id)
    {
        try {
            // $user = Auth::guard('user')->user();
            // $data = [];
            // $doc_id = $doctor_id;
            // $decodedDoctorId = base64_decode($doctor_id);
            // $decryptedDoctorId = Crypt::decryptString($doctor_id);
            // $doctor_id = unserialize($decryptedDoctorId) ?? (int) $decryptedDoctorId;

            $user = Auth::guard('user')->user();
            $data = [];
            $doc_id = $doctor_id;
            $decodedDoctorId = base64_decode($doctor_id);
            $decryptedDoctorId = Crypt::decryptString($decodedDoctorId);
            $doctor_id = unserialize($decryptedDoctorId) ?? (int) $decryptedDoctorId;

            $doctor = DB::table('doctors as d')
                ->leftJoin('main_doctors as md', 'md.uin', '=', 'd.doctor_uid')
                ->select(
                    'd.*',
                    'md.qualification as qu',
                    'md.experience as exp',
                    'md.mci_registration as mci'
                )
                ->where('d.id', $doctor_id)
                ->where('d.is_deleted', 0)
                ->first();

            $doctorDetails = DB::table('doctors as d')
                ->leftJoin('main_doctors as md', 'md.uin', '=', 'd.doctor_uid')
                ->select(
                    'd.*',
                    'md.qualification as qu',
                    'md.experience as exp',
                    'md.mci_registration as mci'
                )
                ->where(function ($query) use ($doctor) {
                    $query->where('d.uin', $doctor->uin)
                        ->orWhere('d.id', $doctor->id);
                })
                ->where(function ($query) {
                    $query->whereNotNull('d.pan_number')
                        ->orWhere('d.pan_number', '');
                })
                ->where(function ($query) {
                    $query->whereNotNull('d.registration_no')
                        ->orWhereNull('d.registration_no');
                })
                ->where('d.is_deleted', 0)
                ->first();

            $data['doctor'] = (array) $doctorDetails;
            $data['doctor']['d_id'] = $doctor->id;
            $data['logged_in'] = $user;

            $survey = DB::table('survey')
                ->where('survey_id', $doctor->survey_id)
                ->first();

            if ($survey) {
                $data['survey'] = (array) $survey;
                return view('user.account_details', compact('data', 'user', 'doc_id'));
            }
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Something went wrong!');
        }
    }

    public function storeAccountDetails(Request $request, $doctor_id)
    {
        try {
            $user = Auth::guard('user')->user();
            $doc_id =  $doctor_id;
            $decryptedDoctorId = Crypt::decryptString($doctor_id);
            $decryptedDoctorId = unserialize($decryptedDoctorId) ?? (int) $decryptedDoctorId;

            $doctor = DB::table('doctors')
                ->where('id', $decryptedDoctorId)
                ->where('is_deleted', 0)
                ->first();

            if (!$doctor) {
                return response()->json(['success' => false, 'message' => 'Doctor not found.'], 404);
            }

            $credentials = $request->validate([
                'IFSC_code' => 'required|string|size:11',
                'pan_number' => 'required|string|size:10|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                'account_number' => 'required|string|max:25|regex:/^[0-9]+$/',
                'cancel_cheque' => 'required',
            ], [
                'IFSC_code.required' => 'The IFSC code is required',
                'IFSC_code.size' => 'The IFSC code must be exactly 11 characters long.',
                'pan_number.regex' => 'Please provide a valid PAN number in the format: 5 uppercase letters, 4 digits, and 1 uppercase letter.',
            ]);

            $existingDoctor = DB::table('doctors')
                ->join('survey', 'survey.survey_id', '=', 'doctors.survey_id')
                ->where('doctors.is_test', 0)
                ->where('survey.is_survey', 0)
                ->where('doctors.survey_id', $doctor->survey_id)
                ->where('doctors.pan_number', 'like', '%' . strtolower($request->pan_number) . '%')
                ->where('doctors.id', '!=', $decryptedDoctorId)
                ->where('doctors.is_deleted', 0)
                ->exists();


            if ($existingDoctor) {
                return response()->json(['success' => false, 'message' => 'The PAN number has already been enrolled in the same survey.'], 409);
            }

            $insertedFields = [];
            $previousImagePath = $doctor->cancel_cheque ?? null;
            if ($request->has('cancel_cheque_crop')) {
                $croppedImageData = $request->input('cancel_cheque_crop');
                [$imageType, $imageData] = explode(',', $croppedImageData);
                $imageExtension = str_replace('data:image/', '', explode(';', $imageType)[0]);
                $fileName = time() . '.' . $imageExtension;
                $destinationPath = public_path('assets/img/doctor/document');

                if (!is_dir($destinationPath)) mkdir($destinationPath, 0775, true);

                if ($previousImagePath && file_exists($destinationPath . '/' . $previousImagePath)) {
                    unlink($destinationPath . '/' . $previousImagePath);
                }

                file_put_contents($destinationPath . '/' . $fileName, base64_decode($imageData));
                $insertedFields['cancel_cheque'] = $fileName;
            }


            $insertedFields['pan_number'] = trim($request->pan_number);
            $insertedFields['account_number'] = trim($request->account_number);
            $insertedFields['IFSC_code'] = trim($request->IFSC_code);
            $insertedFields['updated_date'] = now();


            DB::table('doctors')->where('id', $decryptedDoctorId)->update($insertedFields);

            if ($doctor && $doctor->otp == 0) {
                $otp = $this->getOTP(4, false);

                if (isset($request->mobile) && $request->mobile != '' && $otp != '') {
                    $mobile = $request->mobile;
                    $name = str_replace(' ', '+', $request->name);

                    if (strlen($name) > 25) {
                        $n = explode(" ", $name);
                        if (trim($n[0]) == 'Dr.' || trim($n[0]) == 'Dr') {
                            $n[0] = isset($n[0]) ? trim($n[0]) : '';
                            $n[1] = isset($n[1]) ? trim($n[1]) : '';
                            $name = $n[0] . '+' . $n[1] . '+' . substr(trim($n[2]), 0, 1) . '.';
                        } else {
                            $n[0] = isset($n[0]) ? trim($n[0]) : '';
                            $n[1] = isset($n[1]) ? trim($n[1]) : '';
                            $name = $n[0] . '+' . substr(trim($n[1]), 0, 1) . '.';
                        }
                    } else {
                        $name = str_replace(' ', '+', $name);
                    }

                    $platform = DB::table('platformChange')->where('id', 1)->first();
                    if ($platform && $platform->status == 0) {
                        $api = "https://m1.sarv.com/api/v2.0/sms_campaign.php?token=your_token&user_id=your_user_id&route=TR&template_id=12836&sender_id=imagic&language=EN&template=Dear+Doctor%0D%0A%0D%0AKindly+enter+below+OTP+to+submit+your+responses+for+the+Perception+Survey+study.%0D%0A%0D%0A" . $otp . "%0D%0A%0D%0ARgds%2C%0D%0AImagicahealth&contact_numbers=" . $mobile . "";
                        $response = file_get_contents($api);
                    } else {
                        $toNumber = '91' . $mobile;
                        $response = $this->sendWhatsAppMessage($toNumber, $otp);
                    }

                    $insertedFields['otp'] = $otp;
                    $insertedFields['otp_date'] = now();

                    $toEmail = $request->email;
                    $subject = "Alsign : OTP for Completion of Agreement Process";

                    $emailResponse = Http::withHeaders([
                        'Authorization' => 'Zoho-enczapikey your_api_key',
                    ])->post("https://api.zeptomail.in/v1.1/email/template", [
                        'mail_template_key' => 'your_mail_template_key',
                        'from' => [
                            'address' => 'vanita@vinciohealth.in',
                            'name' => 'Alsign',
                        ],
                        'to' => [
                            [
                                'email_address' => [
                                    'address' => $toEmail,
                                    'name' => $name,
                                ],
                            ],
                        ],
                        'merge_info' => [
                            'subject' => $subject,
                            'name' => $name,
                            'OTP' => $otp,
                            'team' => 'Alembic',
                            'product_name' => 'Alsign',
                        ],
                    ]);
                }
            }

            DB::table('doctors')->where('id', $decryptedDoctorId)->update($insertedFields);
            return response()->json(['success' => true, 'redirect_url' => route('signature.page', ['doctor_id' => $doctor_id]), 'message' => 'Account details updated successfully.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors(),], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getSignaturePage(Request $request, $doctor_id)
    {
        $user = Auth::guard('user')->user();
        $doc_id =  $doctor_id;
        $decryptedDoctorId = Crypt::decryptString($doctor_id);
        $decryptedDoctorId = unserialize($decryptedDoctorId) ?? (int) $decryptedDoctorId;

        $doctor = DB::table('doctors')->where('id', $decryptedDoctorId)->where('is_deleted', 0)->first();

        if ($doctor->otp_verified) {
            return redirect()->route('dashboard');
        }

        $survey_id = $doctor->survey_id;
        $completedQuestionIds = DB::table('answers')->where('doctor_id', $decryptedDoctorId)->pluck('question_id')->toArray();

        $questionsCount = DB::table('questions')->where('is_active', 1)->where('survey_id', $survey_id)->count();

        $isLast = ($questionsCount - count($completedQuestionIds)) == 1;

        $nextQuestion = DB::table('questions')->where('is_active', 1)->where('survey_id', $survey_id)->whereNotIn('id', $completedQuestionIds)
            ->orderBy('id', 'asc')
            ->first();

        if ($nextQuestion) {
            return view('survey', [
                'doctor' => $doctor,
                'is_last' => $isLast,
                'question' => $nextQuestion
            ]);
        } else {
        }
        return view('user.signature', compact('doctor', 'doc_id', 'user'));
    }

    public function verifySignature(Request $request, $doctor_id)
    {
        try {
            $user = Auth::guard('user')->user();
            $doc_id =  $doctor_id;
            $decryptedDoctorId = Crypt::decryptString($doctor_id);
            $decryptedDoctorId = unserialize($decryptedDoctorId) ?? (int) $decryptedDoctorId;

            $doctor = DB::table('doctors')->where('id', $decryptedDoctorId)->where('is_deleted', 0)->first();

            if ($doctor && !empty($request->input('signature'))) {
                $insertedFields = [
                    'signature' => $this->createImageFromBase64($doctor->signature, $request->input('signature'), 1),
                    'is_survey_completed' => 1,
                    'signature_date' => now(),
                    'updated_date' => now(),
                    'otp_verified' => 0,
                ];

                $updateStatus = DB::table('doctors')->where('id', $decryptedDoctorId)->update($insertedFields);

                if ($doctor->otp_verified == 1) {
                    return view('survey-complete', compact('doctor'));
                } else {
                    return redirect()->route('verify.mobile', $doc_id);
                }
            } else {
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong.', 'error' => $e->getMessage(),], 500);
        }
    }

    public function getVerifyPage($doctor_id)
    {
        $user = Auth::guard('user')->user();
        $doc_id =  $doctor_id;
        $decryptedDoctorId = Crypt::decryptString($doctor_id);
        $decryptedDoctorId = unserialize($decryptedDoctorId) ?? (int) $decryptedDoctorId;

        $doctor = DB::table('doctors')->where('id', $decryptedDoctorId)->where('is_deleted', 0)->first();
        $platform = DB::table('platformChange')->where('id', 1)->value('status');
        try {
            if ($doctor) {
                $survey_id = $doctor->survey_id;

                if ($doctor->otp == 0) {
                    $otp = $this->getOTP(4, false);

                    if (!empty($doctor->mobile) && $otp) {
                        $mobile = $doctor->mobile;

                        if (strlen($doctor->name) > 25) {
                            $nameParts = explode(" ", $doctor->name);
                            if (trim($nameParts[0]) === 'Dr.' || trim($nameParts[0]) === 'Dr') {
                                $name = trim($nameParts[0]) . '+' . trim($nameParts[1]) . '+' . substr(trim($nameParts[2]), 0, 1) . '.';
                            } else {
                                $name = trim($nameParts[0]) . '+' . substr(trim($nameParts[1]), 0, 1) . '.';
                            }
                        } else {
                            $name = str_replace(' ', '+', $doctor->name);
                        }
                        \Log::info('platform');
                        \Log::info($platform);
                        if ($platform == 0) {
                            // $apiUrl = "https://m1.sarv.com/api/v2.0/sms_campaign.php";
                            // $params = [
                            //     'token' => '18784455306578101d3da397.54383814',
                            //     'user_id' => '93984201',
                            //     'route' => 'TR',
                            //     'template_id' => '12836',
                            //     'sender_id' => 'imagic',
                            //     'language' => 'EN',
                            //     'template' => "Dear+Doctor%0D%0A%0D%0AKindly+enter+below+OTP+to+submit+your+responses+for+the+Perception+Survey+study.%0D%0A%0D%0A{$otp}%0D%0A%0D%0ARgds%2C%0D%0AImagicahealth",
                            //     'contact_numbers' => $mobile,
                            // ];

                            $api = "https://m1.sarv.com/api/v2.0/sms_campaign.php?token=18784455306578101d3da397.54383814&user_id=93984201&route=TR&template_id=12836&sender_id=imagic&language=EN&template=Dear+Doctor%0D%0A%0D%0AKindly+enter+below+OTP+to+submit+your+responses+for+the+Perception+Survey+study.%0D%0A%0D%0A" . $otp . "%0D%0A%0D%0ARgds%2C%0D%0AImagicahealth&contact_numbers=" . $mobile . "";
                            $response = file_get_contents($api);

                            // \Log::info('response otp');
                            // \Log::info($response);
                        } else {
                            $toNumber = '91' . $mobile;
                            $response = $this->sendWhatsAppMessage($toNumber, $otp);
                        }
                    }

                    // HTTP request call code 
                    // if (!empty($doctor->email) && ($otp != 0 || $otp != '')) {

                    //     $fromEmail = "imagica.health@gmail.com";
                    //     $toEmail = $doctor->email;
                    //     $subject = "Alsign : OTP for Completion of Agreement Process";
                    //     $name = $doctor->name;

                    //     $response = Http::withHeaders([
                    //         "accept" => "application/json",
                    //         "authorization" => "Zoho-enczapikey PHtE6r0MQ+Dj3WR6oxFT56K4RZXyPdksrLlkLwFBs4lFD6NVSk0A/owqwTOwrB0sVqRDFKWSmtpgtbucsr3XcWjrNm9MVGqyqK3sx/VYSPOZsbq6x00asVkTfkLaV4LoddFi1CzTv9uX",
                    //         "cache-control" => "no-cache",
                    //         "content-type" => "application/json",
                    //     ])->post("https://api.zeptomail.in/v1.1/email/template", [
                    //         "mail_template_key" => "2518b.40f38d0712830fa4.k1.f193af90-5ea4-11ef-8aea-52540038fbba.1916dd8a109",
                    //         "from" => [
                    //             "address" => "vanita@vinciohealth.in",
                    //             "name" => "Alsign"
                    //         ],
                    //         "to" => [
                    //             [
                    //                 "email_address" => [
                    //                     "address" => $toEmail,
                    //                     "name" => $name
                    //                 ]
                    //             ]
                    //         ],
                    //         "merge_info" => [
                    //             "subject" => $subject,
                    //             "name" => $name,
                    //             "OTP" => $otp,
                    //             "team" => "Alembic",
                    //             "product_name" => "Alsign"
                    //         ]
                    //     ]);
                    //     if ($response->failed()) {
                    //         return response()->json(['error' => 'Failed to send email'], 500);
                    //     }
                    // }

                    // curl call code 
                    if (!empty($doctor->email) && ($otp != 0 || $otp != '')) {

                        $fromEmail = "imagica.health@gmail.com";
                        $toEmail = $doctor->email;
                        $subject = "Alsign : OTP for Completion of Agreement Process";
                        $name = $doctor->name;

                        $curl = curl_init();

                        $postData = json_encode([
                            "mail_template_key" => "2518b.40f38d0712830fa4.k1.f193af90-5ea4-11ef-8aea-52540038fbba.1916dd8a109",
                            "from" => [
                                "address" => "vanita@vinciohealth.in",
                                "name" => "Alsign"
                            ],
                            "to" => [
                                [
                                    "email_address" => [
                                        "address" => $toEmail,
                                        "name" => $name
                                    ]
                                ]
                            ],
                            "merge_info" => [
                                "subject" => $subject,
                                "name" => $name,
                                "OTP" => $otp,
                                "team" => "Alembic",
                                "product_name" => "Alsign"
                            ]
                        ]);

                        curl_setopt_array($curl, [
                            CURLOPT_URL => "https://api.zeptomail.in/v1.1/email/template",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => $postData,
                            CURLOPT_HTTPHEADER => [
                                "accept: application/json",
                                "authorization: Zoho-enczapikey PHtE6r0MQ+Dj3WR6oxFT56K4RZXyPdksrLlkLwFBs4lFD6NVSk0A/owqwTOwrB0sVqRDFKWSmtpgtbucsr3XcWjrNm9MVGqyqK3sx/VYSPOZsbq6x00asVkTfkLaV4LoddFi1CzTv9uX",
                                "cache-control: no-cache",
                                "content-type: application/json",
                            ],
                        ]);

                        $response = curl_exec($curl);
                        $err = curl_error($curl);

                        curl_close($curl);

                        if ($err) {
                            return response()->json(['error' => "cURL Error: " . $err], 500);
                        }
                    }

                    $insertedFields['otp'] = $otp;
                    $insertedFields['otp_date'] = date("Y-m-d H:i:s");
                    $insertedFields['updated_date'] = date("Y-m-d H:i:s");
                    $updateStatus = DB::table('doctors')->where('id', $decryptedDoctorId)->update($insertedFields);
                    $iSurvey = DB::table('survey')->where('survey_id', $survey_id)->first();

                    if ($iSurvey) {
                        $data['survey'] = (array) $iSurvey;
                    }
                    $data['platform'] = $platform;


                    return view('user.verify-mobile', compact('data', 'user', 'doc_id'));
                }
                // else {
                //     return redirect()->route('dashboard');
                // }
            }
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['success' => false, 'message' => 'Something went wrong.', 'error' => $e->getMessage(),], 500);
        }
    }

    public function verifyOTP(Request $request, $doctor_id)
    {
        $user = Auth::guard('user')->user();
        $doc_id =  $doctor_id;
        $decryptedDoctorId = Crypt::decryptString($doctor_id);
        $decryptedDoctorId = unserialize($decryptedDoctorId) ?? (int) $decryptedDoctorId;

        if (isset($decryptedDoctorId) && is_numeric($decryptedDoctorId)) {

            $doctor = DB::table('doctors')
                ->where('id', $decryptedDoctorId)
                ->where('is_deleted', 0)
                ->first();

            if ($doctor && !empty($request->otp)) {
                $survey_id = $doctor->survey_id;

                $masterOtps = DB::table('otp')->pluck('otp')->toArray();

                if ($request->otp == $doctor->otp || in_array($request->otp, $masterOtps)) {
                    DB::table('doctors')->where('id', $decryptedDoctorId)->update([
                        'otp_verified' => 1,
                        'updated_date' => now()
                    ]);

                    $encodedSurveyId = Crypt::encryptString($survey_id);
                    // \Log::info('survey_Id');
                    // \Log::info($encodedSurveyId);
                    return redirect()->route('survey', ['survey_id' => $encodedSurveyId, 'doctor_id' => $doc_id]);
                } else {
                    return redirect()->route('verify.mobile', $doc_id);
                }
            } else {
                return redirect()->route('verify.mobile', $doc_id);
            }
        }
    }

    public function getSurveyFinalPage($survey_id, $doctor_id)
    {
        $user = Auth::guard('user')->user();
        $doctor_id = Crypt::decryptString($doctor_id);
        $decryptedDoctorId = unserialize($doctor_id) ?? (int) $doctor_id;

        $survey_id = Crypt::decryptString($survey_id);


        $loggedInUser = Auth::guard('user')->user();
        $survey = DB::table('survey')->where('survey_id', $survey_id)->first();

        $response = [
            'logged_in' => $loggedInUser,
            'doctor_id' => $doctor_id,
            'survey' => $survey ?? null
        ];

        return view('user.survey_complete', compact('response', 'user'));
    }

    // public function getSurveyPage($doctor_id)
    // {
    //     $doc_id = $doctor_id;
    //     $user = Auth::guard('user')->user();
    //     $doctor_id = Crypt::decryptString($doctor_id);
    //     $decryptedDoctorId = unserialize($doctor_id) ?? (int) $doctor_id;

    //     $doctor = DB::table('doctors')->where('id', $decryptedDoctorId)->where('is_deleted', 0)->first();

    //     if (!$doctor) {
    //         return redirect()->route('dashboard');
    //     }

    //     $survey_id = $doctor->survey_id;

    //     $totalQuestions = DB::table('questions')
    //         ->where('is_active', 1)
    //         ->where('survey_id', $survey_id)
    //         ->count();

    //     $completedQuestionIds = DB::table('answers')
    //         ->where('doctor_id', $decryptedDoctorId)
    //         ->where('is_next', 1)
    //         ->pluck('question_id')
    //         ->toArray();

    //     $remainingQuestions = max(0, $totalQuestions - count($completedQuestionIds));

    //     $isLast = intval($remainingQuestions == 1);

    //     $nextQuestion = DB::table('questions')
    //         ->where('is_active', 1)
    //         ->where('survey_id', $survey_id)
    //         ->whereNotIn('id', $completedQuestionIds)
    //         ->orderBy('id', 'asc')
    //         ->first();

    //     $encryptedQuestionId = $nextQuestion ? Crypt::encryptString($nextQuestion->id) : null;

    //     if ($nextQuestion && $nextQuestion->depend_id != 0) {
    //         $dependAnswer = DB::table('answers')
    //             ->where('doctor_id', $decryptedDoctorId)
    //             ->where('question_id', $nextQuestion->depend_id)
    //             ->where('is_next', 1)
    //             ->first();

    //         if ($dependAnswer && strpos($dependAnswer->answers, $nextQuestion->depend_answers) === false) {
    //             DB::table('answers')->updateOrInsert(
    //                 [
    //                     'doctor_id' => $decryptedDoctorId,
    //                     'question_id' => $nextQuestion->id,
    //                 ],
    //                 [
    //                     'answers' => '',
    //                     'is_skiped' => 1,
    //                     'is_next' => 1,
    //                     'updated_date' => now(),
    //                 ]
    //             );

    //             return redirect()->route('get.survey', ['doctor_id' => $doc_id]);
    //         }
    //     }

    //     $currentAnswer = DB::table('answers')
    //         ->where('doctor_id', $decryptedDoctorId)
    //         ->where('question_id', optional($nextQuestion)->id)
    //         ->first();
    //     $nextQuestion = (object) $nextQuestion;
    //     return view('user.survey', compact('doctor', 'nextQuestion', 'currentAnswer', 'isLast', 'doc_id', 'user', 'encryptedQuestionId'));
    // }

    public function getSurveyPage(Request $request, $doctor_id)
    {
        $is_check = request()->query('is_check');
        $doc_id = $doctor_id;
        $user = Auth::guard('user')->user();

        if (base64_encode(base64_decode($doctor_id, true)) === $doctor_id && $is_check == 1) {
            $doctor_id = base64_decode($doctor_id);
        }
        $doctor_id = Crypt::decryptString($doctor_id);
        $decryptedDoctorId = unserialize($doctor_id) ?? (int) $doctor_id;

        $doctor = DB::table('doctors')->where('id', $decryptedDoctorId)->where('is_deleted', 0)->first();

        if (!$doctor) {
            return redirect()->route('dashboard');
        }

        $survey_id = $doctor->survey_id;
        $totalQuestions = DB::table('questions')
            ->where('is_active', 1)
            ->where('survey_id', $survey_id)
            ->count();

        $completedQuestionIds = DB::table('answers')->where('doctor_id', $decryptedDoctorId)->where('is_next', 1)->pluck('question_id')->toArray();

        $remainingQuestions = max(0, $totalQuestions - count($completedQuestionIds));

        $isLast = intval($remainingQuestions == 1);

        $nextQuestion = DB::table('questions')
            ->where('is_active', 1)
            ->where('survey_id', $survey_id)
            // ->whereNotIn('id', $completedQuestionIds)
            ->orderBy('id', 'asc')
            ->first();

        $encryptedQuestionId = $nextQuestion ? Crypt::encryptString($nextQuestion->id) : null;

        if ($nextQuestion && $nextQuestion->depend_id != 0) {
            $dependAnswer = DB::table('answers')
                ->where('doctor_id', $decryptedDoctorId)
                ->where('question_id', $nextQuestion->depend_id)
                ->where('is_next', 1)
                ->first();

            if ($dependAnswer && strpos($dependAnswer->answers, $nextQuestion->depend_answers) === false) {
                DB::table('answers')->updateOrInsert(
                    [
                        'doctor_id' => $decryptedDoctorId,
                        'question_id' => $nextQuestion->id,
                    ],
                    [
                        'answers' => '',
                        'is_skiped' => 1,
                        'is_next' => 1,
                        'updated_date' => now(),
                    ]
                );

                // return redirect()->route('get.survey', ['doctor_id' => $doc_id]);
                return redirect()->route('get.survey', ['doctor_id' => $decryptedDoctorId]);
            }
        }

        $currentAnswer = DB::table('answers')
            ->where('doctor_id', $decryptedDoctorId)
            ->where('question_id', optional($nextQuestion)->id)
            ->first();

        return view('user.survey', compact('doctor', 'nextQuestion', 'currentAnswer', 'isLast', 'decryptedDoctorId','doc_id', 'user', 'encryptedQuestionId'));
    }

    public function storeAnswer(Request $request)
    {
        try {
            $decodedData = [];
            parse_str(utf8_decode(base64_decode($request->encodedData)), $decodedData);
            // dd(base64_encode(base64_decode($decodedData['doc_id'], true)) === $decodedData['doc_id']);
            // if (base64_encode(base64_decode($decodedData['doc_id'], true)) === $decodedData['doc_id']) {
            //     dd($decodedDocId = base64_decode($decodedData['doc_id'], true));
            //     // dd($decodedData['doc_id']);
            // }
            $decryptedDoctorId = ($decodedData['doc_id']);
            // dd($decryptedDoctorId);
            // dd($decodedData);
            // dd("test1");

            // $decryptedDoctorId = unserialize($doctor_id) ?? (int) $doctor_id;

            // $decodedData = [];
            // parse_str(utf8_decode(base64_decode($request->encodedData)), $decodedData);

            // $docId = $decodedData['doc_id'] ?? null;

            // $decodedDocId = base64_decode($docId, true);

            // if (json_decode($decodedDocId, true) !== null) {
            //     $decryptedDoctorId = Crypt::decryptString($docId);

            //     if (str_starts_with($decryptedDoctorId, 'i:')) {
            //         $decryptedDoctorId = unserialize($decryptedDoctorId);
            //     }
            // }


            $question_id = is_numeric($decodedData['question']) ? $decodedData['question'] : Crypt::decryptString($decodedData['question']);
            if (!isset($decodedData['answer'])) {
                return response()->json(['error' => 'The answer field is required'], 401);
            }
            $answer = $decodedData['answer'];
            $isLast = $decodedData['is_last'];
            $doctor = DB::table('doctors')->where('id', $decryptedDoctorId)->where('is_deleted', 0)->first();
            $survey_id = $doctor->survey_id;

            $data = DB::table('answers')->updateOrInsert(
                [
                    'doctor_id' => $decryptedDoctorId,
                    'question_id' => $question_id,
                ],
                [
                    'answers' => $answer,
                    'is_next' => 1,
                    'updated_date' => now(),
                ]
            );


            //using decrypdata function
            // $decodedData = base64_decode($request->encodedData);
            // $decryptedData = $this->decryptData($decodedData); 
            // dd($decryptedData);

            // \Log::info("Decoded Data: ", $decodedData);

            $remainingQuestionsCount = DB::table('questions')
                ->where('survey_id', $survey_id)
                ->where('id', '>', $question_id)
                ->count();

            // \Log::info("Remaining questions: " . $remainingQuestionsCount);

            if ($isLast) {
                return response()->json(['success' => true, 'isLast' => true,'redirect_url' => route('accountDetail', $decodedData['doctor_id'])]);
            }

            $nextQuestion = DB::table('questions')
                ->where('survey_id', $survey_id)
                ->where('id', '>', $question_id)
                ->orderBy('id', 'asc')
                ->first();


            // \Log::info('Current Question ID: ' . $question_id);

            // if ($nextQuestion) {
            //     if ($nextQuestion->id != $question_id) {
            //         $encodedNextQuestion = base64_encode($nextQuestion->id);
            //         $encodedHtml  = base64_encode(view('user.next-question', compact('nextQuestion', 'isLast'))->render());
            //         $encodedRemainingQuestions = base64_encode($remainingQuestionsCount);
            //         // $html = view('user.next-question', compact('nextQuestion', 'isLast'))->render();
            //         return response()->json([
            //             'success' => true,
            //             'nextQuestionHtml' => $encodedHtml ,
            //             'nextQuestion' => $encodedNextQuestion,
            //             'remainingQuestionsCount' => $encodedRemainingQuestions,
            //         ]);
            //     }
            // }
            $currentAnswer = DB::table('answers')
            ->where('doctor_id', $decryptedDoctorId)
            ->where('question_id', optional($nextQuestion)->id)
            ->first();

            if ($nextQuestion) {
                if ($nextQuestion->id != $question_id) {
                    $dataToEncode = [
                        'nextQuestionId' => $nextQuestion->id,
                        'nextQuestionHtml' => view('user.next-question', compact('nextQuestion','currentAnswer', 'isLast'))->render(),
                        'remainingQuestionsCount' => $remainingQuestionsCount
                    ];

                    $encodedData = base64_encode(json_encode($dataToEncode));
                    return response()->json([
                        'success' => true,
                        'encodedData' => $encodedData
                    ]);
                }
            }
            return response()->json(['redirect' => true, 'redirect_url' => route('accountDetail', $decodedData['doctor_id'])]);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            dd($e);
            // \Log::error('Decryption failed for question_id: ' . $request->question);
            return response()->json(['error' => 'Invalid payload', 'message' => $e->getMessage()]);
        }
    }
}
