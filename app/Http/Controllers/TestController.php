<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dni;
use App\Models\Person;
use Illuminate\Support\Facades\DB;
use App\Mail\TestMail;
use Mail;

class TestController extends Controller
{
  public function gmails() {
    //return ["Hoals"];
    //$users = Dni::select('email_owner')->distinct()->get();
  //$users = Dni::all()->unique('email_owner');
  //$users = DB::table('dnis')->get();
 /* $users = DB::table('dnis')
  ->distinct()
  ->count('email_owner');*/
  //$s = Dni::all();


 // $s = Dni::select('email_owner')->distinct()->get();
/* $s = DB::table('dnis')
 ->select('email_owner')
 ->get()
 ->keyBy(function($user){
       return $user->name_pet . '-' . $user->dni_number_pet;
  });*/

  $s=Dni::all()->unique('email_owner');

  //$s = Dni::select('email_owner')->distinct
  //dd($s);

    /**
     * Comprobación para saber si un usuario ha sido encontrado para generar un usuario o no mediante el correo electrónico
    */

  foreach(Dni::all()->unique('email_owner') as $filas) {
     echo 'la mascota del correo '.$filas->email_owner.' es '.$filas->gender_pet;
     //if (Person::where('email', '=', 'lmendoza27@autonoma.edu.pe')->exists()) {
        if (Person::where('email', '=', $filas->email_owner)->exists()) {
        echo " (Usuario encontrado)";
     }else {
         echo " (Usuario no encontrado) / Se creará el siguiente usuario:".strstr($filas->email_owner, '@', true);
           /* if (strstr($filas->email_owner, '@', true)->exists()) {
                echo "Usuario existente";
            }else {
                echo "No se ha";
            }*/
            //echo count(strstr($filas->email_owner, '@', true));
            if (Person::where('username', '=', strstr($filas->email_owner, '@', true) )->exists()) {

               //echo " Este nombre de usuario ya existe";
               $person = new Person;
               $person->lastname = $filas->lastname_owner;
               $person->name = $filas->name_owner;
               $person->number = $filas->cellphone_owner;
               $person->email = $filas->email_owner;
               $person->password = "dadasdasdadadqw";
               $person->description = "Apuestas p";
               $person->years_old = 21;
               //$person->username = strtoupper(substr($filas->lastname_owner, 0, 1)).strstr($filas->email_owner, '@', true);
               $person->username = substr($filas->name_owner, 0, 2).strstr($filas->email_owner, '@', true).substr($filas->dni_number_pet, 0, 3);
               $person->save();
               /*$details = [
                'title' => 'Tu cuenta de PEID ha sido generada, muchas gracias',
                'body' => 'A continuación te dejamos el nombre de usuario generado: '.$person->username.' y la contraseña a generar se presenta en el siguiente enlace'];
                \Mail::to($person->email)->send(new \App\Mail\MyTestMail($details));*/
                $data = ['name' => $person->username, 'nombre' => $person->name, 'apellido' => $person->lastname];
                Mail::to($person->email)->send(new TestMail($data));

            }else {
                //echo "Este nombre de usuario no existe";
                $person = new Person;
                $person->lastname = $filas->lastname_owner;
                $person->name = $filas->name_owner;
                $person->number = $filas->cellphone_owner;
                $person->email = $filas->email_owner;
                $person->password = "dadasdasdadadqw";
                $person->description = "Apuestas p";
                $person->years_old = 21;
                $person->username = strstr($filas->email_owner, '@', true);
                $person->save();
                /*$details = [
                  'title' => 'Tu cuenta de PEID ha sido generada, muchas gracias',
                  'body' => 'A continuación te dejamos el nombre de usuario:'.$person->username.' y la contraseña a generar se presenta en el siguiente enlace'];
                  \Mail::to($person->email)->send(new \App\Mail\MyTestMail($details));*/
                  $data = ['name' => $person->username, 'nombre' => $person->name, 'apellido' => $person->lastname];
                  Mail::to($person->email)->send(new TestMail($data));
            }
     }
    echo '<br>';

  }



    //echo $duplicates;

  /*$s = 'Posted On April 6th By Some Dude';
  echo strstr($s, 'By', true);*/
  
  /*$person = new Person;
  $person->lastname = "Mendoza Chate";
  $person->name = "Luis Angel";
  $person->number = "962504669";
  $person->email = "lmendoza27@autonoma.edu.pe";
  $person->password = "dadasdasdadadqw";
  $person->description = "No sé qué hago";
  $person->years_old = 21;
  $person->username = "lmendoza27";
  $person->save(); */


  //return $s;
    //dd($s);
    //dd($users);
}


