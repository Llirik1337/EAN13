<?php

namespace App\Http\Controllers;

use App\Package;
use App\Packagedm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $codedms = $request->codedms;
        $msg = 'error missing codems array';
        if($codedms !== null) {
            $result = Package::add($codedms);
            return response()->json(['result' => $result]);
        } else {
            return response()->json(['msg'=> $msg]);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $codedms = $request->codedms;
        $ean13 = $request->ean13;
        $msg = 'error missing codems array';
        if($codedms !== null) {
            $result = Packagedm::checkDM($codedms);
            if ($result['result']) {
                Log::debug(json_encode($ean13));
                $package = Package::findByEan($ean13);
                if($package) {
                    $package->codedms;
                    $package->status;
                }
                Log::debug(json_encode($package));
                $package->store = false;
                $package->save();
                return response()->json(['result' => $package]);
            } else {
                return response()->json(['result' => $result]);
            }
        } else {
            return response()->json(['msg'=> $msg]);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $codedms = $request->codedms;
        $msg = 'error missing codems array';
        if($codedms !== null) {
            $result = Package::store($codedms);
            return response()->json(['result' => $result]);
        } else {
            return response()->json(['msg'=> $msg]);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function find(Request $request)
    {
        $ean13 = $request->ean13;
        $msg = 'error missing code ean';
        if($ean13 !== null) {
            $package = Package::findByEan($ean13);
            if($package) {
                $package->codedms;
                $package->status;
            }
            return response()->json(['result' => $package]);
        } else {
            return response()->json(['msg'=> $msg]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        //
    }
}
