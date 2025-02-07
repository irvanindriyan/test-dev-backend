<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Helpers\FunctionHelpers;
use Throwable, DB, File, Log;

class QuestionsController extends Controller
{
    public function callbackAnswer(Request $request)
    {
        try {
            return response()->json(
                FunctionHelpers::resSuccess(
                    'Backend Questions TEST TECHNICAL INTEGRASIA 1 ~ 9.'
                ), 
                200
            );
        } catch (Throwable $throwable) {
            $getStatusCode = $throwable instanceof HttpException
                ? $throwable->getStatusCode()
                : 500;

            return response()->json(
                FunctionHelpers::resError(
                    $throwable->getMessage(), 
                    $getStatusCode
                ), 
                $getStatusCode ?: 500
            );
        }
    }

    public function callbackAnswerOne(Request $request)
    {
        try {
            $petsData = [
                [
                    'type' => 'Dog',
                    'breed' => 'Golden Retriever',
                    'name' => 'Otto',
                    'beloved_animal' => 1,
                    'characteristics' => [
                        'Energetic',
                        'Loves playing with a ball'
                    ]
                ], [
                    'type' => 'Dog',
                    'breed' => 'Siberian Husky',
                    'name' => 'Max',
                    'beloved_animal' => 1,
                    'characteristics' => [
                        'Thick fur',
                        'Blue eyes'
                    ]
                ], [
                    'type' => 'Dog',
                    'breed' => 'Beagle',
                    'name' => 'Bob',
                    'beloved_animal' => 2,
                    'characteristics' => [
                        'Cheerful',
                        'Active in the park'
                    ]
                ], [
                    'type' => 'Cat',
                    'breed' => 'Persian',
                    'name' => 'Luna',
                    'beloved_animal' => 1,
                    'characteristics' => [
                        'Graceful',
                        'Affectionate'
                    ]
                ], [
                    'type' => 'Cat',
                    'beloved_animal' => 1,
                    'breed' => 'British Shorthair',
                    'name' => 'Milo',
                    'characteristics' => [
                        'Smart',
                        'Active'
                    ]
                ], [
                    'type' => 'Fish',
                    'breed' => 'Koi',
                    'name' => 'Nana',
                    'beloved_animal' => 2,
                    'characteristics' => [
                        'Beautiful',
                        'Calming'
                    ]
                ], [
                    'type' => 'Fish',
                    'breed' => 'Goldfish',
                    'name' => 'Goldie',
                    'beloved_animal' => 2,
                    'characteristics' => [
                        'Bright',
                        'Aattractive colors'
                    ]
                ]
            ];

            return response()->json(
                FunctionHelpers::resSuccess(
                    [
                        'input' => $request->all(),
                        'output' => $petsData
                    ]
                ), 
                200
            );
        } catch (Throwable $throwable) {
            $getStatusCode = $throwable instanceof HttpException
                ? $throwable->getStatusCode()
                : 500;

            return response()->json(
                FunctionHelpers::resError(
                    $throwable->getMessage(), 
                    $getStatusCode
                ), 
                $getStatusCode ?: 500
            );
        }
    }

    public function callbackAnswerTwo(Request $request)
    {
        try {
            $this->validate($request, [
                'new_pet' => 'required|array',
                'new_pet.type' => 'required',
                'new_pet.breed' => 'required',
                'new_pet.name' => 'required',
                'new_pet.characteristics' => 'required|array',
            ], [
                'new_pet.required' => 'Kolom new pet diperlukan!',
                'new_pet.array' => 'Nilai new pet wajib array!',
                'new_pet.type.required' => 'Kolom type new pet diperlukan!',
                'new_pet.breed.required' => 'Kolom breed new pet diperlukan!',
                'new_pet.name.required' => 'Kolom name new pet diperlukan!',
                'new_pet.characteristics.required' => 'Kolom characteristics new pet diperlukan!',
                'new_pet.characteristics.array' => 'Nilai characteristics new pet wajib array!',
            ]);

            $getPetsData = self::callbackAnswerOne($request);
            $getPets = $getPetsData->original;

            if ($getPets['code'] == 200) {
                $petsData = $getPets['data']['output'];

                if (!empty($request->new_pet)) {
                    $newPet = $request->new_pet;

                    $petsData[] = $newPet;
                }

                return response()->json(
                    FunctionHelpers::resSuccess(
                        [
                            'input' => $request->all(),
                            'output' => $petsData
                        ]
                    ), 
                    200
                );
            }

            return $getPetsData;
        } catch (Throwable $throwable) {
            $getStatusCode = $throwable instanceof HttpException
                ? $throwable->getStatusCode()
                : 500;

            return response()->json(
                FunctionHelpers::resError(
                    $throwable->getMessage(), 
                    $getStatusCode
                ), 
                $getStatusCode ?: 500
            );
        }
    }

