<?php

namespace App\Http\Controllers;


use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            if ($request->users_id) {
                $programs = Program::Where(['users_id' => $request->users_id])->OrderBy("id", "ASC")->paginate(2)->toArray();
                
            }else{
                $programs = Program::OrderBy("id", "ASC")->paginate(2)->toArray();
            }

            $response = [
                "total_count" => $programs["total"],
                "limit" => $programs["per_page"],
                "pagination" => [
                    "next_page" => $programs["next_page_url"],
                    "current_page" => $programs["current_page"]
                ],
                "data" => $programs["data"],
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
                'users_id' => 'required',
                'category_id' => 'required',
                'judul' => 'required|min:5',
                'gambar' => 'required',
                'ajakan' => 'required|min:5',
                'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required',
                'no_rekening' => 'required',
                'target_donasi' => 'required',
                'terkumpul' => 'required',
                'deskripsi' => 'required|min:5',
                'isPublished' => 'required',
            ];

            $validator = Validator::make($input, $validationRules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            
            $programs = Program::create($input);

            if ($acceptHeader === 'application/json') {
                return response()->json($programs, 200);
            } else {
                return response()->xml($programs);
            }
        } else {
            return response('Not Acceptable', 406);
        }

    }

    public function detail($id, Request $request)
    {

        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            $programs = Program::find($id);

            if ($acceptHeader === 'application/json') {
                 return response()->json($programs, 200);
            } else {
                 return response()->xml($programs);
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
            $programs = Program::find($id);

            if (!$programs) {
                abort(404);
            }

            $validationRules =[
                'users_id' => 'required|',
                'category_id' => 'required',
                'judul' => 'required|min:5',
                'gambar' => 'required',
                'ajakan' => 'required|min:5',
                'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required',
                'no_rekening' => 'required',
                'target_donasi' => 'required',
                'terkumpul' => 'required',
                'deskripsi' => 'required|min:5',
                'isPublished' => 'required',
            ];

            $validator = Validator::make($input, $validationRules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $programs->fill($input);

            $programs->save();

            $contentTypeHeader = $request->header('Content-Type');

            if ($acceptHeader === 'application/json') {
                return response()->json($programs, 200);
            } else {
                return response()->xml($programs);
            }
            
        } else {
            return response('Not Acceptable', 406);
        }

    }

    public function delete($id, Request $request)
    {

        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $programs = Program::find($id);

            if (!$programs) {
                abort(404);
            }

            $programs->delete();

            if ($acceptHeader === 'application/json') {
                $outPut = [
                    "message" => "delete Successfully",
                    "program_id" => $id
                ];

                return response()->json($outPut, 200);
            } else {
                $xml = new \SimpleXMLElement('<posts/>');

                $xmlItem = $xml->addChild('post');
                $xmlItem->addChild('id', $programs->id);
                $xmlItem->addChild('message', 'delete succesfully');
                
                return $xml->asXML();
            }
        } else {
            return response('Not Acceptable', 406);
        }

    }
}
