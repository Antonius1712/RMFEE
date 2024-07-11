<?php

namespace App\Http\Controllers;

use App\Enums\Database;
use App\Http\Requests\DocumentRequest;
use App\Model\ReportGenerator_Documents_Engineering_Fee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentYear = now()->year;
        $yearsBack = 2;
        $yearsAhead = 2;

        $startYear = $currentYear - $yearsBack;
        $endYear = $currentYear + $yearsAhead;

        $years = range($startYear, $endYear);

        $selected_years = $request->year;

        $Documents = ReportGenerator_Documents_Engineering_Fee::whereYear('uploadedAt', $selected_years)->get();
        return view('pages.documents.index', compact('Documents', 'years'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.documents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentRequest $request)
    {
        $document_path = null;
        if ($request->hasFile('document_file')) {
            $document_file = $request->file('document_file');
            $destination_path = env('PUBLIC_PATH') . 'PDF/Documents/' . now()->format('Y') . '/';
            $filename = preg_replace("/[^a-z0-9\_\-\.]/i", '-', time() . '-' . $document_file->getClientOriginalName());
            $document_file->move($destination_path, $filename);
            $document_path = 'PDF/Documents/' . now()->format('Y') . '/' . $filename;
        }

        DB::connection(Database::REPORT_GENERATOR)->statement(
            'EXEC [dbo].[SP_Insert_Documents_Engineering_Fee] @DocumentName = ?, @DocumentDescription = ?, @DocumentFile = ?, @UploadedBy = ?, @UploadedAt = ?',
            [
                $request->document_name,
                $request->document_description,
                $document_path,
                auth()->user()->UserId,
                now()
            ]
        );

        return redirect()->route('documents.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ReportGenerator_Documents_Engineering_Fee $Document)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportGenerator_Documents_Engineering_Fee $Document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportGenerator_Documents_Engineering_Fee $Document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportGenerator_Documents_Engineering_Fee $Document, Request $request)
    {
        $UrlParameter = http_build_query(json_decode($request->param));
        $Document->delete();
        $route = route('documents.index') . '?' . $UrlParameter;
        return redirect()->to($route);
    }
}
