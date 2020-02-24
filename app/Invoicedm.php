<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Codedm;

class Invoicedm extends Model
{

    public function codedm()
    {
        return $this->belongsTo(Codedm::class);
    }

    public static function add($codes, $invoice_id)
    {
        $result = [];
        foreach ($codes as $code) {
            $InvoiceDM = new Invoicedm;
            $InvoiceDM->invoce_id = $invoice_id;
            $InvoiceDM->codedm_id = $code->id;
            $InvoiceDM->save();
            $code->status['name'] = 'Invoice';
            $code->status->save();
            array_push($result, $InvoiceDM);
        }

        return $result;
    }

    public static function getCodedmByInvoiceId($id)
    {
        $result = static::where('invoce_id', $id)->get();
        $codedms = [];
        foreach($result as $item) {
            array_push($codedms, $item->codedm);
        }
        return $codedms;
    }
}