    public function gmails3() {
      error_reporting(0);
      $s=Dni::all()->unique('email_owner');

      foreach(Dni::all()->unique('email_owner') as $filas) {
         echo 'la mascota del correo '.$filas->email_owner.' es '.$filas->gender_pet;
            if (Person::where('email', '=', $filas->email_owner)->exists()) {
            echo " (Usuario encontrado)";
         }else {
             echo " (Usuario no encontrado) / Se creará el siguiente usuario:".strstr($filas->email_owner, '@', true);
             $users = Dni::select(
              "dnis.name_pet", 
              "dnis.lastname_pet",
              "people.username", 
              "people.name"
            )
              ->join("people", "people.email", "=", "dnis.email_owner")
              ->where('people.email', $filas->email_owner)
              ->get();
                if (Person::where('username', '=', strstr($filas->email_owner, '@', true) )->exists()) {


                    
                $numItems = count($users);
                $i = 0;
                $totalline = "";
                  if($numItems > 1) {     
                  //echo 'Tus mascotas: ';
                foreach ($users as $age => $val) {
                  if (--$numItems <= 0) {
                }else {
                !empty($totalline) ? $totalline .= ", ". $val->name_pet : $totalline = "".$val->name_pet;
                }   

                }
                //echo '<b>'.$totalline.'</b>';
                $last = count($users) - 1;
                //echo ' & '.'<b>'.$users[$last]->name_pet.'</b>'.' te están esperando.';
                $mensaje_mascot = 'Tus mascotas: '.'<b>'.$totalline.'</b>'.' & '.'<b>'.$users[$last]->name_pet.'</b>'.' te están esperando.';
                }else {
                  //echo 'Tu mascota '.'<b>'.$users[0]->name_pet.'</b>'.' te espera.';
                $mensaje_mascot = 'Tu mascota: '.'<b>'.$users[0]->name_pet.'</b>'.' te espera.';  
                }

                   $person = new Person;
                   $person->lastname = $filas->lastname_owner;
                   $person->name = $filas->name_owner;
                   $person->number = $filas->cellphone_owner;
                   $person->email = $filas->email_owner;
                   $person->password = "dadasdasdadadqw";
                   $person->description = "Apuestas p";
                   $person->years_old = 21;
                   $person->username = substr($filas->name_owner, 0, 2).strstr($filas->email_owner, '@', true).substr($filas->dni_number_pet, 0, 3);
                   $person->save();
                    $data = ['name' => $person->username, 'nombre' => $person->name, 'apellido' => $person->lastname, 'mensaje' => $mensaje_mascot];
                    Mail::to($person->email)->send(new TestMail($data));

                }else {
                    
                $numItems = count($users);
                $i = 0;
                $totalline = "";
                  if($numItems > 1) {     
                foreach ($users as $age => $val) {
                  if (--$numItems <= 0) {
                }else {
                !empty($totalline) ? $totalline .= ", ". $val->name_pet : $totalline = "".$val->name_pet;
                }   
                }
                $last = count($users) - 1;
                $mensaje_mascot = 'Tus mascotas: '.'<b>'.$totalline.'</b>'.' & '.'<b>'.$users[$last]->name_pet.'</b>'.' te están esperando.';
                }else {
                $mensaje_mascot = 'Tu mascota: '.'<b>'.$users[0]->name_pet.'</b>'.' te espera.';  
                }
                    $person = new Person;
                    $person->lastname = $filas->lastname_owner;
                    $person->name = $filas->name_owner;
                    $person->number = $filas->cellphone_owner;
                    $person->email = $filas->email_owner;
                    $person->password = "dadasdasdadadqw";
                    $person->description = "Apuestas p";
                    $person->years_old = 21;
                    $person->username = strstr($filas->email_owner, '@', true);
                    $person->save();
                      $data = ['name' => $person->username, 'nombre' => $person->name, 'apellido' => $person->lastname, 'mensaje' => $mensaje_mascot];
                      Mail::to($person->email)->send(new TestMail($data));
                }
         }
        echo '<br>';

      }

    }

    public function gmails2() {
        $data = ['name' => 'Luis'];
        Mail::to('lmendoza27@autonoma.edu.pe')->send(new TestMail($data));
    }
    public function check_if_email_is_real() {
      $email = "sdada@autonoma.edu.pe";
      // Esto solo comprueba que el correo tenga los estándares y convención necesarios para considerarse un correo como tal....
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "$email is a valid email address";
      } else {
        echo "$email is not a valid email address";
    }
  }



    public function mismascotas () {
    $users = Dni::select(
        "dnis.name_pet", 
        "dnis.lastname_pet",
        "people.username", 
        "people.name"
    )
    ->join("people", "people.email", "=", "dnis.email_owner")
    //->where('people.email', 'joseph2019@gmail.com')
    ->where('people.email', 'lmendoza27@autonoma.edu.pe')
    ->get();

//dd($users);
      $numItems = count($users);
      $i = 0;
      $totalline = "";
      if($numItems > 1) {     
      echo 'Tus mascotas: ';
    //  if ($numItems > 1) {
        //echo "Hay más";
    //  }else {
        //echo "No";
  //    }



foreach ($users as $age => $val) {
    //echo $age->name_pet;
    //echo array_key_last($age->name_pet);  // No funca

    //!empty($totalline) ? $totalline .= ", ". $val->name_pet : $totalline = "".$val->name_pet;
    //echo $totalline;  
    if (--$numItems <= 0) {
       // break;
    }else {
    //
     /* echo $val->name_pet;
      $i = $i + 1;
      if ($i < $numItems) {
        echo ', ';
      }*/
    //
    //echo $val->name_pet.', '; 
    
    //$ronda = $val->name_pet. ', ';
    !empty($totalline) ? $totalline .= ", ". $val->name_pet : $totalline = "".$val->name_pet;
    //echo implode(', ', array_unique(explode(', ', $ronda)));
   /* if(!end($val)) {
      $ronda = ', ';
      echo $ronda;
    }*/
    //echo rtrim($ronda, "");
     
    }
    
   if ($i == count( $users ) - 1) {
     // echo 'y '.$val->name_pet;
      //$pasada .= $val->name_pet;
    }

    $i = $i + 1;

}
echo '<b>'.$totalline.'</b>';
//$users = array_key_last($users);
//echo ' y '.$users[2]->name_pet;
$last = count($users) - 1;
echo ' & '.'<b>'.$users[$last]->name_pet.'</b>'.' te están esperando.';

    }else {
      //echo "No";
      echo 'Tu mascota '.'<b>'.$users[0]->name_pet.'</b>'.' te espera.';
    }
 
 
 
  }
     
//$s=Dni::all()->unique('email_owner');

//dd($s);

/*foreach ($s as $age)
    echo $age->name_pet;
    }*/

}
