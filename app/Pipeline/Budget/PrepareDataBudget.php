<?php
    namespace App\Pipeline\Budget;
    
    class PrepareDataBudget {
        public function handle($Data, $next) {
            $action = $Data['action'];
            $voucher = $Data['voucher'];
            $request = $Data['request'];

            if( $action == null ) {
                $document_path = null;
                if( $request->hasFile('document') ){
                    $document = $request->file('document');
                    $destination_path = env('PUBLIC_PATH').'Document/Budget/';
                    $filename = preg_replace("/[^a-z0-9\_\-\.]/i", '-', time() . '-' . $document->getClientOriginalName());
                    $document->move($destination_path, $filename);
                    $document_path = 'Document/Budget/'.$filename;
                }
                
                $request = $request->all();
                $request['document_path'] = $document_path;
                $request['budget_in_amount'] = str_replace(',','', $request['budget_in_amount']);
            }

            $request['voucher'] = str_replace('-','/', $voucher);
            $request['LastEditedBy'] = auth()->user()->UserId;
            $request['LastEdited'] = now()->format('Y-m-d');
            $request['LastEditedTime'] = now()->format('H:i:s');

            $Data['request'] = $request;

            dd($Data);
            
            return $next($Data);
        }
    }
?>