    public function callbackAnswerThree(Request $request)
    {
        try {
            $this->validate($request, [
                'order' => 'required|in:asc,desc',
                'beloved_animal' => 'in:1,2',
            ], [
                'order.required' => 'Kolom order diperlukan!',
                'order.in' => 'Kolom order tidak tersedia diperlukan!',
                'beloved_animal.in' => 'Kolom beloved animal tidak tersedia diperlukan!',
            ]);

            $getPetsData = self::callbackAnswerTwo($request);
            $getPets = $getPetsData->original;

            if ($getPets['code'] == 200) {
                $petsData = $getPets['data']['output'];

                if (!empty($request->beloved_animal)) {
                    $animalsData = collect(self::findByBeloved($petsData, $request->beloved_animal));
                } else {
                    $animalsData = collect($petsData);
                }

                switch ($request->order) {
                    case 'asc':
                            $sortedAnimalsData = $animalsData->sortBy('name')->values()->all();
                        break;
                    
                    case 'desc':
                            $sortedAnimalsData = $animalsData->sortByDesc('name')->values()->all();
                        break;
                    
                    default:
                            $sortedAnimalsData = $animalsData->values()->all();
                        break;
                }

                return response()->json(
                    FunctionHelpers::resSuccess(
                        [
                            'input' => $request->all(),
                            'output' => $sortedAnimalsData
                        ]
                    ), 
                    200
                );
            }

            return $getPetsData;
        } catch (Throwable $throwable) {
            $getStatusCode = $throwable instanceof HttpException
                ? $throwable->getStatusCode()
                : 500;

            return response()->json(
                FunctionHelpers::resError(
                    $throwable->getMessage(), 
                    $getStatusCode
                ), 
                $getStatusCode ?: 500
            );
        }
    }

    public function callbackAnswerFour(Request $request)
    {
        try {
            $getPetsData = self::callbackAnswerThree($request);
            $getPets = $getPetsData->original;

            if ($getPets['code'] == 200) {
                $petsData = $getPets['data']['output'];

                $replaceBreedPetsData = self::replaceBreed($petsData, [
                    'breed_replace' => $request->breed_replace['replace'],
                    'breed_replaced' => $request->breed_replace['replaced']
                ]);

                return response()->json(
                    FunctionHelpers::resSuccess(
                        [
                            'input' => $request->all(),
                            'output' => $replaceBreedPetsData
                        ]
                    ), 
                    200
                );
            }

            return $getPetsData;
        } catch (Throwable $throwable) {
            $getStatusCode = $throwable instanceof HttpException
                ? $throwable->getStatusCode()
                : 500;

            return response()->json(
                FunctionHelpers::resError(
                    $throwable->getMessage(), 
                    $getStatusCode
                ), 
                $getStatusCode ?: 500
            );
        }
    }

