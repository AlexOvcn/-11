<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use App\Models\GalleryAuto;
use Illuminate\Http\Request;

class AutoController extends Controller
{

    public function index()
    {
        return view('cars.index', [
            'page' => 'Все записи автомобилей',
            'auto' => Auto::all()
        ]);
    }

    public function create()
    {
        return view('cars.create', [
            'page' => 'Добавление новой машины'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:auto'
        ]);

        if ($request->image_path === null) {
            $image_path = 'assets/img/auto_notFound.jpg';
        } else {
            $image_path = Auto::saveImage($request->image_path);
        }
        Auto::create([
                'name' => $request->name,
                'image_path' => $image_path,
                'description' => $request->description,
                'price' => $request->price
        ]);

        if ($request->hasFile('imagesForGallery')) {
            $galleryAuto = new GalleryAuto();
            $auto = Auto::all()->where('name', '=', $request->name);

            for ($i = 0; $i < count($request->File('imagesForGallery')); $i++) {
                $galleryAuto->image_path_array[$i] = $galleryAuto->saveImage($request->File('imagesForGallery')[$i]);
            }

            GalleryAuto::create([
                'auto_id' => $auto->first()->id,
                'image_path_1' => $galleryAuto->image_path_array[0],
                'image_path_2' => isset($galleryAuto->image_path_array[1]) ? $galleryAuto->image_path_array[1] : null,
                'image_path_3' => isset($galleryAuto->image_path_array[2]) ? $galleryAuto->image_path_array[2] : null,
            ]);
        }

        return redirect()->route('cars.index');
    }

    public function show($id)
    {
        $auto = Auto::find($id);
        return view('cars.show', [
            'page' => 'Информация о машине "' . $auto->name . '"',
            'auto' => $auto,
            'autoImages' => GalleryAuto::all()->where('auto_id', '=', $id)->first()
        ]);
    }

    public function edit($id)
    {
        $auto = Auto::find($id);
        return view('cars.edit', [
            'page' => 'Изменение записи о машине "' . $auto->name . '"',
            'auto' => $auto,
            'autoImages' => GalleryAuto::all()->where('auto_id', '=', $id)->first()
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:auto,id,' . Auto::find($id)->id
        ]);

        if ($request->image_path === null) {
            $image_path = 'assets/img/auto_notFound.jpg';
        } else {
            $image_path = Auto::saveImage($request->image_path);
        }
        Auto::find($id)->update([
                'name' => $request->name,
                'image_path' => $image_path,
                'description' => $request->description,
                'price' => $request->price
        ]);

        $galleryAuto = new GalleryAuto();
        $auto = Auto::all()->where('name', '=', $request->name)->first();

        if ($request->File('imagesForGallery') !== null) {
            for ($i = 0; $i < count($request->File('imagesForGallery')); $i++) {
                $galleryAuto->image_path_array[$i] = $galleryAuto->saveImage($request->File('imagesForGallery')[$i]);
            }
        }

        GalleryAuto::updateOrCreate(['auto_id' => $auto->id], [
            'auto_id' => $auto->id,
            'image_path_1' => isset($galleryAuto->image_path_array[0]) ? $galleryAuto->image_path_array[0] : null,
            'image_path_2' => isset($galleryAuto->image_path_array[1]) ? $galleryAuto->image_path_array[1] : null,
            'image_path_3' => isset($galleryAuto->image_path_array[2]) ? $galleryAuto->image_path_array[2] : null
        ]);

        return redirect()->route('cars.index');
    }

    public function destroy($id)
    {
        $auto = Auto::find($id);
        $auto->delete();

        return back();
    }
}
