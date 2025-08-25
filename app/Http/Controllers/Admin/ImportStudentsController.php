<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ImportStudentsController extends Controller
{
    public function show()
    {
        return view('admin.import.show');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('csv')->getRealPath();
        $fh = fopen($file, 'r');
        $header = fgetcsv($fh);
        $map = array_flip($header);

        $required = ['email','access_start','access_end'];
        foreach($required as $col){
            if(!isset($map[$col])){
                return back()->with('err', 'Thiếu cột bắt buộc: '.$col);
            }
        }

        $count = 0;
        while(($row = fgetcsv($fh)) !== false){
            $email = trim($row[$map['email']]);
            if(!$email) continue;
            $name  = isset($map['name']) ? trim($row[$map['name']]) : null;
            $start = trim($row[$map['access_start']]);
            $end   = trim($row[$map['access_end']]);

            $u = User::firstOrNew(['email'=>$email]);
            if(!$u->exists){
                $u->name = $name ?: $email;
                $u->password = Hash::make('password'); // force reset later
            }else{
                if($name) $u->name = $name;
            }
            $u->access_starts_at = $start ? \Carbon\Carbon::parse($start) : null;
            $u->access_ends_at   = $end ? \Carbon\Carbon::parse($end) : null;
            $u->is_active = true;
            $u->save();
            $count++;
        }
        fclose($fh);

        return back()->with('ok', "Đã import {$count} học sinh");
    }
}