    public function callbackAnswerFive(Request $request)
    {
        try {
            $getPetsData = self::callbackAnswerFour($request);
            $getPets = $getPetsData->original;

            if ($getPets['code'] == 200) {
                $petsData = $getPets['data']['output'];

                $countPetsData = self::countPetsByType($petsData);

                return response()->json(
                    FunctionHelpers::resSuccess(
                        [
                            'input' => $request->all(),
                            'output' => $countPetsData
                        ]
                    ), 
                    200
                );
            }

            return $getPetsData;
        } catch (Throwable $throwable) {
            $getStatusCode = $throwable instanceof HttpException
                ? $throwable->getStatusCode()
                : 500;

            return response()->json(
                FunctionHelpers::resError(
                    $throwable->getMessage(), 
                    $getStatusCode
                ), 
                $getStatusCode ?: 500
            );
        }
    }

    public function callbackAnswerSix(Request $request)
    {
        try {
            $getPetsData = self::callbackAnswerFour($request);
            $getPets = $getPetsData->original;

            if ($getPets['code'] == 200) {
                $petsData = $getPets['data']['output'];

                $countPetsData = self::checkPetsWithPalindrome($petsData);

                return response()->json(
                    FunctionHelpers::resSuccess(
                        [
                            'input' => $request->all(),
                            'output' => $countPetsData
                        ]
                    ), 
                    200
                );
            }

            return $getPetsData;
        } catch (Throwable $throwable) {
            $getStatusCode = $throwable instanceof HttpException
                ? $throwable->getStatusCode()
                : 500;

            return response()->json(
                FunctionHelpers::resError(
                    $throwable->getMessage(), 
                    $getStatusCode
                ), 
                $getStatusCode ?: 500
            );
        }
    }

    public function findByBeloved(array $data, int $status): array
    {
        $results = [];
        
        foreach ($data as $item) {
            if ($item['beloved_animal'] === $status) {
                $results[] = $item;
            }
        }
        
        return $results;
    }

    public function replaceBreed(array $petsData, array $replaceData): array 
    {
        return array_map(function ($pet) use($replaceData) {
            if ($pet['breed'] === $replaceData['breed_replace']) {
                $pet['breed'] = $replaceData['breed_replaced'];
            }

            return $pet;
        }, $petsData);
    }

    public function countPetsByType(array $petsData): array 
    {
        $countPets = [];

        foreach ($petsData as $pet) {
            $petType = $pet['type'];

            if (!isset($countPets[$petType])) {
                $countPets[$petType] = 0;
            }

            $countPets[$petType]++;
        }

        return $countPets;
    }

    public function checkPetsWithPalindrome(array $petsData): array 
    {
        $palindromePets = [];

        foreach ($petsData as $pet) {
            $words = explode(' ', $pet['name']);
            
            foreach ($words as $word) {
                if (self::isPalindrome($word)) {
                    $palindromePets[] = $pet;
                }
            }
        }

        return $palindromePets;
    }

    public function isPalindrome(string $str): bool 
    {
        $str = preg_replace('/[^a-zA-Z]/', '', $str);
        $str = strtolower($str);

        return $str === strrev($str);
    }

    public function callbackAnswerSeven(Request $request)
    {
        try {
            $this->validate($request, [
                'numbers_data' => 'required|array',
                'numbers_data.*' => 'required|numeric',
            ], [
                'numbers_data.required' => 'Kolom numbers data diperlukan!',
                'numbers_data.array' => 'Nilai numbers data wajib array!',
                'numbers_data.*.required' => 'Kolom type new pet diperlukan!',
                'numbers_data.*.numeric' => 'Nilai numbers data wajib angka!',
            ]);

            $numbersData = $request->numbers_data;

            $getSumEvenNumbers = self::sumEvenNumbers($numbersData);

            return response()->json(
                FunctionHelpers::resSuccess(
                    [
                        'input' => $request->all(),
                        'output' => $getSumEvenNumbers
                    ]
                ), 
                200
            );
        } catch (Throwable $throwable) {
            $getStatusCode = $throwable instanceof HttpException
                ? $throwable->getStatusCode()
                : 500;

            return response()->json(
                FunctionHelpers::resError(
                    $throwable->getMessage(), 
                    $getStatusCode
                ), 
                $getStatusCode ?: 500
            );
        }
    }

