<?php
// include_once('./semacode.php');
namespace App\Http\Controllers;



use Illuminate\Http\Request;
// 
use App\Http\Controllers\Semacode;
class BarcodeController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function getBarcode(Request $request)
    {
        \Log::debug('getBarcode');
        \Log::debug(Semacode::class);
        \Log::debug($request->codedm);
        // $text = $request->codedm;
        $text = "asdsadsdasasassadasdsaas";
        $type = 'svg';
        $size = 160;
        if (!$size) $size = 160;

        $result = '';

        // strip non-supported chars (is this correct?)
        $text = preg_replace('/[^\w!\"#$%&\'()*+,\-\.\/:;<=>?@[\\_\]\[{\|}~\r*]+ /', '', $text);

        // encode
        $semacode = new Semacode();

        if ($type == 'png') {
            $semacode->sendPNG($text, $size);
        } elseif ($type == 'svg') {
            // header('Content-Type: image/svg');
            $result = $semacode->asSVG($text);
            \Log::debug($result);
            response()->view('barcode', $result, 200)
                      ->header('Content-Type', 'image/svg');
        } else {
            echo '<html><body>';
            echo $semacode->asHTMLTable($text);
            echo '</body></html>';
        }
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
