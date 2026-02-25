<?php

namespace App\Http\Controllers;

use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PageContentTranslation;

class PageContentController extends Controller
{
    public function updatePageContent(Request $request)
    {
        try {
            DB::beginTransaction();

            $lang = $request->input('lang', defaultLangCode());
            $defaultLang = defaultLangCode();

            foreach ($request->except(['_token', 'lang', 'page']) as $key => $value) {
                if ($lang == $defaultLang) {
                    PageContent::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value]
                    );
                } else {
                    PageContentTranslation::updateOrCreate(
                        ['key' => $key, 'lang' => $lang],
                        ['value' => $value]
                    );
                }
            }

            DB::commit();
            toastNotification('success', 'Page Content Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            toastNotification('error', 'Page Content Update Failed', 'Error');
            return redirect()->back();
        }
    }

    public function homePageContent(Request $request)
    {
        $lang = $request->lang ?? defaultLangCode();
        return view('backend.modules.page_content.home', ['lang' => $lang]);
    }

    public function aboutPageContent(Request $request)
    {
        $lang = $request->lang ?? defaultLangCode();
        return view('backend.modules.page_content.about', ['lang' => $lang]);
    }

    public function contactPageContent(Request $request)
    {
        $lang = $request->lang ?? defaultLangCode();
        return view('backend.modules.page_content.contact', ['lang' => $lang]);
    }
}
