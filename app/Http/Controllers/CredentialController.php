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

                case 'avvanz-full':
                    $credentials_request = [
                        [
                            "credentialTypeId" => config('services.affinidiCIS.avvanzDigitalCredentialTypeId'),
                            "credentialData" => [
                                "personalInformation" => [
                                    "positionApplied" => "Software Engineer",
                                    "firstName" => "John",
                                    "middleName" => "Michael",
                                    "lastName" => "Doe",
                                    "aka" => "Johnny",
                                    "email" => "john.doe@example.com",
                                    "phoneNo" => "123-456-7890",
                                    "alterPhoneNo" => "098-765-4321",
                                    "civilStatus" => "Married",
                                    "gender" => "Male",
                                    "primaryIdCard" => "Passport",
                                    "primaryIdCardNo" => "A12345678",
                                    "primaryIdCard2" => "Driver's License",
                                    "primaryIdCardNo2" => "D987654321",
                                    "photo" => "https://example.com/photos/john_doe.jpg",
                                    "notes" => "Available for immediate joining."
                                ],
                                "addressDetails" => [
                                    "address" => [
                                        [
                                            "addressLine1" => "123 Main St",
                                            "addressLine2" => "Apt 4B",
                                            "city" => "New York",
                                            "stateOrRegion" => "NY",
                                            "postalCode" => "10001",
                                            "country" => "USA",
                                            "stayDateFrom" => "2015-06-01",
                                            "stayDateTo" => "2020-05-31",
                                            "houseOwnerName" => "Jane Smith",
                                            "houseOwnerContactNo" => "111-222-3333",
                                            "houseOwnerEmail" => "jane.smith@example.com",
                                            "neighborName" => "Emily Davis",
                                            "neighborContactNo" => "444-555-6666",
                                            "neighborEmail" => "emily.davis@example.com"
                                        ],
                                        [
                                            "addressLine1" => "456 Elm St",
                                            "addressLine2" => "",
                                            "city" => "San Francisco",
                                            "stateOrRegion" => "CA",
                                            "postalCode" => "94107",
                                            "country" => "USA",
                                            "stayDateFrom" => "2020-06-01",
                                            "stayDateTo" => "Present",
                                            "houseOwnerName" => "Robert Brown",
                                            "houseOwnerContactNo" => "777-888-9999",
                                            "houseOwnerEmail" => "robert.brown@example.com",
                                            "neighborName" => "Michael Green",
                                            "neighborContactNo" => "000-111-2222",
                                            "neighborEmail" => "michael.green@example.com"
                                        ]
                                    ]
                                ],
                                "educationDetails" => [
                                    [
                                        "education" => [
                                            [
                                                "institutionName" => "Stanford University",
                                                "institutionContactNo" => "650-723-2300",
                                                "institutionEmail" => "admissions@stanford.edu",
                                                "isGraduated" => "Yes",
                                                "dateFrom" => "2010-09-01",
                                                "dateTo" => "2014-06-30",
                                                "dateGraduated" => "2014-06-30",
                                                "modeOfStudy" => "Full-time",
                                                "addressLine1" => "450 Serra Mall",
                                                "addressLine2" => "",
                                                "postalCode" => "94305",
                                                "stateRegion" => "CA",
                                                "city" => "Stanford"
                                            ],
                                            [
                                                "institutionName" => "Harvard University",
                                                "institutionContactNo" => "617-495-1000",
                                                "institutionEmail" => "admissions@harvard.edu",
                                                "isGraduated" => "Yes",
                                                "dateFrom" => "2014-09-01",
                                                "dateTo" => "2016-06-30",
                                                "dateGraduated" => "2016-06-30",
                                                "modeOfStudy" => "Part-time",
                                                "addressLine1" => "Massachusetts Hall",
                                                "addressLine2" => "",
                                                "postalCode" => "02138",
                                                "stateRegion" => "MA",
                                                "city" => "Cambridge"
                                            ]
                                        ]
                                    ]
                                ],
                                "employmentDetails" => [
                                    "employment" => [
                                        [
                                            "companyName" => "Tech Corp",
                                            "position" => "Junior Developer",
                                            "employmentStatus" => "Full-time",
                                            "annualSalary" => "60000",
                                            "salaryCurrency" => "USD",
                                            "isCurrent" => "No",
                                            "whenToContact" => "Anytime",
                                            "canCommunicate" => "Yes",
                                            "dateFrom" => "2016-07-01",
                                            "dateTo" => "2018-06-30",
                                            "reasonForLeaving" => "Career Growth",
                                            "companyEmail" => "hr@techcorp.com",
                                            "addressLine1" => "789 Tech Ave",
                                            "addressLine2" => "",
                                            "postalCode" => "90001",
                                            "stateRegion" => "CA",
                                            "city" => "Los Angeles",
                                            "country" => "USA",
                                            "hr_first_name" => "Alice",
                                            "hr_last_name" => "Johnson",
                                            "hr_email" => "alice.johnson@techcorp.com",
                                            "hr_contact_no" => "123-456-7890",
                                            "hr_personnel_position" => "HR Manager",
                                            "eligibleForRehire" => "Yes",
                                            "underAgency" => "No",
                                            "agencyName" => ""
                                        ],
                                        [
                                            "companyName" => "Innovate Inc",
                                            "position" => "Senior Developer",
                                            "employmentStatus" => "Full-time",
                                            "annualSalary" => "90000",
                                            "salaryCurrency" => "USD",
                                            "isCurrent" => "Yes",
                                            "whenToContact" => "After 5 PM",
                                            "canCommunicate" => "Yes",
                                            "dateFrom" => "2018-07-01",
                                            "dateTo" => "Present",
                                            "reasonForLeaving" => "",
                                            "companyEmail" => "hr@innovateinc.com",
                                            "addressLine1" => "321 Innovation Dr",
                                            "addressLine2" => "",
                                            "postalCode" => "94043",
                                            "stateRegion" => "CA",
                                            "city" => "Mountain View",
                                            "country" => "USA",
                                            "hr_first_name" => "Bob",
                                            "hr_last_name" => "Smith",
                                            "hr_email" => "bob.smith@innovateinc.com",
                                            "hr_contact_no" => "987-654-3210",
                                            "hr_personnel_position" => "HR Director",
                                            "eligibleForRehire" => "Yes",
                                            "underAgency" => "No",
                                            "agencyName" => ""
                                        ]
                                    ]
                                ],
                                "employmentPerformanceDetails" => [
                                    "employmentPerformance" => [
                                        [
                                            "companyName" => "Tech Corp",
                                            "position" => "Junior Developer",
                                            "supervisorFirstName" => "Carol",
                                            "supervisorMiddleName" => "",
                                            "supervisorLastName" => "White",
                                            "supervisorPosition" => "Team Lead",
                                            "supervisorEmail" => "carol.white@techcorp.com",
                                            "addressLine1" => "789 Tech Ave",
                                            "addressLine2" => "",
                                            "postalCode" => "90001",
                                            "stateRegion" => "CA",
                                            "city" => "Los Angeles",
                                            "country" => "USA",
                                            "contactNo" => "123-456-7890",
                                            "isCurrent" => "No",
                                            "canCommunicate" => "Yes",
                                            "whenToContact" => "Anytime",
                                            "referenceRelationship" => "Supervisor",
                                            "bestTimeToCall" => "10 AM - 4 PM"
                                        ],
                                        [
                                            "companyName" => "Innovate Inc",
                                            "position" => "Senior Developer",
                                            "supervisorFirstName" => "David",
                                            "supervisorMiddleName" => "",
                                            "supervisorLastName" => "Black",
                                            "supervisorPosition" => "Project Manager",
                                            "supervisorEmail" => "david.black@innovateinc.com",
                                            "addressLine1" => "321 Innovation Dr",
                                            "addressLine2" => "",
                                            "postalCode" => "94043",
                                            "stateRegion" => "CA",
                                            "city" => "Mountain View",
                                            "country" => "USA",
                                            "contactNo" => "987-654-3210",
                                            "isCurrent" => "Yes",
                                            "canCommunicate" => "Yes",
                                            "whenToContact" => "After 5 PM",
                                            "referenceRelationship" => "Supervisor",
                                            "bestTimeToCall" => "10 AM - 4 PM"
                                        ]
                                    ]
                                ],
                                "professionalQualificationDetails" => [
                                    "professionalQualification" => [
                                        [
                                            "certificateIssuingAuthority" => "Oracle",
                                            "qualificationAttained" => "Oracle Certified Professional, Java SE 8 Programmer",
                                            "certificateNumber" => "OCJP123456789",
                                            "dateGranted" => "2015-08-15",
                                            "country" => "USA"
                                        ],
                                        [
                                            "certificateIssuingAuthority" => "Microsoft",
                                            "qualificationAttained" => "Microsoft Certified: Azure Fundamentals",
                                            "certificateNumber" => "AZF987654321",
                                            "dateGranted" => "2020-03-20",
                                            "country" => "USA"
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ];
                    break;

                case 'avvanz-partial':
                    $credentials_request = [
                        [
                            "credentialTypeId" => config('services.affinidiCIS.avvanzDigitalCredentialTypeId'),
                            "credentialData" => [
                                "personalInformation" => [
                                    "positionApplied" => "Software Engineer",
                                    "firstName" => "John",
                                    "middleName" => "Michael",
                                    "lastName" => "Doe",
                                    "aka" => "Johnny",
                                    "email" => "john.doe@example.com",
                                    "phoneNo" => "123-456-7890",
                                    "alterPhoneNo" => "098-765-4321",
                                    "civilStatus" => "Married",
                                    "gender" => "Male",
                                    "primaryIdCard" => "Passport",
                                    "primaryIdCardNo" => "A12345678",
                                    "primaryIdCard2" => "Driver's License",
                                    "primaryIdCardNo2" => "D987654321",
                                    "photo" => "https://example.com/photos/john_doe.jpg",
                                    "notes" => "Available for immediate joining."
                                ],
                                "addressDetails" => [
                                    "address" => [
                                        [
                                            "addressLine1" => "123 Main St",
                                            "addressLine2" => "Apt 4B",
                                            "city" => "New York",
                                            "stateOrRegion" => "NY",
                                            "postalCode" => "10001",
                                            "country" => "USA",
                                            "stayDateFrom" => "2015-06-01",
                                            "stayDateTo" => "2020-05-31",
                                            "houseOwnerName" => "Jane Smith",
                                            "houseOwnerContactNo" => "111-222-3333",
                                            "houseOwnerEmail" => "jane.smith@example.com",
                                            "neighborName" => "Emily Davis",
                                            "neighborContactNo" => "444-555-6666",
                                            "neighborEmail" => "emily.davis@example.com"
                                        ],
                                        [
                                            "addressLine1" => "456 Elm St",
                                            "addressLine2" => "",
                                            "city" => "San Francisco",
                                            "stateOrRegion" => "CA",
                                            "postalCode" => "94107",
                                            "country" => "USA",
                                            "stayDateFrom" => "2020-06-01",
                                            "stayDateTo" => "Present",
                                            "houseOwnerName" => "Robert Brown",
                                            "houseOwnerContactNo" => "777-888-9999",
                                            "houseOwnerEmail" => "robert.brown@example.com",
                                            "neighborName" => "Michael Green",
                                            "neighborContactNo" => "000-111-2222",
                                            "neighborEmail" => "michael.green@example.com"
                                        ]
                                    ]
                                ],
                                "educationDetails" => [
                                    [
                                        "education" => [
                                            [
                                                "institutionName" => "Stanford University",
                                                "institutionContactNo" => "650-723-2300",
                                                "institutionEmail" => "admissions@stanford.edu",
                                                "isGraduated" => "Yes",
                                                "dateFrom" => "2010-09-01",
                                                "dateTo" => "2014-06-30",
                                                "dateGraduated" => "2014-06-30",
                                                "modeOfStudy" => "Full-time",
                                                "addressLine1" => "450 Serra Mall",
                                                "addressLine2" => "",
                                                "postalCode" => "94305",
                                                "stateRegion" => "CA",
                                                "city" => "Stanford"
                                            ],
                                            [
                                                "institutionName" => "Harvard University",
                                                "institutionContactNo" => "617-495-1000",
                                                "institutionEmail" => "admissions@harvard.edu",
                                                "isGraduated" => "Yes",
                                                "dateFrom" => "2014-09-01",
                                                "dateTo" => "2016-06-30",
                                                "dateGraduated" => "2016-06-30",
                                                "modeOfStudy" => "Part-time",
                                                "addressLine1" => "Massachusetts Hall",
                                                "addressLine2" => "",
                                                "postalCode" => "02138",
                                                "stateRegion" => "MA",
                                                "city" => "Cambridge"
                                            ]
                                        ]
                                    ]
                                ],
                                "employmentDetails" => [
                                    "employment" => [
                                        [
                                            "companyName" => "Tech Corp",
                                            "position" => "Junior Developer",
                                            "employmentStatus" => "Full-time",
                                            "annualSalary" => "60000",
                                            "salaryCurrency" => "USD",
                                            "isCurrent" => "No",
                                            "whenToContact" => "Anytime",
                                            "canCommunicate" => "Yes",
                                            "dateFrom" => "2016-07-01",
                                            "dateTo" => "2018-06-30",
                                            "reasonForLeaving" => "Career Growth",
                                            "companyEmail" => "hr@techcorp.com",
                                            "addressLine1" => "789 Tech Ave",
                                            "addressLine2" => "",
                                            "postalCode" => "90001",
                                            "stateRegion" => "CA",
                                            "city" => "Los Angeles",
                                            "country" => "USA",
                                            "hr_first_name" => "Alice",
                                            "hr_last_name" => "Johnson",
                                            "hr_email" => "alice.johnson@techcorp.com",
                                            "hr_contact_no" => "123-456-7890",
                                            "hr_personnel_position" => "HR Manager",
                                            "eligibleForRehire" => "Yes",
                                            "underAgency" => "No",
                                            "agencyName" => ""
                                        ],
                                        [
                                            "companyName" => "Innovate Inc",
                                            "position" => "Senior Developer",
                                            "employmentStatus" => "Full-time",
                                            "annualSalary" => "90000",
                                            "salaryCurrency" => "USD",
                                            "isCurrent" => "Yes",
                                            "whenToContact" => "After 5 PM",
                                            "canCommunicate" => "Yes",
                                            "dateFrom" => "2018-07-01",
                                            "dateTo" => "Present",
                                            "reasonForLeaving" => "",
                                            "companyEmail" => "hr@innovateinc.com",
                                            "addressLine1" => "321 Innovation Dr",
                                            "addressLine2" => "",
                                            "postalCode" => "94043",
                                            "stateRegion" => "CA",
                                            "city" => "Mountain View",
                                            "country" => "USA",
                                            "hr_first_name" => "Bob",
                                            "hr_last_name" => "Smith",
                                            "hr_email" => "bob.smith@innovateinc.com",
                                            "hr_contact_no" => "987-654-3210",
                                            "hr_personnel_position" => "HR Director",
                                            "eligibleForRehire" => "Yes",
                                            "underAgency" => "No",
                                            "agencyName" => ""
                                        ]
                                    ]
                                ],
                                "employmentPerformanceDetails" => [
                                    "employmentPerformance" => [
                                        [
                                            "companyName" => "Tech Corp",
                                            "position" => "Junior Developer",
                                            "supervisorFirstName" => "Carol",
                                            "supervisorMiddleName" => "",
                                            "supervisorLastName" => "White",
                                            "supervisorPosition" => "Team Lead",
                                            "supervisorEmail" => "carol.white@techcorp.com",
                                            "addressLine1" => "789 Tech Ave",
                                            "addressLine2" => "",
                                            "postalCode" => "90001",
                                            "stateRegion" => "CA",
                                            "city" => "Los Angeles",
                                            "country" => "USA",
                                            "contactNo" => "123-456-7890",
                                            "isCurrent" => "No",
                                            "canCommunicate" => "Yes",
                                            "whenToContact" => "Anytime",
                                            "referenceRelationship" => "Supervisor",
                                            "bestTimeToCall" => "10 AM - 4 PM"
                                        ],
                                        [
                                            "companyName" => "Innovate Inc",
                                            "position" => "Senior Developer",
                                            "supervisorFirstName" => "David",
                                            "supervisorMiddleName" => "",
                                            "supervisorLastName" => "Black",
                                            "supervisorPosition" => "Project Manager",
                                            "supervisorEmail" => "david.black@innovateinc.com",
                                            "addressLine1" => "321 Innovation Dr",
                                            "addressLine2" => "",
                                            "postalCode" => "94043",
                                            "stateRegion" => "CA",
                                            "city" => "Mountain View",
                                            "country" => "USA",
                                            "contactNo" => "987-654-3210",
                                            "isCurrent" => "Yes",
                                            "canCommunicate" => "Yes",
                                            "whenToContact" => "After 5 PM",
                                            "referenceRelationship" => "Supervisor",
                                            "bestTimeToCall" => "10 AM - 4 PM"
                                        ]
                                    ]
                                ],
                                "professionalQualificationDetails" => [
                                    "professionalQualification" => [
                                        [
                                            "certificateIssuingAuthority" => "Oracle",
                                            "qualificationAttained" => "Oracle Certified Professional, Java SE 8 Programmer",
                                            "certificateNumber" => "OCJP123456789",
                                            "dateGranted" => "2015-08-15",
                                            "country" => "USA"
                                        ],
                                        [
                                            "certificateIssuingAuthority" => "Microsoft",
                                            "qualificationAttained" => "Microsoft Certified: Azure Fundamentals",
                                            "certificateNumber" => "AZF987654321",
                                            "dateGranted" => "2020-03-20",
                                            "country" => "USA"
                                        ]
                                    ]
                                ]
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

    public function IssuedCredential(Request $request)
    {
        try {
            $issuanceId = $request->input('issuanceId');

            Log::info('Request data', ['request' => $request->all()]);

            if (!$issuanceId) {
                return response()->json(["success" => false, "error" => "Missing Required field in request body"], 400);
            }
            $projectId = config('services.affinidi_tdk.project_Id');
            $configurationId = config('services.affinidiCIS.configurationId');
            $data = AffinidiServices::CredentialStatus($projectId, $configurationId, $issuanceId);

            return response()->json($data); // Correctly return JSON response

        } catch (Exception $e) {
            Log::error('Error fetching issued credentials', ['error' => $e->getMessage()]);
            return response()->json(["success" => false, "error" => "Error fetching issued credentials", 'details' => $e->getMessage()], 500); // Include error details for debugging
        }
    }
}
