<?php

namespace App\Http\Controllers;
use App\Models\Certipeid;
use App\Models\Dni;
use App\Models\User;
use App\Models\Location;
use Illuminate\Routing\Route;
use Validator;
use Datetime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PDF;
use Storage;
//use mikehaertl\wkhtmlto\Pdf;

class AdminController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Redirect to the admin view
     *
     *  Return to admin view with some main params.
     */
    public function index() {

        $all_dni = Dni::all()->count();
        $all_user = User::all()->count();
        $first_creation = Dni::select('*')->orderBy('date_enrollment_pet','ASC')->first();
        $formated_first_creations1 = $first_creation->date_enrollment_pet;
        $formated_first_creations = strtotime($formated_first_creations1);
        $day1 = date('d', $formated_first_creations);
        $WeekDay1 = date('w', $formated_first_creations);
        $numberDay1 = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
        $getSpanishDay1 = $numberDay1[$WeekDay1];
        $getNumberDay1 = date('d',$formated_first_creations);
        $getNumberMonth1 = date('n', $formated_first_creations);
        $numberMonth1 = array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
        "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $getYearDay1 = date('Y',$formated_first_creations);
        $getSpanishMonth1 = $numberMonth1[$getNumberMonth1];
        $firstDniGeneratedMessage1 = $getSpanishDay1." ".$getNumberDay1." de ".$getSpanishMonth1." del ".$getYearDay1."";

        // The last Dni created about DNI
        $last_creation = Dni::select('created_at')->orderBy('created_at','DESC')->first();
        $formated_last_creations = strtotime($last_creation->created_at);
        $day2 = date('d',$formated_last_creations);
        $WeekDay2 = date('w', $formated_last_creations);
        $numberDay2 = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
        $getSpanishDay2 = $numberDay2[$WeekDay2];
        $getNumberDay2 = date('d',$formated_last_creations);
        $getNumberMonth2 = date('n', $formated_last_creations);
        $numberMonth2 = array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
        "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $getYearDay2 = date('Y',$formated_last_creations);
        $getSpanishMonth2 = $numberMonth2[$getNumberMonth2];
        $Hour2 = date('H',$formated_last_creations);
        $Meridiem2 = date('a',$formated_last_creations);
        $minutes2 = date('i', $formated_last_creations);
        $lastDniGeneratedMessage1 = $getSpanishDay2." ".$getNumberDay2." de ".$getSpanishMonth2." del ".$getYearDay2." [Hora: ".$Hour2.":"."$minutes2 ". $Meridiem2."]";
        $species = DB::table('dnis')
        ->select(
        DB::raw('specie_type_pet as course'),
        DB::raw('count(*) as number'))
        ->groupBy('course')
        ->get();
        $array[] = ['Course', 'Number'];
        foreach($species as $key => $value){
            $array[++$key] = [$value->course, $value->number];
        }

        $orders = Location::select('region_department_or_state_extra_information',DB::raw('region_department_or_state_extra_information as record'),
        DB::raw('count(*) as number'))
        ->where('country_name_extra_information','=','Peru')
        ->groupBy('record')
        ->orderBy('number','ASC')
        //->take(-5)
        //->limit(5)
        ->get()->toArray();

        
        $department = array_column($orders,'record');
        $amount= array_column($orders,'number');

        /*$course = json_encode($array);
        dd($course);*/

        //dd($amount);
        return view('admin',compact('all_dni', 'all_user', 'first_creation', 'last_creation','firstDniGeneratedMessage1', 'lastDniGeneratedMessage1'))->with('course', json_encode($array))->with('department',json_encode($department))->with('amount',json_encode($amount,JSON_NUMERIC_CHECK));
    }

    /**
     * Delete dni data to a specific DNI.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDniData($id) {
        $dni = Dni::where('dni_number_pet', $id)->get();
        $dni_delete = Dni::where('dni_number_pet', $id);
        $certipeid_delete = Certipeid::where('dni_number_pet', $id);
        $file = resource_path() . '/assets/images/dni/'.$dni[0]->dni_number_pet. '.png';
        $file2 = resource_path() . '/assets/images/dni/'.$dni[0]->dni_number_pet. '_1.png';
        if(File::exists($file) && File::exists($file2)) {
            File::delete($file);
            File::delete($file2);
            $dni_delete->delete();
            $certipeid_delete->delete();
            return back()->with('True','El registro se borró con éxito');
        } else {
            $dni_delete->delete();
            $certipeid_delete->delete();
            return back()->with('True','El registro se borró con éxito');
        }
    }

    /**
     * Obtaining the DNI data depends on the selected value
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getDniData(Request $request) {

        $json = Storage::disk('local')->get('species.json');
        $json_main = json_decode($json,true);
        //$json = json_decode($json->content(),true);
        $json = $json_main[1]['breeds'][5];
        $json2 = $json_main[1]['breeds'];
        $json2 = $json2[18];
        $json3 = $json_main[1]['breeds'];
        //dd($json3);
        $array_image = [];
        $texto = trim($request->get('texto'));
        $select = trim($request->get('select'));
        $first_date = $request->get('first_date');
        $last_date = $request->get('last_date');
        if(isset($first_date) && isset($last_date)) {
            $dnis= Dni::select('*')
                ->whereBetween('created_at', [$first_date, $last_date])
                ->paginate(100);
        $dni_count= Dni::select('*')
            ->whereBetween('created_at', [$first_date, $last_date])
            ->count();
        for($i = 0; $i < count($dnis); $i++) {
            $path_file = resource_path() . "/assets/images/dni/" .$dnis[$i]->dni_number_pet.'.png';
            array_push($array_image,base64_encode(file_get_contents($path_file )));
        }
        return view('adminreports',['json3' => $json3,],compact('dnis', 'dni_count', 'array_image'));
        }else if($texto == '') {
            if($select == 'today') {
                $date_now = date('Y-m-d');
                $dni_count  = DB::table('dnis')
                    ->select('dnis.*')
                    ->where('date_enrollment_pet', $date_now)
                    ->orderBy('created_at', 'DESC')
                    ->count();
                $dnis = DB::table('dnis')
                    ->select('dnis.*')
                    ->where('date_enrollment_pet', $date_now)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(100);
            for($i = 0; $i < count($dnis); $i++) {
                $path_file = resource_path() . "/assets/images/dni/" .$dnis[$i]->dni_number_pet.'.png';
                array_push($array_image,base64_encode(file_get_contents($path_file )));
                }
                return view('adminreports',['json3' => $json3,],compact('dnis', 'dni_count', 'array_image'));
            }else if($select == 'duplicated_pet') {
            $dnis = DB::table('dnis')
            ->select('*')
            ->whereIn('name_pet', function ($q) {
            $q->select('name_pet')
            ->from('dnis')
            ->groupBy('name_pet', 'lastname_pet','date_enrollment_pet')
            ->havingRaw('COUNT(*) > 1');
            })->whereIn('lastname_pet', function($r) {
            $r->select('lastname_pet')
            ->from('dnis')
            ->groupBy('name_pet','lastname_pet','date_enrollment_pet')
            ->havingRaw('COUNT(*) > 1');
            })->whereIn('date_enrollment_pet', function($s) {
            $s->select('date_enrollment_pet')
            ->from('dnis')
            ->groupBy('name_pet','lastname_pet','date_enrollment_pet')
            ->havingRaw('COUNT(*) > 1');
            })
            ->orderby('name_pet','DESC')
            ->orderby('lastname_pet','DESC')
            ->orderby('date_enrollment_pet','DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate(100);
            $dni_count = DB::table('dnis')
            ->select('*')
            ->whereIn('name_pet', function ($q) {
            $q->select('name_pet')
            ->from('dnis')
            ->groupBy('name_pet', 'lastname_pet','date_enrollment_pet')
            ->havingRaw('COUNT(*) > 1');
            })->whereIn('lastname_pet', function($r) {
            $r->select('lastname_pet')
            ->from('dnis')
            ->groupBy('name_pet','lastname_pet','date_enrollment_pet')
            ->havingRaw('COUNT(*) > 1');
            })->whereIn('date_enrollment_pet', function($s) {
            $s->select('date_enrollment_pet')
            ->from('dnis')
            ->groupBy('name_pet','lastname_pet','date_enrollment_pet')
            ->havingRaw('COUNT(*) > 1');
            })
            ->count();
            $array_image = [];
          for($i = 0; $i < count($dnis); $i++) {
            $path_file = resource_path() . "/assets/images/dni/" .$dnis[$i]->dni_number_pet.'.png';
            array_push($array_image,base64_encode(file_get_contents($path_file )));
          }
            return view('adminreports', ['json3' => $json3,],compact('dnis', 'dni_count', 'array_image','select'));
            }
            $dni_count  = DB::table('dnis')
                ->select('dnis.*')
                ->orderBy('created_at', 'DESC')
                ->count();
            $dnis = DB::table('dnis')
                ->select('dnis.*')
                ->orderBy('created_at', 'DESC')
                ->paginate(100);
            for($i = 0; $i < count($dnis); $i++) {
                $path_file = resource_path() . "/assets/images/dni/" .$dnis[$i]->dni_number_pet.'.png';
                array_push($array_image,base64_encode(file_get_contents($path_file)));
            }
           return view('adminreports', ['json3' => $json3,], compact('dnis', 'dni_count', 'array_image'));
        } else {
            $dni_count = DB::table('dnis')
                ->select('dnis.*')
                ->where($select,'LIKE','%'.$texto.'%')
                ->orderBy('created_at', 'DESC')
                ->count();
            $dnis = DB::table('dnis')
                ->select('dnis.*')
                ->where($select,'LIKE','%'.$texto.'%')
                ->orderBy('created_at', 'DESC')
                ->paginate(100);
            $array_image = [];
            for($i = 0; $i < count($dnis); $i++) {
                $path_file = resource_path() . "/assets/images/dni/" .$dnis[$i]->dni_number_pet.'.png';
                array_push($array_image,base64_encode(file_get_contents($path_file)));
            }
            return view('adminreports', ['json3' => $json3,],compact('dnis','select','texto', 'dni_count', 'array_image'));
        }
    }

    /**
     * Edit dni data to a specific DNI.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editDniData(Request $request) {
        $dni = Dni::where('dni_number_pet', $request->id)->first();
        $validator = Validator::make($request->all(),[
            'name_pet' => 'required',
            'lastname_pet' => 'required',
            'gender_pet' => 'required',
            'specie_type_pet' => 'required',
            'lastname_owner' => 'required',
            'name_owner' => 'required',
            'cellphone_owner' => 'required',
            'email_owner' => 'required'
        ]);
        if($validator->fails()) {
            return back()
                ->withInput()
                ->with('ErrorEdit','Llenar la data')
                ->withErrors($validator);
        } else {
            $dni->name_pet = $request->name_pet;
            $dni->lastname_pet = $request->lastname_pet;
            $dni->gender_pet = $request->gender_pet;
            $dni->specie_type_pet = $request->specie_type_pet;
            $dni->lastname_owner = $request->lastname_owner;
            $dni->name_owner = $request->name_owner;
            $dni->cellphone_owner = $request->cellphone_owner;
            $dni->email_owner = $request->email_owner;
            $dni->breed_pet = $request->breed_pet;
            $dni->update();
            return back()->with('True', 'Se ha editado el dni correctamente');
        }
    }
    // @TODO: Modified this function to get a specific data in pdf report
    public function printAllDnis() {
        ini_set('max_execution_time', 180);
        $all_dni = Dni::all();
        $date_now = date('Y-m-d');
        $data = compact('all_dni', 'date_now');
        $pdf = PDF::loadView('pdf.reporte', $data);
        return $pdf->download('reporte_dni.pdf');
    }
    /**
     * Export Data downloading with .csv File
     *
     * return 0 Params
     *
    */
    public function getDnisCsv4() {
        $fileName = 'Peid_data_new.csv';
        //$all_dni = Dni::all();
        $all_dni = Dni::select('dnis.*','dnis.date_enrollment_pet as drolment','locations.ip_extra_information','locations.country_code_extra_information','locations.country_name_extra_information','region_department_or_state_extra_information','province_extra_information','district_extra_information')
        ->join('locations','dnis.dni_number_pet', '=', 'locations.dni_number_pet')
        ->get();
        //dd($all_dni); 
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $columns = array('Número de DNI - Mascota', 'Tipo de DNI - Mascota', 'Apellido - Mascota', 'Nombre(s) - Mascota', 'Cumpleaños - Mascota', 'Fecha de Inscripción - Mascota', 'Fecha de Emisión', 'Fecha de Expiración', 'Género', 'Especie', 'Raza', 'Apellido - Dueño', 'Nombre - Dueño', 'Código País', 'Teléfono - Dueño', 'Email - Dueño', 'Creación', 'Última Actualización', 'Dirección IP', 'Código de País', 'Nombre de País', 'Región/Departamento/Estado', 'Provincia', 'Distrito');
        $callback = function() use($all_dni, $columns){
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($all_dni as $data){
                $row['Número de DNI - Mascota'] = $data->dni_number_pet;
                $row['Tipo de DNI - Mascota'] = $data->dni_type_pet;
                $row['Apellido - Mascota'] = $data->lastname_pet;
                $row['Nombre(s) - Mascota'] = $data->name_pet;
                $row['Cumpleaños - Mascota'] = $data->birthday_pet;
                $row['Fecha de Inscripción - Mascota'] = $data->date_enrollment_pet;
                $row['Fecha de Emisión'] = $data->date_issue_pet;
                $row['Fecha de Expiración'] = $data->date_expiry_pet;
                $row['Género'] = $data->gender_pet;
                $row['Especie'] = $data->specie_type_pet;
                $row['Raza'] = $data->breed_pet;
                $row['Apellido - Dueño'] = $data->lastname_owner;
                $row['Nombre - Dueño'] = $data->name_owner;
                $row['Código País'] = $data->country_code;
                $row['Teléfono - Dueño'] = $data->cellphone_owner;
                $row['Email - Dueño'] = $data->email_owner;
                $row['Creación'] = $data->created_at;
                $row['Última Actualización'] = $data->updated_at;
                $row['Dirección IP'] = $data->ip_extra_information;
                $row['Código de País'] = $data->country_code_extra_information;
                $row['Nombre de País'] = $data->country_name_extra_information;
                $row['Región/Departamento/Estado'] = $data->region_department_or_state_extra_information;
                $row['Provincia'] = $data->province_extra_information;
                $row['Distrito'] = $data->district_extra_information;

                fputcsv($file, array($row['Número de DNI - Mascota'],$row['Tipo de DNI - Mascota'],$row['Apellido - Mascota'],$row['Nombre(s) - Mascota'],$row['Cumpleaños - Mascota'],$row['Fecha de Inscripción - Mascota'],$row['Fecha de Emisión'],$row['Fecha de Expiración'],$row['Género'],$row['Especie'],$row['Raza'],$row['Apellido - Dueño'],$row['Nombre - Dueño'],$row['Código País'],$row['Teléfono - Dueño'],$row['Email - Dueño'],$row['Creación'],$row['Última Actualización'],$row['Dirección IP'],$row['Código de País'],$row['Nombre de País'],$row['Región/Departamento/Estado'],$row['Provincia'],$row['Distrito']));

            }
                fclose($file);
        };
                return Response()->stream($callback, 200, $headers);
    }
    /**
     * 
     * Basic function for working with resource route in web.php 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $dni = Dni::find($id)->get();
        $file = resource_path() . '/assets/images/dni/'.$dni[0]->dni_number_pet. '.png';
        $file2 = resource_path() . '/assets/images/dni/'.$dni[0]->dni_number_pet. '_1.png';
        $file3 = resource_path() . '/assets/images/generate/certipeid/qr/'.$dni[0]->dni_number_pet. '.png';
        if(File::exists($file) && File::exists($file2) && File::exists($file3)) {
            File::delete($file);
            File::delete($file2);
            File::delete($file3);
            $dni_delete = Dni::find($id)->delete();
           $certipeid_delete = Certipeid::where('dni_number_pet',$id)->delete();
           $location_delete = Location::where('dni_number_pet',$id)->delete();
            return response()->json(['success'=>'Post Deleted successfuly']);
        }else{
            $dni_delete = Dni::find($id)->delete();
            $certipeid_delete = Certipeid::where('dni_number_pet',$id)->delete();
            $location_delete = Location::where('dni_number_pet',$id)->delete();
            return response()->json(['success'=>'Post Deleted successfuly']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = Dni::select('dnis.*','dnis.date_enrollment_pet as drolment','locations.ip_extra_information','locations.country_code_extra_information','locations.country_name_extra_information','region_department_or_state_extra_information','province_extra_information','district_extra_information')
        ->join('locations','dnis.dni_number_pet', '=', 'locations.dni_number_pet')
        ->orderBy('created_at', 'desc')
        ->where('dnis.dni_number_pet',$id)
        ->get();
        foreach($result as $data){
        $dni = [
         'dni_number_pet'=> $data->dni_number_pet,
         'lastname_pet'=>$data->lastname_pet,
         'name_pet'=>$data->name_pet,   
         'ip_extra_information' => $data->ip_extra_information,
         'birthday_pet' => $data->birthday_pet,
         'gender_pet' => $data->gender_pet,
         'name_owner' => $data->name_owner,
         'cellphone_owner' => $data->cellphone_owner,
         'email_owner' => $data->email_owner,
         'lastname_owner' => $data->lastname_owner,
         'specie_type_pet' => $data->specie_type_pet,
         'breed_pet' => $data->breed_pet,
         'dni_type_pet' => $data->dni_type_pet,
         'date_enrollment_pet' => $data->date_enrollment_pet,
         'ip_extra_information' => $data->ip_extra_information,
         'country_code_extra_information' => $data->country_code_extra_information,
         'country_name_extra_information' => $data->country_name_extra_information,
         'region_department_or_state_extra_information' =>$data->region_department_or_state_extra_information,
         'province_extra_information' => $data->province_extra_information,
         'district_extra_information' => $data->district_extra_information,
        ];
    }

       return response()->json($dni);
    }

    /**
     * TO DO: Upgrade the function in select option.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchYourBreed($breed_id=0) {
       
    $json = Storage::disk('local')->get('species.json');
    $json_main = json_decode($json,true);

    $json33['data'] = $json_main[$breed_id]['breeds'];

    return response()->json($json33);

    }

    /**
     * TO DO: Download the Dashboard from this function in the controller
     * 
     * this is loading a new View in dashboard-report for to download in pdf
     * 
     */
    public function pdfLoadView() {
        $all_dni = Dni::all()->count();
        $species = DB::table('dnis')
        ->select(
        DB::raw('specie_type_pet as course'),
        DB::raw('count(*) as number'))
        ->groupBy('course')
        ->get();
        $array[] = ['Course', 'Number'];
        foreach($species as $key => $value){
            $array[++$key] = [$value->course, $value->number];
        }

        $orders = Location::select('region_department_or_state_extra_information',DB::raw('region_department_or_state_extra_information as record'),
        DB::raw('count(*) as number'))
        ->where('country_name_extra_information','=','Peru')
        ->groupBy('record')
        ->orderBy('number','ASC')
        ->get()->toArray();

        $department = array_column($orders,'record');
        $amount= array_column($orders,'number');
        $course = json_encode($array);
        $department = json_encode($department);
        $amount = json_encode($amount,JSON_NUMERIC_CHECK);

     return view('pdf/dashboard-report',compact('all_dni','course','department','amount'));
    }

}