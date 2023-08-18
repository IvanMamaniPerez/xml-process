<?php

namespace App\Http\Controllers;

use App\Events\XMLUploadedEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use SimpleXMLElement;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $path = "F:\pruebas\idbi\api-idbi\storage\app/xmlFiles/XML64defa6c0c675418075934.xml";
        $xmlContent = file_get_contents($path);
        $xml = new SimpleXMLElement($xmlContent);
        $namespaces = $xml->getNamespaces(true);

        $cbcNamespace = $namespaces['cbc'];

        $notes = $xml->xpath('//cbc:Note');
        dd($xml->comment, $notes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'xmlFile' => 'required|file|mimes:xml|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        if ($request->hasFile('xmlFile')) {

            $xmlFile = $request->file('xmlFile');
            $fileName = str_replace('.', '', uniqid('XML', true))  . '.xml';
            $path = $xmlFile->storeAs('xmlFiles', $fileName, 'local');

            event(new XMLUploadedEvent());
            $xmlContent = file_get_contents(storage_path('app/'.$path) );
            $xml = new SimpleXMLElement($xmlContent);
            $namespaces = $xml->getNamespaces(true);

            $cbcNamespace = $namespaces['cbc'];

            $notes = $xml->xpath('//cbc:Note');
            return response()->json([
                "data" => $notes,
                'message' => 'File XML uploaded successfully, it is being processed in the background'
            ]);
        } else {
            return response()->json(['error' => "XML not founded in request"], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
