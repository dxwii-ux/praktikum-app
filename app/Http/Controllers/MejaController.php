<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function meja(){
        $meja = Meja::all();
        return view('meja',[
            'mejaa' => $meja
        ]);
    }
    public function index(){
        $mejaa = new Meja();

        $data_meja = $mejaa->paginate(10);

        $no_meja = $mejaa->all()->last();
        $no =$no_meja->no_meja;
        $no = substr($no,2);
        $no = intval($no)+1;
        switch(true){
            case $no < 10:
                $no ="M-00".$no;
                break;
            case $no < 100:
                $no ="M-0".$no;
                break;
            default:
                $no ="M-".$no;
                break;
        }


        return view('meja',[
            'meja'=>$data_meja,
            'no_meja'=>$no
        ]);
    }

    public function simpan(Request $request){
        $request->validate([
            'no_meja'=>'required',
            'kapasitas'=>'required',
            'status'=>'required'
        ]);


        $mejaa = new Meja();
        if($mejaa->create($request->all())){
            return redirect('/meja')->with('pesan','Data Berhasil ditambahkan');
        }
        return back()->with('pesan','Data gagal ditambahkan');
    }

    public function edit($no){

        $mejaa = new Meja();
        $edit_meja = $mejaa->find($no);

        $data_meja = $mejaa->paginate(10);
        return view('meja',[
            'meja'=>$data_meja,
            'edit'=>$edit_meja
        ]);
    }
    public function update(Request $request, $no){
        $request->validate([
            'kapasitas'=>'required',
            'status'=>'required'
        ]);

        $mejaa = new Meja();
        $mejaa->find($no)->update($request->all());
        return redirect('meja');
    }
    public function delete($no){
        $mejaa = new Meja();
        $mejaa->find($no)->delete();
        return redirect('meja');
    }
}
