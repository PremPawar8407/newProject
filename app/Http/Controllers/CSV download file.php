<?php
//csv download file controller.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Registration\LoginSessionService;
use App\Http\Services\Utility\ResponseUtility;
use App\Http\Services\Practice\PracticeServices;
use Validator;


class practiceController extends Controller
{
	 /**
     * @OA\Get(
     * path="/api/Export",
     * summary="List all studets",
     *   description="create folder<br/>
       Success Code:<br/>
       8000: Response-Note updated successfully.<br/>
       Error Code:<br/>
       10001: Invalid session-token or its expired.<br/>
       7008: Please enter a valid sort_column.<br/>
       7007: Please enter a valid order.<br/>
       7006: Please enter a valid status_value.<br/>
       ",
     * tags={"prem"},
     *  @OA\Parameter(
     *      name="session-token",
     *      in="header",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),  
     *  @OA\Parameter(
     *      name="sort_By",
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *          example="con_first_name/con_last_name"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="order",
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *          example="ASC/DESC"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="status",
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *          example="0/1"
     *      )
     *   ),
     * @OA\Response(
     *    response=422,
     *    description="Please enter a valid information",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */


           function export(Request $req)
       {
        $payload = $req->all();
        $sessionToken = $req->header('session-token');

        $loginSessionService = new LoginSessionService();
        $userData = json_decode($loginSessionService->getUserDataByToken($sessionToken));

        
        $sortByRules = ['sort_By' => 'required'];
        $orderRules  = ['order'   => 'required'];
        $statusRules = ['status'  => 'required'];

          $sortByValidation = Validator::make($req->all(), $sortByRules);
        if ($sortByValidation->fails()) 
        {
           return ResponseUtility::respondWithError(7008, null);
        }

          $orderValidation = Validator::make($req->all(), $orderRules);
        if ($orderValidation->fails()) 
        {
           return ResponseUtility::respondWithError(7007, null);
        }

         $statusValidation = Validator::make($req->all(), $statusRules);
        if ($statusValidation->fails()) 
        {
           return ResponseUtility::respondWithError(7006, null);
        }



        $PracticeServices = new PracticeServices;
        $result = $PracticeServices->exportservice($payload['sort_By'], $payload['order'], $payload['status']);

        return $result;

     
         
         

       }
    
}
?>


<?php

//csv download file services.


namespace App\Http\Services\Practice;

use App\Models\practiceModel;
use Illuminate\Support\Facades\Request;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;


class PracticeServices 
 
{
    public function exportservice($sortBY, $order, $status)
    {
        $Exports = new UsersExport($sortBY, $order, $status);

         return Excel::download($Exports,'UnsubscribedContactList.csv');
    }

}
?>

<?php
//csv download file Exports.

namespace App\Exports;

use App\Models\practiceModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class UsersExport implements FromCollection,WithHeadings
{
	protected $sortBY, $order;
	  public function __construct( $sortBY, $order, $status) 
	 {
        $this->sortBY = $sortBY;
        $this->order  = $order;
        $this->status = $status;
       
     }
	public function headings():array{
		return[
			'Id',
			'Phone Number',
			'First Name',
			'Last Name',
			'Status',
			'Email ID'
		];
	}
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
         return  DB::table('tbl_contacts')
        ->select('con_id', 'con_phone_number', 'con_first_name', 'con_last_name', 'con_status','con_email')
        ->orderBy($this->sortBY, $this->order)
        ->where('con_status',$this->status)
        ->get();
    }
}
?>

<?php
////csv download file Error.

$error_codes = [
		 "10001" => "Invalid session-token or its expired",
		 "7006"  => "Please enter a valid status_value",
         "7007"  => "Please enter a valid order",
         "7008"  => "Please enter a valid sort_column",
         ];
return $error_codes;

?>


<?php
//csv download file Route.


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\UserController;
use app\Http\Controllers\CategoryController;

Route::get('Export', 'App\Http\Controllers\practiceController@export')->middleware('check.headers.auth');
?>



