<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Exception;
use App\Providers\AffinidiServices;

class CredentialController extends Controller
{
    public function issueCredential(Request $request)
    {
        try {
            $typeId = $request->input('credentialType');
            if (!$typeId) {
                return response()->json(["error" => "typeId is required"], 400);
            }
            $credentials_request = [];

            switch ($typeId) {
                case 'personalInformation':
                    $credentials_request = [
                        [
                            "credentialTypeId" => config('services.affinidiCIS.personalInformationCredentialTypeId'),
                            "credentialData" => [
                                "name" => [
                                    "givenName" => "Grajesh",
                                    "familyName" => "Chandra",
                                    "nickname" => "Grajesh Testing"
                                ],
                                "birthdate" => "01-01-1990",
                                "birthCountry" => "India",
                                "citizenship" => "Indian",
                                "phoneNumber" => "7666009585",
                                "nationalIdentification" => [
                                    "idNumber1" => "pan",
                                    "idType1" => "askjd13212432d"
                                ],
                                "email" => "grajesh.c@affinidi.com",
                                "gender" => "male",
                                "maritalStatus" => "married",
                                "verificationStatus" => "Completed",
                                "verificationEvidence" => [
                                    "evidenceName1" => "letter",
                                    "evidenceURL1" => "http://localhost"
                                ],
                                "verificationRemarks" => "Done"
                            ]
                        ]
                    ];
                    break;

                case 'address':
                    $credentials_request = [
                        [
                            "credentialTypeId" => config('services.affinidiCIS.addressCredentialTypeId'),
                            "credentialData" => [
                                "address" => [
                                    "addressLine1" => "Varthur, Gunjur",
                                    "addressLine2" => "B305, Candeur Landmark, Tower Eiffel",
                                    "postalCode" => "560087",
                                    "addressRegion" => "Karnataka",
                                    "addressCountry" => "India"
                                ],
                                "ownerDetails" => [
                                    "ownerName" => "TestOwner",
                                    "ownerContactDetails1" => "+912325435634"
                                ],
                                "neighbourDetails" => [
                                    "neighbourName" => "Test Neighbour",
                                    "neighbourContactDetails1" => "+912325435634"
                                ],
                                "stayDetails" => [
                                    "fromDate" => "01-01-2000",
                                    "toDate" => "01-01-2020"
                                ],
                                "verificationStatus" => "Completed",
                                "verificationEvidence" => [
                                    "evidenceName1" => "Letter",
                                    "evidenceURL1" => "http://localhost"
                                ],
                                "verificationRemarks" => "done"
                            ]
                        ]
                    ];
                    break;

                case 'education':
                    $credentials_request = [
                        [
                            "credentialTypeId" => config('services.affinidiCIS.educationCredentialTypeId'),
                            "credentialData" => [
                                "candidateDetails" => [
                                    "name" => "Grajesh Chandra",
                                    "phoneNumber" => "7666009585",
                                    "email" => "grajesh.c@affinidi.com",
                                    "gender" => "male"
                                ],
                                "institutionDetails" => [
                                    "institutionName" => "Affinidi",
                                    "institutionAddress" => [
                                        "addressLine1" => "Varthur, Gunjur",
                                        "addressLine2" => "B305, Candeur Landmark, Tower Eiffel",
                                        "postalCode" => "560087",
                                        "addressRegion" => "Karnataka",
                                        "addressCountry" => "India"
                                    ],
                                    "institutionContact1" => "+91 1234567890",
                                    "institutionContact2" => "+91 1234567890",
                                    "institutionEmail" => "test@affinidi.com",
                                    "institutionWebsiteURL" => "affinidi.com"
                                ],
                                "educationDetails" => [
                                    "qualification" => "Graduation",
                                    "course" => "MBA",
                                    "graduationDate" => "12-08-2013",
                                    "dateAttendedFrom" => "12-08-2011",
                                    "dateAttendedTo" => "12-07-2013",
                                    "educationRegistrationID" => "admins1223454356"
                                ],
                                "verificationStatus" => "Verified",
                                "verificationEvidence" => [
                                    "evidenceName1" => "Degree",
                                    "evidenceURL1" => "http://localhost"
                                ],
                                "verificationRemarks" => "completed"
                            ]
                        ]
                    ];
                    break;

                case 'employment':
                    $credentials_request = [
                        [
                            "credentialTypeId" => config('services.affinidiCIS.employmentCredentialTypeId'),
                            "credentialData" => [
                                "candidateDetails" => [
                                    "name" => "Grajesh Chandra",
                                    "phoneNumber" => "7666009585",
                                    "email" => "grajesh.c@affinidi.com",
                                    "gender" => "male"
                                ],
                                "employerDetails" => [
                                    "companyName" => "Affinidi",
                                    "companyAddress" => [
                                        "addressLine1" => "Varthur, Gunjur",
                                        "addressLine2" => "B305, Candeur Landmark, Tower Eiffel",
                                        "postalCode" => "560087",
                                        "addressRegion" => "Karnataka",
                                        "addressCountry" => "India"
                                    ],
                                    "hRDetails" => [
                                        "hRfirstName" => "Testing",
                                        "hRLastName" => "HR",
                                        "hREmail" => "hr@affinidi.com",
                                        "hRDesignation" => "Lead HR",
                                        "hRContactNumber1" => "+911234567789",
                                        "whenToContact" => "9:00-6:00 PM"
                                    ]
                                ],
                                "employmentDetails" => [
                                    "designation" => "Testing",
                                    "employmentStatus" => "Fulltime",
                                    "annualisedSalary" => "10000",
                                    "currency" => "INR",
                                    "tenure" => [
                                        "fromDate" => "05-2022",
                                        "toDate" => "06-2050"
                                    ],
                                    "reasonForLeaving" => "Resignation",
                                    "eligibleForRehire" => "Yes"
                                ],
                                "verificationStatus" => "Completed",
                                "verificationEvidence" => [
                                    "evidenceName1" => "letter",
                                    "evidenceURL1" => "http://localhost"
                                ],
                                "verificationRemarks" => "Done"
                            ]
                        ]
                    ];
                    break;

                default:
                    return response()->json(["error" => "Invalid typeId"], 400);
            }

            Log::info('Issuing credential', ['credentials_request' => $credentials_request]);

            $projectId = config('services.affinidi_tdk.project_Id');

            $data = AffinidiServices::IssuanceStart($projectId, [
                'data' => $credentials_request,
                'claimMode' => "TX_CODE"
            ]);

            $json_response = [
                "credentialOfferUri" => $data["credentialOfferUri"],
                "txCode" => $data["txCode"],
                "issuanceId" => $data["issuanceId"],
                "expiresIn" => $data["expiresIn"],
                "vaultLink" => config('services.affinidi_tdk.vault_url') . '/claim?credential_offer_uri=' . $data["credentialOfferUri"],
            ];
            Log::info('Credential issued', ['json_response' => $json_response]);
            return response()->json($json_response);
        } catch (Exception $e) {
            // Handle or log the error
            error_log('JSON error: ' . $e->getMessage());

            return response()->json(["error" => $e->getMessage()]);
        }
    }

    public function acceptCredentialStatus(Request $request)
    {
        try {
            $issuanceId = $request->input('issuanceId');
            $configurationId = $request->input('configurationId'); // Assuming request is sending configurationId
            Log::info('Request data', ['request' => $request->all()]);

            if (!$issuanceId && !$configurationId) {
                return response()->json(["success" => false, "error" => "Missing Required field in request body"], 400);
            }
            $projectId = config('services.affinidi_tdk.project_Id');

            $data = AffinidiServices::CredentialStatus($projectId, $configurationId, $issuanceId);

            return response()->json($data); // Correctly return JSON response

        } catch (Exception $e) {
            Log::error('Error fetching issued credentials', ['error' => $e->getMessage()]);
            return response()->json(["success" => false, "error" => "Error fetching issued credentials", 'details' => $e->getMessage()], 500); // Include error details for debugging
        }
    }
}
