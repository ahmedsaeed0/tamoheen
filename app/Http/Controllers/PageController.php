<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $pages = Page::latest()->paginate(25);
        return view('pages.index', compact('pages'));
    }

    public function create()
    {
        return view('pages.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'          => 'required|string',
            'title_arabic'   => 'required|string',
            'content'        => 'required|string',
            'content_arabic' => 'required|string',
        ]);

        $requestData = $request->all();
        Page::create($requestData+['slug' => Str::slug($requestData['title'])]);
        return redirect('pages')->with('success', 'Page created');
    }

    public function show($id)
    {
        $page = Page::findOrFail($id);
        return view('pages.show', compact('page'));
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'          => 'string',
            'title_arabic'   => 'string',
            'content'        => 'string',
            'content_arabic' => 'string',
        ]);

        $requestData = $request->all();
        $page = Page::findOrFail($id);
        if(isset($requestData['title']) && $requestData['title'] != null){
            $page->update($requestData + ['slug' => Str::slug($requestData['title'])]);
        }else{
            $page->update($requestData);
        }
        return redirect('pages')->with('success', 'Page updated');
    }

    public function destroy($id)
    {
        Page::destroy($id);
        return redirect('pages')->with('success', 'Page deleted');
    }

    public function deactivePage($id)
    {
        $page = Page::findOrFail($id);
        $page->status = 0;
        $page->save();
        return redirect('pages')->with('success', 'Page Deactivated');
    }

    public function activePage($id)
    {
        $page = Page::findOrFail($id);
        $page->status = 1;
        $page->save();
        return redirect('pages')->with('success', 'Page Activated');
    }
}
