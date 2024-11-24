<?php

namespace Modules\Main\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Nwidart\Modules\Facades\Module;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::all();
        return view('main::admin.modules.all-modules', [
            'modules' => $modules
        ]);
    }

    public function disable($moduleName)
    {
        $module = Module::find($moduleName);

        if (Module::canDisable($moduleName)) {
            $module->disable();
        }

        return back();
    }
    public function enable($moduleName)
    {
        $module = Module::find($moduleName);

        if (Module::canDisable($moduleName)) {
            $module->enable();
        }

        return back();
    }
}
