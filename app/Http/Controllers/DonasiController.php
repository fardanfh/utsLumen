<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DonasiController extends Controller
{
    
    public function index(Request $request)
    {
        
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            if ($request->program_id) {
                $donate = Donasi::Where(['program_id' => $request->program_id])->OrderBy("id", "ASC")->paginate(2)->toArray();
                
            }else{
                $donate = Donasi::OrderBy("id", "ASC")->paginate(2)->toArray();
            }

            $response = [
                "total_count" => $donate["total"],
                "limit" => $donate["per_page"],
                "pagination" => [
                    "next_page" => $donate["next_page_url"],
                    "current_page" => $donate["current_page"]
                ],
                "data" => $donate["data"],
            ];

            if ($acceptHeader === 'application/json') {
                return response()->json($response, 200);
            } else {
                return response()->xml($response);
            }
        } else {
            return response('Not Acceptable', 406);
        }

    }

    public function store(Request $request)
    {

        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $input = $request->all();

            $validationRules =[
                'program_id' => 'required',
                'users_id' => 'required',
                'id_transaksi' => 'required',
                'nama_donatur' => 'required|min:5',
                'email' => 'required',
                'nominal_donasi' => 'required',
                'dukungan' => 'required|min:5',
                'bukti_pembayaran' => 'required',
                'isVerified' => 'required',
            ];

            $validator = Validator::make($input, $validationRules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            
            $donate = Donasi::create($input);
            

            if ($acceptHeader === 'application/json') {
                return response()->json($donate, 200);
            } else {
                return response()->xml($donate);
            }
        } else {
            return response('Not Acceptable', 406);
        }

    }

    public function detail($id, Request $request)
    {

        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            $donate = Donasi::find($id);

            if ($acceptHeader === 'application/json') {
                 return response()->json($donate, 200);
            } else {
                 return response()->xml($donate);
            }
        } else {
            return response('Not Acceptable', 406);
        }
        
    }

    public function update(Request $request ,$id)
    {

        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $input = $request->all();
            $donate = Donasi::find($id);

            if (!$donate) {
                abort(404);
            }

            $validationRules =[
                'program_id' => 'required',
                'users_id' => 'required',
                'id_transaksi' => 'required',
                'nama_donatur' => 'required|min:5',
                'email' => 'required',
                'nominal_donasi' => 'required',
                'dukungan' => 'required|min:5',
                'bukti_pembayaran' => 'required',
                'isVerified' => 'required',
            ];

            $validator = Validator::make($input, $validationRules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $donate->fill($input);
            $donate->save();

            $contentTypeHeader = $request->header('Content-Type');

            if ($acceptHeader === 'application/json') {

                if ($contentTypeHeader === 'application/json') {
                    return response()->json($donate, 200);
                }else{
                     return response('Unsupported Media Type', 415);
                }

                
            } else if ($contentTypeHeader === 'application/xml') {
                if ($contentTypeHeader === 'application/xml') {
                    return response()->xml($donate);
                }else{
                    return response('Unsupported Media Type', 415);
                }
            }  
            
        } else {
            return response('Not Acceptable', 406);
        }

    }

    public function delete($id, Request $request)
    {

        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $donate = Donasi::find($id);

            if (!$donate) {
                abort(404);
            }

            $donate->delete();

            if ($acceptHeader === 'application/json') {
                $outPut = [
                    "message" => "delete Successfully",
                    "donasi_id" => $id
                ];

                return response()->json($outPut, 200);
            } else {
                $xml = new \SimpleXMLElement('<donate/>');

                $xmlItem = $xml->addChild('donasi');
                $xmlItem->addChild('id', $donate->$id);
                $xmlItem->addChild('message', 'delete succesfully');
                
                return $xml->asXML();
            }
        } else {
            return response('Not Acceptable', 406);
        }

    }

}
