<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ScreenshotController extends Controller
{
    public function index() {
        return view('index');
    }
    
    public function process() {
         try {
            set_time_limit(0);
            $data = Input::all();

            $browsershot = new \Spatie\Browsershot\Browsershot();

            $browsershot->setQuality($data['quality']);

            if ($data['time'] == 'immediately') {
                $browsershot->setTimeout(1000);
            } else {
                $browsershot->setTimeout($data['delay_time'] * 1000);
            }

            /**
             * screen all page or partial
             */
            if ($data['size'] == 'allPage' || !$data['pageSizeY']) {
                $browsershot->setHeightToRenderWholePage();
                $browsershot->setWidth(2000); // by default
            } else {
                $browsershot->setWidth($data['pageSizeX']);
                $browsershot->setHeight($data['pageSizeY']);
            }

            /**
             * for windows set exe binary
             */
            if (PHP_OS == 'WINNT') {
                $browsershot->setBinPath(storage_path() . '\app\phantomjs.exe');
            }

            $url = $data['url'];
            $fileName = parse_url($url, PHP_URL_HOST) . parse_url($url, PHP_URL_PATH) . '_' . date('m-d-Y-His') . '.' . $data['extension'];
            $browsershot->setURL($url);

            /**
             * Run
             */
            dump($fileName);
            $browsershot->save('./' . $fileName);

            return $fileName;
        } catch (\Exception $e) {
            dd($e);
        }
    }
    
    public function allWidgets() {
        set_time_limit(0);
       
        $width = Input::get('width') ? : 1024;
        $height = Input::get('height') ? : 768;
        $timeout = Input::get('timeout') ? : 15000;
        
        $browsershot = new \Spatie\Browsershot\Browsershot();
        $browsershot->setWidth($width)
                ->setHeight($height)
                ->setTimeout($timeout);

        if (PHP_OS == 'WINNT') {
            $browsershot->setBinPath(storage_path() . '\app\phantomjs.exe');
        }
            
        for ($i = 1700; $i > 0; $i--) {
            echo $i . PHP_EOL;
            $browsershot->setURL('http://cp.profseller.net/demoPreview/' . $i)
                    ->save('screens/' . $i . '.png');
        }   
    }
}
