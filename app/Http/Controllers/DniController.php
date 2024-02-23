<?php

namespace App\Http\Controllers;

use App\Models\Certipeid;
use App\Models\Dni;
use App\Models\Location;
use App\Models\User;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use claviska\SimpleImage;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class DniController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }


    public function create() {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $rules =
            [
                'email_owner' => 'required|email',
                'url_image_pet' => 'required|image'
            ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()],400);
        }
        // $duplicated_data= Dni::where('lastname_pet' ,$request->lastname_pet)->where('name_pet' ,$request->name_pet)->get();
        // if(!$duplicated_data->isEmpty()) {
        //     return response()->json(['Message' => 'La mascota ya ha sido registrada anteriormente'],404);
        // }
        $dni_number = $this->generateDni(8);
        $dni_hash = Hash::make($dni_number);
        $img_pet = $dni_number.'.png';
        $img_pet2 = $dni_number.'_1.png';
        $date_now = date('Y-m-d');
        $date_issue =date('Y-m-d',strtotime(date('Y-m-d')));
        $date_expiry=date('Y-m-d',strtotime(date('Y-m-d')."+ 1 year"));
        $phone_number = $request->country_code.$request->cellphone_owner;
        $path = resource_path() . '/assets/images/dni/' . $img_pet;
        $path2 = resource_path() . '/assets/images/dni/' . $img_pet2 ;
        Image::make($request->file('url_image_pet'))
            ->resize(150, 150)
            ->save($path);
        Image::make($request->file('url_image_pet'))
            ->resize(65, 65)
            ->save($path2);
        $dni =  Dni::create([
            'dni_number_pet' => $dni_number,
            'dni_type_pet' => $request->dni_type_pet,
            'lastname_pet' => $request->lastname_pet,
            'name_pet' => $request->name_pet,
            'url_image_pet' => '/assets/images/dni/'.$img_pet,
            'birthday_pet' => $request->birthday_pet,
            'date_enrollment_pet' => $date_now,
            'date_issue_pet' => $date_issue,
            'date_expiry_pet' => $date_expiry,
            'gender_pet' =>  $request->gender_pet,
            'specie_type_pet' => $request->specie_type_pet,
            'breed_pet' =>  $request->breed_pet,
            'lastname_owner' =>  $request->lastname_owner,
            'name_owner' => $request->name_owner,
            'country_code' => $request->country_code,
            'cellphone_owner' =>  $phone_number,
            'email_owner' => $request->email_owner,
            'dni_hash' => $dni_hash,
            'dni_share' => $dni_number
        ]);

        Certipeid::create([
            'type_certipeid' => 'free',
            'subtype_certipeid' => 'inscription',
            'lastname_pet' => $request->lastname_pet,
            'name_pet' => $request->name_pet,
            'url_image_pet' => '/assets/images/dni/'.$img_pet,
            'birthday_pet' => $request->birthday_pet,
            'gender_pet' =>  $request->gender_pet,
            'specie_type_pet' => $request->specie_type_pet,
            'breed_pet' =>  $request->breed_pet,
            'lastname_owner' =>  $request->lastname_owner,
            'name_owner' => $request->name_owner,
            'country_code' => $request->country_code,
            'cellphone_owner' =>  $phone_number,
            'email_owner' => $request->email_owner,
            'dni_number_pet' => $dni_number,
            'dni_type_pet' => $request->dni_type_pet,
            'date_enrollment_pet' => $date_now,
            'date_issue_pet' => $date_issue,
            'date_expiry_pet' => $date_expiry
        ]);

        Location::create([
            'dni_number_pet' => $dni_number,
            'date_enrollment_pet' => $date_now,
            'lastname_pet' => $request->lastname_pet,
            'name_pet' => $request->name_pet,
            'lastname_owner' => $request->name_owner,
            'name_owner'  =>  $request->lastname_owner,
            'cellphone_owner' =>  $phone_number,
            'email_owner' => $request->email_owner,
            'ip_extra_information' => $request->ip_extra_information,
            'country_code_extra_information' => $request->country_code_extra_information,
            'country_name_extra_information' => $request->country_name_extra_information,
            'region_department_or_state_extra_information' => $request->region_department_or_state_extra_information,
            'province_extra_information' => $request->province_extra_information,
            'district_extra_information' => $request->district_extra_information
        ]);

        return response()->json($dni,200);
    }

    /**
     * Check if the dni value is valid or invalid.
     *
     * @param $dni_number
     * @return string
     */
    public function checkValidDni($dni_number) {
        $dni = Dni::where('dni_number_pet' ,$dni_number)->get();
        if($dni->isEmpty()) {
            return false;
        }
        return true;
    }
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll($hash) {
        if($hash != 'x@PEID2021@_103061707773974@x') {
            return response()->json(['Message' => 'Sin Autorización'],401);
        }
        $dni = Dni::all();
        return response()->json($dni,200);
    }

    public function getDniFront($dni_number) {
        $dni = Dni::where('dni_number_pet' ,$dni_number)->get();
        if($dni->isEmpty()) {
            return response()->json(['Message' => 'Dni not found'],404);
        }
        try {
            $dni_number_of = $dni[0]->dni_number_pet;
            $array_dni = str_split($dni_number_of);
            $array_numbers = ['0','1','2','3','4','5','6','7','8','9'];
            $result = array_intersect($array_dni,$array_numbers);
            $birthday_pet = date('d/m/Y',strtotime($dni[0]->birthday_pet));
            $date_enrollment_pet = date('d-m-Y',strtotime(date($dni[0]->date_enrollment_pet)));
            $date_issue_pet = date('d-m-Y',strtotime(date($dni[0]->date_issue_pet)));
            $date_expiry_pet = date('d-m-Y',strtotime(date($dni[0]->date_expiry_pet)));
            $name_order = $dni[0]->dni_number_pet;
            $name_order_new = implode(' ', str_split($name_order));
            $dni_number_pet_new = implode(' ', str_split($dni[0]->dni_number_pet));
            $image = new SimpleImage();
            $image->fromFile(resource_path() . '/assets/images/generate/dni/background3.png')
                ->autoOrient()
                ->resize(680,379)
                ->text($name_order_new.'  < < < < < < < < < < < < < < < < < < < < < < < <  ', [
                        'fontFile' => resource_path() . '/fonts/quickmedium.ttf',
                        'size' => 18,
                        'color' => '#000000',
                        'anchor' => 'top left',
                        'xOffset' => 30,
                        'yOffset' => 308,
                    ]
                )
                ->text(strtoupper($dni[0]->lastname_pet).' < < <  '.
                    strtoupper($dni[0]->name_pet).' < < < < < < < < < < <', [
                        'fontFile' => resource_path() . '/fonts/quickmedium.ttf',
                        'size' => 18,
                        'color' => '#000000',
                        'anchor' => 'top left',
                        'xOffset' => 30,
                        'yOffset' => 336,
                    ]
                )
                //REPUBLICA DEL PERÚ
                ->text(($dni[0]->specie_type_pet == 'Cat') || ($dni[0]->specie_type_pet == 'Dog') || ($dni[0]->specie_type_pet == 'Bird') || ($dni[0]->specie_type_pet == 'Lagomorph') || ($dni[0]->specie_type_pet == 'Marsupial') || ($dni[0]->specie_type_pet == 'Rodent') ? 'REPUBLIC OF PERU' : 'REPUBLICA DEL PERÚ', [
                        'fontFile' => resource_path() . '/fonts/montserratbold.ttf',
                        'size' => 22,
                        'color' => '#062825',
                        'anchor' => 'top left',
                        'xOffset' => 195,
                        'yOffset' => 35,
                    ]
                )
                ///< Dni number
                ->text($dni_number_pet_new. ' - 1 ', [
                        'fontFile' =>  resource_path() . '/fonts/quickmedium.ttf',
                        'size' => 18,               ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 506,
                        'yOffset' => 37
                    ]
                )
                ->overlay(resource_path() . '/assets/images/generate/dni/test.png', 'top left',1,252,90) ///< dni field
                ->text($dni[0]->lastname_pet, [  ///< dni field input - lastname
                        'fontFile' =>  resource_path() . '/fonts/quickmedium.ttf',
                        'size' => 15.8 ,                 ///< text-size
                        'color' => '#000000',
                        'anchor' => 'top left',
                        'xOffset' => 268,
                        'yOffset' => 99,
                    ]
                )
                ->overlay(resource_path() . '/assets/images/generate/dni/test.png', 'top left',1,252,139) ///< dni field
                ->text($dni[0]->name_pet, [  ///< dni field input - name
                        'fontFile' =>  resource_path() . '/fonts/quickmedium.ttf',
                        'size' => 15.8 ,                 ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 268,
                        'yOffset' => 148,
                    ]
                )
                ->overlay(resource_path() . '/assets/images/generate/dni/test_mini.png', 'top left',1,252,190) ///< dni field
                ->text($birthday_pet, [  ///< dni field input - date
                        'fontFile' =>  resource_path() . '/fonts/quickmedium.ttf',
                        'size' => 15.8 ,                 ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 268,
                        'yOffset' => 200,
                    ]
                )
                ->overlay(resource_path() . '/assets/images/generate/dni/test_mini.png', 'top left',1,375,190) ///< dni field
                ->text(ucwords($dni[0]->gender_pet), [  ///< dni field input - date
                        'fontFile' =>  resource_path() . '/fonts/quickmedium.ttf',
                        'size' => 15.8 ,                 ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 392,
                        'yOffset' => 200,
                    ]
                )
                ->overlay(resource_path() . '/assets/images/generate/dni/test.png', 'top left',1,252,240) ///< dni field
                ->text(ucwords(($dni[0]->breed_pet == '') || ($dni[0]->breed_pet == 'null')  ? $dni[0]->specie_type_pet : (($dni[0]->breed_pet == 'Otro') || ($dni[0]->breed_pet == 'Other') ? $dni[0]->specie_type_pet : $dni[0]->breed_pet )), [  // type of pet
                        'fontFile' =>  resource_path() . '/fonts/quickmedium.ttf',
                        'size' => 15.8 ,                 ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 268,
                        'yOffset' => 250,
                    ]
                )
                ///< Enrollment date
                ->text($date_enrollment_pet, [  // first date
                        'fontFile' => resource_path() . '/fonts/quickbold.ttf',
                        'size' => 10,               ///< text-size
                        'color' => '#062825',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 558,
                        'yOffset' => 118,
                    ]
                )
                ///< Date of issue
                ->text($date_issue_pet, [  // first date
                        'fontFile' => resource_path() . '/fonts/quickbold.ttf',
                        'size' => 10,               ///< text-size
                        'color' => '#062825',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 558,
                        'yOffset' => 156,
                    ]
                )
                ///< Date of expiry
                ->text($date_expiry_pet, [  ///< first date
                        'fontFile' =>  resource_path() . '/fonts/quickbold.ttf',
                        'size' => 10,               ///< text-size
                        'color' => '#062825',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 558,
                        'yOffset' => 196,
                    ]
                )
                ->overlay(($dni[0]->specie_type_pet == 'Cat') || ($dni[0]->specie_type_pet == 'Dog') || ($dni[0]->specie_type_pet == 'Bird') || ($dni[0]->specie_type_pet == 'Lagomorph') || ($dni[0]->specie_type_pet == 'Marsupial') || ($dni[0]->specie_type_pet == 'Rodent') ? resource_path() . '/assets/images/generate/dni/panel2_black_en.png' : resource_path() . '/assets/images/generate/dni/panel2_black.png'
                    , 'top left',1,528,90) ///< dates panel
                ->overlay(resource_path() . '/assets/images/dni/'.$dni[0]->dni_number_pet. '_1.png', 'top left',1,552,230) ///< dni secondary image bottom
                ->overlay(resource_path() . '/assets/images/dni/'.$dni[0]->dni_number_pet. '.png', 'top left',1,68,92) /// < dni main image
                ->overlay(resource_path() . '/assets/images/generate/dni/number/' . $result[0] .'.png', 'top left',1,25,95)
                ->overlay(resource_path(). '/assets/images/generate/dni/number/' . $result[1] .'.png', 'top left',1,25,115)
                ->overlay(resource_path() . '/assets/images/generate/dni/number/' . $result[2] .'.png', 'top left',1,25,135)
                ->overlay(resource_path() . '/assets/images/generate/dni/number/' . $result[3] .'.png', 'top left',1,25,155)
                ->overlay(resource_path() . '/assets/images/generate/dni/number/' . $result[4] .'.png', 'top left',1,25,175)
                ->overlay(resource_path() . '/assets/images/generate/dni/number/' . $result[5] .'.png', 'top left',1,25,195)
                ->overlay(resource_path() . '/assets/images/generate/dni/number/' . $result[6] .'.png', 'top left',1,25,215)
                ->overlay(resource_path() . '/assets/images/generate/dni/number/' . $result[7] .'.png', 'top left',1,25,235)
                ->toScreen();
            //-> toDownload('dni_front_'.$dni[0]->dni_number_pet.'.png', null, 100);
        } catch(Exception $err) {
            echo $err->getMessage();
        }
        // return $dni[0]->name_pet;
    }

    public function getDniBack($dni_number) {

        $dni = Dni::where('dni_number_pet', $dni_number)->get();
        if ($dni->isEmpty()) {
            return response()->json(['Message' => 'Dni not found'], 404);
        }
        $path_qr = resource_path() . '/assets/images/generate/dni/qr/'.$dni[0]->dni_number_pet.'.jpg';
        $name_order = $dni[0]->dni_number_pet;
        $name_order_new = implode(' ', str_split($name_order));
        if(@getimagesize($path_qr) == 0) {
            $this->createQrCode($dni[0]->dni_number_pet);
        }

        try {
            $image = new SimpleImage();
            $name_order = $dni[0]->dni_number_pet;
            $image
                ->fromFile(resource_path() . '/assets/images/generate/dni/background3.png')
                ->autoOrient()                           ///<
                ->autoOrient()                           ///< adjust orientation
                ->resize(660,379)
                ->text(($dni[0]->specie_type_pet == 'Cat') || ($dni[0]->specie_type_pet == 'Dog') || ($dni[0]->specie_type_pet == 'Bird') || ($dni[0]->specie_type_pet == 'Lagomorph') || ($dni[0]->specie_type_pet == 'Marsupial') || ($dni[0]->specie_type_pet == 'Rodent') ? 'REPUBLIC OF PERU' : 'REPUBLICA DEL PERÚ', [
                        'fontFile' => resource_path() . '/fonts/montserratbold.ttf',
                        'size' => 22,
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 190,
                        'yOffset' => 36,
                    ]
                )
                ->overlay(resource_path() . '/assets/images/generate/dni/test_back.png', 'top left',1,55,92) ///< dni field
                ->text(ucwords($dni[0]->lastname_owner), [  // type of pet
                        'fontFile' =>  resource_path() . '/fonts/quickmedium.ttf',
                        'size' => 15.8 ,                 ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 72,
                        'yOffset' => 102,
                    ]
                )
                ->overlay(resource_path() . '/assets/images/generate/dni/test_back.png', 'top left',1,55,142) ///< dni field
                ->text(ucwords($dni[0]->name_owner), [  // type of pet
                        'fontFile' =>  resource_path() . '/fonts/quickmedium.ttf',
                        'size' => 15.8 ,                 ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 72,
                        'yOffset' => 152,
                    ]
                )
                ->overlay(resource_path() . '/assets/images/generate/dni/test_back.png', 'top left',1,55,192) ///< dni field
                ->text(ucwords($dni[0]->cellphone_owner), [  // type of pet
                        'fontFile' =>  resource_path() . '/fonts/quickmedium.ttf',
                        'size' => 15.8 ,               ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 72,
                        'yOffset' => 202,
                    ]
                )
                ->overlay(resource_path() . '/assets/images/generate/dni/test_back.png', 'top left',1,55,242) ///< dni field
                ->text($dni[0]->email_owner, [  // type of pet
                        'fontFile' =>  resource_path() . '/fonts/quickmedium.ttf',
                        'size' => 15.8 ,               ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 72,
                        'yOffset' => 252,
                    ]
                )
                ->overlay(resource_path() . '/assets/images/dni/'.$dni[0]->dni_number_pet. '_1.png', 'top left',1,65,290) ///< dni field
                ->text($name_order_new.'  < < < < < < < < < < < < < < < < < <', [
                        'fontFile' =>  resource_path() . '/fonts/quickmedium.ttf',
                        'size' => 17,
                        'color' => '#000000',
                        'anchor' => 'top left',
                        'xOffset' => 150,
                        'yOffset' => 315,
                    ]
                )
                ->text(strtoupper($dni[0]->lastname_pet).' < < < '.
                    strtoupper($dni[0]->name_pet).' < < < < < < < < ', [  // first field
                        'fontFile' =>  resource_path() . '/fonts/quickmedium.ttf',
                        'size' => 17,               ///< text-size
                        'color' => '#000000',        ///< text-color
                        'anchor' => 'top left',
                        'xOffset' => 150,
                        'yOffset' => 340,
                    ]
                )
                ->overlay(resource_path() . '/assets/images/generate/dni/qr/'.$dni[0]->dni_number_pet.'.jpg', 'top left',1,384,78) ///< dni field
                ->toScreen();
        } catch(Exception $err) {
            echo $err->getMessage();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $dni_number_pet
     * @return json
     */
    public function show(int $dni_number_pet) {
        $dni = Dni::where('dni_number_pet' ,$dni_number_pet)->get();
        if($dni->isEmpty()) {
            return response()->json(['mesage' => 'Not found'],404);
        }
        return response()->json($dni,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Generate a dni random
     *
     * @param $longitud
     * @return string
     */
    public function generateDni($longitud) {
        $key = '';
        $pattern = '123456789';
        $max = strlen($pattern)-1;
        for($i=0;$i < $longitud;$i++) $key .= $pattern[
        mt_rand(0,$max)];
        return $key;
    }

    /**
     * Delete a specific value dni insert in the database
     *
     * @param $dni_number
     * @param $hash
     * @return \Illuminate\Http\JsonResponseç
     */
    public function deleteDnibyNumberAndHash($dni_number,$hash) {
        $dni = Dni::where('dni_number_pet', $dni_number)->get();
        $dnidl = Dni::where('dni_number_pet', $dni_number);
        $certipeiddl = Certipeid::where('dni_number_pet', $dni_number);
        if ($dni->isEmpty()) {
            return response()->json(['Message' => 'Dni no encontrado'], 404);
        }
        if($hash != 'x.DB123456789020202021.x') {
            return response()->json(['Message' => 'Sin Autorización'],401);
        }
        if($dni[0]->dni_number_pet) {
            $file = resource_path() . '/assets/images/dni/'.$dni[0]->dni_number_pet. '.png';
            $file2 = resource_path() . '/assets/images/dni/'.$dni[0]->dni_number_pet. '_1.png';
            if(File::exists($file) && File::exists($file2)) {
                File::delete($file);
                File::delete($file2);
                $dnidl->delete();
                $certipeiddl->delete();
                return response()->json(['Message' => 'Dni eliminado'], 200);
            } else {
                $dnidl->delete();
                $certipeiddl->delete();
                return response()->json(['Message' => 'Dni eliminado'], 200);
            }
        }
    }

    /**
     * Allows to download an image according to the type of request and the pet's DNI number
     *
     * @param $type_of_photo
     * @param $dni_number
     * @return mixed
     */
    public function downloadImage($type_of_photo,$dni_number) {
        $dni = Dni::where('dni_number_pet', $dni_number)->get();
        if ($dni->isEmpty()) {
            return response()->json(['Message' => 'Dni not found to search'], 404);
        }
        $url = 'https://back.peid.pet/api/';
        $filename_standard = 'www.peid.pet';
        $tempImage = tempnam(sys_get_temp_dir(), $filename_standard);
        $image = new SimpleImage();
        switch ($type_of_photo){
            case 'dni_front':
                $image->fromFile($url . $type_of_photo .'/' . $dni_number )
                    ->toDownload($filename_standard .'.png', null, 100);
                break;
            case 'dni_back':
                $image->fromFile($url . $type_of_photo .'/' . $dni_number )
                    ->toDownload($filename_standard .'.png', null, 100);
                break;
            case 'certipeid':
                $image->fromFile($url . $type_of_photo .'/' . $dni_number )
                    ->toDownload($filename_standard .'.png', null, 100);
                break;
        }
    }

    /**
     * Allow to create a qr code to an DNI
     *
     * @param $dni_number
     */
    public function createQrCode($dni_number) {
        $pet_qr_code = resource_path() . '/assets/images/generate/dni/qr/'.$dni_number.'.jpg';
        $base_path_local = 'http://127.0.0.1:8000/api/certipeid/'.$dni_number;
        $base_path_server = 'https://peid.pet/dni/'.$dni_number;
        copy("https://api.qrserver.com/v1/create-qr-code/?size=214x214&data=$base_path_server", $pet_qr_code);
    }

    public function getQrCode($dni_number) {

        $contextOptions = array(
            "ssl" => array(
                "verify_peer"      => false,
                "verify_peer_name" => false,
            ),
        );
        $pet_qr_code = resource_path() . '/assets/images/generate/dni/qr/'.$dni_number.'.jpg';

        $base_path_local = 'http://dev.back.peid.pet.localhost/api/certipeid/'.$dni_number;
        $base_path_server = 'https://peid.pet/dni/'.$dni_number;
        copy("https://api.qrserver.com/v1/create-qr-code/?size=214x214&data=$base_path_server", $pet_qr_code, stream_context_create($contextOptions));
        $image = new SimpleImage();
        $image->fromFile(resource_path() . '/assets/images/generate/dni/qr/'.$dni_number.'.jpg')
        -> toDownload('qr_'.$dni_number, null, 100);
}

public function getImage($dni_number) {

    $image = new SimpleImage();
    $image->fromFile(resource_path() . '/assets/images/dni/'.$dni_number.'.png')
    -> toDownload('photo_'.$dni_number, null, 100);
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

    }
}

