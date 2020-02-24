<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Package;
use App\Packagedm;
use App\Box;
use App\Boxean13;

use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    public static function add($codeean13, $invoice)
    {

        DB::beginTransaction();
        $existInvoce = static::where('number', $invoice)->get()->first();
        // $errors = [];
        $package_error = [];
        $box_error = [];
        $codedms_result = [];
        $packages = [];
        if ($existInvoce === null) {
            foreach ($codeean13 as $code) {
                \Log::debug('code');
                \Log::debug($code);
                $sufix = substr($code['codeean13'], 0, 3);
                \Log::debug('sufix');
                \Log::debug($sufix);
                switch ($sufix) {
                    case "241":
                        $package =  Package::getByEAN($code);
                        if ($package !== null) {
                            // $package->status;
                            \Log::debug('package');
                            \Log::debug($package);
                            switch ($package->status['name']) {
                                case 'Package Invoice':
                                    \Log::debug('status');
                                    \Log::debug($package->status);
                                    array_push($package_error, ['msg' => 'Package previously added', 'package' => $package]);
                                    break;
                                default:
                                    \Log::debug('status');
                                    \Log::debug($package->status);
                                    $package->status['name'] = 'Package Invoice';
                                    $package->status->save();
                                    array_push($packages, $package);
                                    break;
                            }
                        } else {
                            array_push($package_error, ['msg' => 'This package not exist', 'package' => $code]);
                        }
                        break;
                    case "242":
                        $box = Box::getByEAN($code);
                        \Log::debug('box');
                        \Log::debug($box);
                        \Log::debug('status');
                        \Log::debug($box->status);
                        if ($box !== null) {
                            switch ($box->status['name']) {
                                case 'Box Invoice':
                                    array_push($box_error, ['msg' => 'Box previously added', 'package' => $box]);
                                    break;
                                default:
                                    $box->status['name'] = 'Box Invoice';
                                    $box->status->save();
                                    $result = Boxean13::getByBoxId($box->id);
                                    foreach ($result as $pack) {
                                        \Log::debug('pack');
                                        \Log::debug($pack);
                                        $boxPackage = Package::where('id', $pack->packages_id)->get()->first();
                                        \Log::debug('package in box');
                                        \Log::debug($boxPackage);
                                        array_push($packages, $boxPackage);
                                    }
                                    break;
                            }
                        } else {
                            array_push($box_error, ['msg' => 'This box not exist', 'box' => $code]);
                        }
                        break;
                    default:

                        break;
                }
            }
            \Log::debug('packages');
            \Log::debug(json_encode($packages));

            $ids = [];
            \Log::debug(count($packages));
            foreach($packages as $item) {
                \Log::debug('item');
                \Log::debug($item);
                \Log::debug($item->id);
                array_push($ids,$item->id);
            }
            // \Log::debug();

            $unique = count(array_unique($ids)) === count($packages);

            \Log::debug('unique');
            \Log::debug($unique);

            if (count($box_error) === 0 && count($package_error) === 0 && $unique ) {

                DB::commit();

                foreach ($packages as $pack) {
                    $codedms = Packagedm::getByPackageId($pack->id);
                    foreach ($codedms as $codedm) {
                        \Log::debug($codedm->codedm);
                        array_push($codedms_result, $codedm->codedm);
                    }
                }


                \Log::debug('erorrs');
                \Log::debug($box_error);
                \Log::debug($package_error);
                $Invoice = new Invoice;
                $Invoice->number = $invoice;
                $Invoice->save();
                Invoicedm::add($codedms_result, $Invoice->id);
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getByInvoice($invoice)
    {
        $inv = static::where('number', $invoice)->get()->first();
        if ($inv !== null) {
            return ['result' => true, 'invoice' => Invoicedm::getCodedmByInvoiceId($inv->id)];
        } else {
            return ['result' => false, 'msg' => 'Error input invoice'];
        }
    }
}
