<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\companyModel;
use App\monthModel;
use App\placeModel;
use App\summarydataModel;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class mainController extends Controller
{
    public function index()
    {
//        Excel::create('New file', function($excel) {
//
//            $excel->sheet('New sheet', function($sheet) {
//
//                $sheet->loadView('index');
//
//            });
//
//        });

        $company = new companyModel();
        $companyR = $company->get();
        return view('index', ['company' => $companyR]);

    }

    public function month(Request $r)
    {
        session(['companyID' => $r->companyID]);
        $month = new monthModel();
        $monthR = $month->where('companyID', '=', $r->companyID)->get();
        $place = new placeModel();
        $placeR = $place->where('companyID', '=', $r->companyID)->first();
        return view('month', ['month' => $monthR, 'place' => $placeR]);
    }

    public function addSummary(Request $r)
    {
        $month = new monthModel();
        $month->insert([
            'monthID' => 'month'.uniqid(),
            'name' => $r->input('month'),
            'companyID' => Session::get('companyID'),
            'remove' => false
        ]);
        return redirect()->back();
    }

    public function summary(Request $r)
    {
        $place = new  placeModel();
        $placeR = $place->where('companyID', '=', Session::get('companyID'))
            ->where('remove', '=', 'false')->get();
        return view('summary', ['place' => $placeR, 'summaryID' => $r->summaryID]);
    }

    public function summaryDataAdd(Request $r)
    {
        $summarydata = new summarydataModel();
        $aaa =[];
        foreach ($r->input('date') as $index=>$value)
        {
            $summarydata->insert([
                'placeID' => $r->place,
                'summarydataID' => 'summarydata'.uniqid(),
                'datecreate' => $r->input('datecreate'),
                'no' =>  $index + 1,
                'date' => $r->input('date')[$index],
                'dono' =>$r->input('dono')[$index],
                'vechile' => $r->input('vechile')[$index],
                'loads' => $r->input('loads')[$index],
                'unload' => $r->input('unload')[$index],
                'quantity' => $r->input('quantity')[$index],
                'price' => $r->input('price')[$index],
                'total' => $r->input('total')[$index],
                'timein' => $r->input('timein')[$index],
                'timeout' => $r->input('timeout')[$index],
                'cycletime' => $r->input('cycletime')[$index],
            ]);
        }
        return redirect()->back();
    }

    public function createExcel()
    {

        // 生成文件
        Excel::create('Filename', function ($excel)
        {
            // 设置文档标题和作者
            $excel->setTitle('Our new awesome title');
            $excel->setCreator('Maatwebsite')
                ->setCompany('Maatwebsite');
            // 设置文档描述
            $excel->setDescription('A demonstration to change the file properties');
            // 创建工作表
            $excel->sheet('Sheetname', function ($sheet)
            {
                // 通过数组写入值（二维数组）
                $sheet->fromArray($array);
                // 给第一行写入值（一维数组）
                $sheet->row(1, $array);
                // 设置某一列的宽
                $sheet->setWidth('A', 5);
                // 批量设置列宽
                $sheet->setWidth([
                    'A' => 5,
                    'B' => 10
                ]);
            });
        });
// 生成为指定的格式并下载
        Excel::create()->export('xls');
// 生成为指定的格式并存储在app/storage/exports目录
        Excel::create()->store('xls');
// 生成为指定的格式并存储在指定的目录
        Excel::create()->store('xls', storage_path('excel/exports'));
// 存储后返回文件数据（包含路径等）
        Excel::create()->store('xls', false, true);
    }
}