    public function sumEvenNumbers(array $numbersData): array 
    {
        $evenNumbers = array_filter($numbersData, function($num) {
            return $num % 2 === 0;
        });

        return [
            'bilangan_genap' => implode(', ', $evenNumbers),
            'total_bilangan_genap' => array_sum($evenNumbers)
        ];
    }

    public function callbackAnswerEight(Request $request)
    {
        try {
            $this->validate($request, [
                'string_1' => 'required',
                'string_2' => 'required',
            ], [
                'string_1.required' => 'Kolom word 1 diperlukan!',
                'string_2.required' => 'Kolom word 2 diperlukan!',
            ]);

            $checkIsAnagram = self::isAnagram([
                'string_1' => $request->string_1,
                'string_2' => $request->string_2
            ]);

            $descriptionAnagram = 'String ' . $request->string_1 . ' & ' . $request->string_2 . ' adalah ';

            if ($checkIsAnagram) {
                $descriptionAnagram .= 'anagram.';
            } else {
                $descriptionAnagram .= 'bukan anagram!';
            }

            return response()->json(
                FunctionHelpers::resSuccess(
                    [
                        'input' => $request->all(),
                        'output' => $descriptionAnagram
                    ]
                ), 
                200
            );
        } catch (Throwable $throwable) {
            $getStatusCode = $throwable instanceof HttpException
                ? $throwable->getStatusCode()
                : 500;

            return response()->json(
                FunctionHelpers::resError(
                    $throwable->getMessage(), 
                    $getStatusCode
                ), 
                $getStatusCode ?: 500
            );
        }
    }

    public function isAnagram(array $wordsData): bool 
    {
        $str1 = strtolower(str_replace(' ', '', $wordsData['string_1']));
        $str2 = strtolower(str_replace(' ', '', $wordsData['string_2']));
        
        if (strlen($str1) !== strlen($str2)) {
            return false;
        }
        
        $arr1 = str_split($str1);
        $arr2 = str_split($str2);
        
        sort($arr1);
        sort($arr2);
        
        return $arr1 === $arr2;
    }

    public function callbackAnswerNine(Request $request)
    {
        try {
            $file_name = 'case.json';
            $path = public_path($file_name);

            if (!File::exists($path)) {
                return response()->json(
                    FunctionHelpers::resError(
                        'File ' . $file_name . ' not found!', 
                        404
                    ), 
                    404
                );
            }

            $caseContent = File::get($path);
            $caseJsonData = json_decode($caseContent, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json(
                    FunctionHelpers::resError(
                        'Invalid JSON format!', 
                        400
                    ), 
                    400
                );
            }

            $transformData = self::transformData($caseJsonData);

            return response()->json(
                FunctionHelpers::resSuccess(
                    [
                        'input' => $request->all(),
                        'output' => $transformData
                    ]
                ), 
                200
            );
        } catch (Throwable $throwable) {
            $getStatusCode = $throwable instanceof HttpException
                ? $throwable->getStatusCode()
                : 500;

            return response()->json(
                FunctionHelpers::resError(
                    $throwable->getMessage(), 
                    $getStatusCode
                ), 
                $getStatusCode ?: 500
            );
        }
    }

    public function transformData(array $caseData): array
    {
        $result = [
            'total' => 0,
            'data' => []
        ];

        $categories = [];

        if (!empty($caseData['data'])) {
            foreach ($caseData['data'] as $item) {
                $category = $item['category'];
                $code = $item['code'];
                $name = $item['name'];
                $total = $item['total'];

                if (!isset($categories[$category])) {
                    $categories[$category] = [
                        'category' => $category,
                        'total' => 0,
                        'data' => []
                    ];
                }

                if (!isset($categories[$category]['data'][$code])) {
                    $categories[$category]['data'][$code] = [
                        'total' => 0,
                        'data' => []
                    ];
                }

                $categories[$category]['data'][$code]['data'][] = [
                    'name' => $name,
                    'total' => $total
                ];

                $categories[$category]['data'][$code]['total'] += $total;
                $categories[$category]['total'] += $total;
                $result['total'] += $total;
            }
        }

        $result['data'] = array_values($categories);

        return $result;
    }

}
